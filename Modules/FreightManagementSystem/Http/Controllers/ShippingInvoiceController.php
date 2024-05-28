<?php

namespace Modules\FreightManagementSystem\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FreightManagementSystem\Entities\FreightBookingRequest;
use Modules\FreightManagementSystem\Entities\FreightShipping;
use Modules\FreightManagementSystem\Entities\FreightInvoice;
use Modules\FreightManagementSystem\Entities\FreightShippingService;
use Modules\FreightManagementSystem\Entities\FreightCustomer;
use Modules\FreightManagementSystem\Entities\FreightPayment;
use Modules\FreightManagementSystem\Entities\FreightShippingOrder;
use Illuminate\Support\Facades\Auth;
use Modules\FreightManagementSystem\Events\DestroyFreightInvoice;
use Modules\FreightManagementSystem\Events\FrieghtPaymentDestroyInvoice;
use Modules\FreightManagementSystem\Events\CreateFreightShippingInvoice;
use Illuminate\Support\Facades\Crypt;

class ShippingInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (Auth::user()->isAbleTo('freight invoice manage')) {
            $invoices = FreightInvoice::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get();
            return view('freightmanagementsystem::invoice.index', compact('invoices'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return redirect()->back();
        return view('freightmanagementsystem::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function payment($id)
    {
        if (Auth::user()->isAbleTo('freight invoice payment create')) {
            $invoice = FreightInvoice::where('id', $id)->first();
            return view('freightmanagementsystem::invoice.payment', compact('invoice'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
    public function createPayment(Request $request, $invoice_id)
    {
        if (Auth::user()->isAbleTo('freight invoice payment create')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'date' => 'required',
                    'amount' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $invoicePayment                 = new FreightPayment();
            $invoicePayment->invoice_id     = $invoice_id;
            $invoicePayment->date           = $request->date;
            $invoicePayment->amount         = $request->amount;
            $invoicePayment->reference      = $request->reference;
            $invoicePayment->description    = $request->description;
            $invoicePayment->workspace     = getActiveWorkSpace();
            $invoicePayment->created_by    = creatorId();
            if (!empty($request->add_receipt)) {
                $fileName = time() . "_" . $request->add_receipt->getClientOriginalName();
                $uplaod = upload_file($request, 'add_receipt', $fileName, 'payment');
                if ($uplaod['flag'] == 1) {
                    $url = $uplaod['url'];
                } else {
                    return redirect()->back()->with('error', $uplaod['msg']);
                }
                $invoicePayment->add_receipt = $url;
            }
            $invoicePayment->save();

            $invoice = FreightInvoice::where('id', $invoice_id)->first();
            $shipping=FreightShipping::where('id',$invoice->shipping_id)->first();
            $booking=FreightBookingRequest::where('id',$shipping->booking_id)->first();
            $due     = $invoice->getDue();
            if($due <=0)
            {
                if(!empty($shipping))
                {
                    $shipping->status = 4;
                    $shipping->invoice_status = 3;
                    $shipping->save();
                }
                if(!empty($booking))
                {
                    $booking->status=4;
                    $booking->save();
                }
                $invoice->status = 2;
            }
            else{
                if(!empty($shipping))
                {
                    $shipping->invoice_status = 2;
                    $shipping->save();
                }
                $invoice->status = 1;
            }
            
            $invoice->save();
            return redirect()->back()->with('success', __('Payment successfully added.'));
        }
    }
    public function invoice_save(Request $request, $id)
    {
        if (Auth::user()->isAbleTo('freight invoice create')) {
            $shipping = FreightShipping::find($id);
            if ($shipping->created_by == creatorId() && $shipping->workspace == getActiveWorkSpace()) {

                $totalSum = FreightShippingService::where('shipping_id', $shipping->id)
                    ->where('created_by', creatorId())
                    ->where('workspace', getActiveWorkSpace())
                    ->selectRaw('SUM(qty * sale_price) as total_sum')
                    ->value('total_sum');
                $order = FreightShippingOrder::where('shipping_id', $shipping->id)->where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->first();
                if(!empty($order))
                {
                    $order_price=$order->sale_price;
                }
                else{
                    $order_price=0;
                }
                $amount = $totalSum + $order_price;
                $invoice                = new FreightInvoice();
                $invoice->code          = FreightInvoice::freightCode();
                $invoice->shipping_id   = $shipping->id;
                $invoice->amount        = $amount;
                $invoice->customer_id   = $shipping->user_id;
                $invoice->status        = $shipping->invoice_status;
                $invoice->invoice_date  = $shipping->date;
                $invoice->due_date      = $shipping->date;
                $invoice->workspace     = getActiveWorkSpace();
                $invoice->created_by    = creatorId();
                $invoice->save();
                $shipping->invoice_status=1;
                $shipping->status=3;
                $shipping->save();
                FreightInvoice::starting_number($invoice->code + 1, 'freight-invoice');
                event(new CreateFreightShippingInvoice($shipping, $invoice));

                return redirect()->back()->with('success', __('Invoice successfully Created.'));
            } else {
                return redirect()->back()->with('error', __('Shipping not found denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function paymentDestroy($invoice_id, $payment_id)
    {
        if(Auth::user()->isAbleTo('freight invoice payment delete'))
        {
            $payment = FreightPayment::find($payment_id);
            if(!empty($payment->add_receipt))
            {
                try
                {
                    delete_file($payment->add_receipt);
                }
                catch (\Exception $e)
                {
                }
            }
            $invoice = FreightInvoice::where('id', $invoice_id)->first();
            $due     = $invoice->getDue();
            
                $invoice->status = 1;
            
            $invoice->save();
            event(new FrieghtPaymentDestroyInvoice($invoice, $payment));
            $payment->delete();
            return redirect()->back()->with('success', __('Payment successfully deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        if (Auth::user()->isAbleTo('freight invoice create')) {
            try {
                $id = Crypt::decrypt($id);
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', __('Invoice Not Found.'));
            }
            $invoice = FreightInvoice::where('id', $id)->where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->first();

            if ($invoice) {

                $customer = FreightCustomer::where('id', $invoice->customer_id)->where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->first();
                $shipping = FreightShipping::where('id', $invoice->shipping_id)->where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->first();
                $services = FreightShippingService::where('shipping_id', $invoice->shipping_id)->where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get();
                $order    = FreightShippingOrder::where('shipping_id', $invoice->shipping_id)->where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->first();
                $reciepts = FreightPayment::where('invoice_id', $invoice->id)->where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get();
                
                return view('freightmanagementsystem::invoice.view', compact('invoice', 'shipping', 'services', 'customer', 'order', 'reciepts'));
            } else {
                return redirect()->back()->with('error', __('Invoice Not Found.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return redirect()->back();
        return view('freightmanagementsystem::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        if (Auth::user()->isAbleTo('freight invoice delete')) {
            $invoice = FreightInvoice::find($id);
            if ($invoice->created_by == creatorId() && $invoice->workspace == getActiveWorkSpace()) {

                event(new DestroyFreightInvoice($invoice));

                $invoice->delete();

                return redirect()->route('freight-invoice.index')->with('success', __('Invoice deleted successfully'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
