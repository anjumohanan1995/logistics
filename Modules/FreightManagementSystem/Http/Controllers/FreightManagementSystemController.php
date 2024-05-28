<?php

namespace Modules\FreightManagementSystem\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\WorkSpace;
use App\Models\User;
use Modules\FreightManagementSystem\Entities\FreightCustomer;
use Modules\FreightManagementSystem\Entities\FreightBookingRequest;
use Modules\FreightManagementSystem\Entities\FreightShipping;
use Modules\FreightManagementSystem\Entities\FreightInvoice;
use Modules\FreightManagementSystem\Events\CreateFreightBookingRequest;
use Modules\FreightManagementSystem\Entities\FreightUtility;
class FreightManagementSystemController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (Auth::user()->isAbleTo('freight dashboard manage')) {
            $Customers = FreightCustomer::where('created_by', '=', creatorId())->where('workspace', getActiveWorkSpace())->get();
            $workspace = Workspace::find(getActiveWorkSpace());
            $slug = $workspace->slug;
            $all_invoices = FreightInvoice::where('created_by', creatorId())
                ->where('workspace', getActiveWorkSpace())
                ->get();
            $invoices = FreightInvoice::where('created_by', creatorId())
                ->where('workspace', getActiveWorkSpace())
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->get();
            $paymentLineChartData = FreightUtility::getPaymentLineChartDate();
            $booking_requests = FreightBookingRequest::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get();
            $all_shippings = FreightShipping::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get();
            $shippings = FreightShipping::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->get();
            return view('freightmanagementsystem::dashboard.index', compact('paymentLineChartData','slug', 'all_invoices', 'invoices', 'Customers','all_shippings', 'invoices', 'shippings', 'booking_requests'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */

    public function booking(Request $request, $slug, $lang = '')
    {
        $workspace = WorkSpace::where('slug', $slug)->first();
        if ($lang == '') {
            $lang = !empty(company_setting('defult_language', $workspace->created_by, $workspace->id)) ? company_setting('defult_language', $workspace->created_by, $workspace->id) : 'en';
        }
        \App::setLocale($lang);
        return view('freightmanagementsystem::booking-request.request', compact('workspace', 'lang', 'slug'))->with('searchParams', $request->all());;
    }

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
    public function store(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'direction' => 'required',
                'transport' => 'required',
                'customer_name' => 'required',
                'customer_email' => 'required',
                'loading_port' => 'required',
                'discharge_port' => 'required',
                'vessel' => 'required',
                'date' => 'required',
                'barcode' => 'required',
                'tracking_no' => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->withInput()->with('create_request_error', $messages->first());
        }
        $workSpace = WorkSpace::where('slug', $request->slug)->first();
        $user = User::where('id', $workSpace->created_by)->first();
        $booking_request                 = new FreightBookingRequest();
        $booking_request->code           = FreightBookingRequest::bookingRequestCode($user->id);
        $booking_request->status         = 0;
        $booking_request->direction      = $request->direction;
        $booking_request->transport      = $request->transport;
        $booking_request->customer_name  = $request->customer_name;
        $booking_request->customer_email = $request->customer_email;
        $booking_request->loading_port   = $request->loading_port;
        $booking_request->discharge_port = $request->discharge_port;
        $booking_request->vessel         = $request->vessel;
        $booking_request->date           = $request->date;
        $booking_request->barcode        = $request->barcode;
        $booking_request->tracking_no    = $request->tracking_no;
        $booking_request->workspace      = $workSpace->id;
        $booking_request->created_by     = $user->id;
        if (!empty($request->attechment)) {
            $fileName = time() . "_" . $request->attechment->getClientOriginalName();
            $uplaod = upload_file($request, 'attechment', $fileName, 'booking_attechment');
            if ($uplaod['flag'] == 1) {
                $url = $uplaod['url'];
            } else {
                return redirect()->back()->with('error', $uplaod['msg']);
            }
            $booking_request->attechment = $url;
        }
        $booking_request->save();
        event(new CreateFreightBookingRequest($request, $booking_request));
        FreightBookingRequest::starting_number($booking_request->code + 1, 'booking_request', $user->id, $workSpace->id);
        return redirect()->back()->with('create_request', __('Request successfully created.'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return redirect()->back();
        return view('freightmanagementsystem::show');
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
        return redirect()->back();
    }
}
