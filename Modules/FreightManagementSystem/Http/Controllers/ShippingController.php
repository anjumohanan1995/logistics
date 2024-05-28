<?php

namespace Modules\FreightManagementSystem\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\WorkSpace;
use App\Models\User;
use Modules\FreightManagementSystem\Entities\FreightPrice;
use Modules\FreightManagementSystem\Entities\FreightShippingOrder;
use Modules\FreightManagementSystem\Entities\FreightContainer;
use Modules\FreightManagementSystem\Entities\FreightShipping;
use Modules\FreightManagementSystem\Events\UpdateFreightShipping;
use Modules\FreightManagementSystem\Events\DestroyFreightShipping;
use Modules\FreightManagementSystem\Events\CreateFreightShippingOrder;
use Modules\FreightManagementSystem\Events\CreateOrUpdateFreightShippingService;
use Modules\FreightManagementSystem\Events\DestroyFreightShippingService;
use Modules\FreightManagementSystem\Entities\FreightService;
use App\Models\Role;
use Modules\FreightManagementSystem\Entities\FreightShippingService;
use Modules\FreightManagementSystem\Entities\FreightShippingRoute;
use Illuminate\Support\Facades\Crypt;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (Auth::user()->isAbleTo('shipping manage')) {
            $shippings = FreightShipping::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get();
            return view('freightmanagementsystem::shipping.index', compact('shippings'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function shipping_container_save(Request $request, $id)
    {

        if (Auth::user()->isAbleTo('shipping edit')) {
            $shipping = FreightShipping::find($id);
            if ($shipping->created_by == creatorId() && $shipping->workspace == getActiveWorkSpace()) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'container' => 'required',
                        'quantity' => 'required',
                        'volume' => 'required',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                $shipping->container          = $request->container;
                $shipping->quantity           = $request->quantity;
                $shipping->volume             = $request->volume;
                $shipping->save();

                event(new UpdateFreightShipping($request, $shipping));

                return redirect()->back()->with('success', __('Shipping successfully updated.'));
            } else {
                return redirect()->back()->with('error', __('Shipping not found denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function shipping_service_save(Request $request, $id)
    {

        if (Auth::user()->isAbleTo('shipping edit')) {
            $shipping = FreightShipping::find($id);
            if ($shipping->created_by == creatorId() && $shipping->workspace == getActiveWorkSpace()) {

                $services = $request->items;
                for ($i = 0; $i < count($services); $i++) {
                    if (!empty($services[$i]['service'])) {
                        $service=FreightShippingService::where('shipping_id',$shipping->id)->where('id',$services[$i]['id'])->first();
                        if(empty($service))
                        {
                            $service                      = new FreightShippingService();
                        }
                        $get_service=FreightService::where('id',$services[$i]['service'])->first();
                        $service->shipping_id         = $shipping->id;
                        $service->vendor              = $services[$i]['vendor'];
                        $service->service             = $services[$i]['service'];
                        $service->qty                 = $services[$i]['qty'];
                        $service->sale_price          = $services[$i]['sale_price'];
                        $service->cost_price          = $get_service->cost_price;
                        $service->workspace           = getActiveWorkSpace();
                        $service->created_by          = creatorId();
                        $service->save();
                        event(new CreateOrUpdateFreightShippingService($request, $shipping, $service));
                    }

                }

                return redirect()->back()->with('success', __('Shipping successfully updated.'));
            } else {
                return redirect()->back()->with('error', __('Shipping not found denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function serviceDestroy(Request $request)
    {
        if (Auth::user()->isAbleTo('shipping service delete')) {

            $service = FreightShippingService::find($request->id);
            if(!empty($service) && !empty($service->route_id))
            {
                $route=FreightShippingRoute::where('id',$service->route_id)->first();
                if(!empty($route))
                {
                    $route->sale_price=$route->sale_price-($service->qty* $service->sale_price);
                    $route->cost_price=$route->cost_price-($service->qty* $service->cost_price);
                    $route->save();
                }
            }
            event(new DestroyFreightShippingService($service));
            $service->delete();

            return response()->json(['success' => __('Shipping Service successfully deleted.')]);
        } else {
            return response()->json(['error' => __('Permission denied.')]);
        }
    }
    public function shipping_order_save(Request $request, $id)
    {
        if (Auth::user()->isAbleTo('shipping edit')) {
            $shipping = FreightShipping::find($id);
            if ($shipping->created_by == creatorId() && $shipping->workspace == getActiveWorkSpace()) {

                $validator = \Validator::make(
                    $request->all(),
                    [
                        'container' => 'required',
                        'pricing' => 'required',
                        'bill_on' => 'required',
                        'price' => 'required',
                        'sale_price' => 'required',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                $order=FreightShippingOrder::where('shipping_id',$shipping->id)->first();
                if(empty($order))
                {
                    $order                  = new FreightShippingOrder();
                }
                $order->shipping_id     = $shipping->id;
                $order->container_id    = $request->container;
                $order->pricing_id      = $request->pricing;
                $order->description     = $request->description;
                $order->bill_on         = $request->bill_on;
                $order->volume          = $request->volume;
                $order->weight          = $request->weight;
                $order->price           = $request->price;
                $order->sale_price      = $request->sale_price;
                $order->workspace           = getActiveWorkSpace();
                $order->created_by          = creatorId();
                $order->save();

                 event(new CreateFreightShippingOrder($request, $shipping));

                return redirect()->back()->with('success', __('Shipping Order successfully Created.'));
            } else {
                return redirect()->back()->with('error', __('Shipping not found denied.'));
            }
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
    public function store(Request $request)
    {
        return redirect()->back();
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        if (Auth::user()->isAbleTo('shipping show')) {
            try {
                $id = Crypt::decrypt($id);
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', __('Shipping Not Found.'));
            }
            $shipping = FreightShipping::where('id', $id)->where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->first();
            if(!$shipping){
                return redirect()->back()->with('error', __('Something went wrong.'));
            }
            $containers = FreightContainer::where('status','on')->where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get()->pluck('name', 'id');
            $containers->prepend('Select Container', '');
            $bill_on= $this->bill_on();
            $pricing = FreightPrice::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get()->pluck('name', 'id');
            $pricing->prepend('Select Price', '');
            $order=FreightShippingOrder::where('shipping_id',$id)->where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->first();
            $services=FreightShippingService::where('shipping_id',$id)->where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get();
            $routes=FreightShippingRoute::where('shipping_id',$id)->where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get();

            $vendors = User::where('workspace_id', getActiveWorkSpace())
                ->leftjoin('vendors', 'users.id', '=', 'vendors.user_id')
                ->where('users.type', 'vendor')
                ->select('users.*', 'vendors.*', 'users.name as name', 'users.email as email', 'users.id as id', 'users.mobile_no as contact')
                ->get()->pluck('name', 'id');
            $vendors->prepend('Select Vendor', '');
            $services_list = FreightService::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get()->pluck('name', 'id');
            $services_list->prepend('Select Service', '');
            return view('freightmanagementsystem::shipping.view', compact('shipping','vendors','services_list', 'containers','bill_on','pricing','order','services','routes'));
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
        if (Auth::user()->isAbleTo('shipping edit')) {
            $shipping = FreightShipping::find($id);
            if ($shipping->created_by == creatorId() && $shipping->workspace == getActiveWorkSpace()) {
                return view('freightmanagementsystem::shipping.edit', compact('shipping'));
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->isAbleTo('shipping edit')) {
            $shipping = FreightShipping::find($id);
            if ($shipping->created_by == creatorId() && $shipping->workspace == getActiveWorkSpace()) {
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

                    return redirect()->back()->with('error', $messages->first());
                }

                $shipping->direction      = $request->direction;
                $shipping->transport      = $request->transport;
                $shipping->customer_name  = $request->customer_name;
                $shipping->customer_email = $request->customer_email;
                $shipping->loading_port   = $request->loading_port;
                $shipping->discharge_port = $request->discharge_port;
                $shipping->vessel         = $request->vessel;
                $shipping->date           = $request->date;
                $shipping->barcode        = $request->barcode;
                $shipping->tracking_no    = $request->tracking_no;
                $shipping->workspace      = getActiveWorkSpace();;
                $shipping->created_by     = creatorId();
                if (!empty($request->attechment)) {
                    $fileName = time() . "_" . $request->attechment->getClientOriginalName();

                    $uplaod = upload_file($request, 'attechment', $fileName, 'shipping');
                    if ($uplaod['flag'] == 1) {
                        $url = $uplaod['url'];
                    } else {
                        return redirect()->back()->with('error', $uplaod['msg']);
                    }
                    $shipping->attechment = $url;
                }
                $shipping->save();


                event(new UpdateFreightShipping($request, $shipping));

                return redirect()->route('shipping.index')->with('success', __('Shipping successfully updated.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        if (Auth::user()->isAbleTo('shipping delete')) {
            $shipping = FreightShipping::find($id);
            if ($shipping->created_by == creatorId() && $shipping->workspace == getActiveWorkSpace()) {
                $route = FreightShippingRoute::where('shipping_id',$id)->delete();
                $service=FreightShippingService::where('shipping_id',$id)->delete();
                event(new DestroyFreightShipping($shipping));
                $shipping->delete();
                return redirect()->back()->with('success', __('Shipping deleted successfully'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public static function bill_on()
    {
        return [
            1=>__('Weight'),
            2=>__('Volume'),
            3=>__('Service'),
        ];
    }
    public function store_status(Request $request, $id, $status)
    {
        $shipping = FreightShipping::find($id);
        if ($shipping) {
            if ($status == 1) {
                if (Auth::user()->isAbleTo('shipping accept')) {

                    $shipping->status = 1;
                    $shipping->save();
                    return redirect()->back()->with('success', __('Shipping Accept successfully'));
                } else {
                    return redirect()->back()->with('error', __('Permission denied.'));
                }
            } elseif ($status == 2) {
                if (Auth::user()->isAbleTo('shipping reject')) {
                    $shipping->status = 2;
                    $shipping->save();
                    return redirect()->back()->with('success', __('Shipping Reject successfully'));
                } else {
                    return redirect()->back()->with('error', __('Permission denied.'));
                }
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
