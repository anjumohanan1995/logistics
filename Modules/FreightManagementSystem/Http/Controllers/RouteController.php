<?php

namespace Modules\FreightManagementSystem\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FreightManagementSystem\Entities\FreightShippingRoute;
use Modules\FreightManagementSystem\Entities\FreightShipping;
use Modules\FreightManagementSystem\Entities\FreightShippingService;
use Illuminate\Support\Facades\Auth;
use Modules\FreightManagementSystem\Entities\FreightService;
use Modules\FreightManagementSystem\Events\CreateFreightShippingRoute;
use Modules\FreightManagementSystem\Events\UpdateFreightShippingRoute;
use Modules\FreightManagementSystem\Events\DestroyFreightShippingRoute;
use App\Models\User;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return redirect()->back();
        return view('freightmanagementsystem::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($id)
    {

        if (Auth::user()->isAbleTo('freight route create')) {
            $shipping = FreightShipping::where('id', $id)->where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->first();
            $vendors = User::where('workspace_id', getActiveWorkSpace())
                ->leftjoin('vendors', 'users.id', '=', 'vendors.user_id')
                ->where('users.type', 'vendor')
                ->select('users.*', 'vendors.*', 'users.name as name', 'users.email as email', 'users.id as id', 'users.mobile_no as contact')
                ->get()->pluck('name', 'id');
            $vendors->prepend('Select Vendor', ''); 
            $services = FreightService::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get()->pluck('name', 'id');
            $services->prepend('Select Service', '');
            return view('freightmanagementsystem::route.create', compact('shipping', 'services', 'vendors'));
        } else {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request, $id)
    {

        if (Auth::user()->isAbleTo('freight route create')) {
            $shipping = FreightShipping::where('id', $id)->where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->first();
            if ($shipping) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'route_operation' => 'required',
                        'transport' => 'required',
                        'source_location' => 'required',
                        'destination_location' => 'required',
                        'send_date' => 'required',
                        'received_date' => 'required',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->withInput()->with('error', $messages->first());
                }
               
                $route                      = new FreightShippingRoute();
                $route->shipping_id         = $shipping->id;
                $route->route_operation     = $request->route_operation;
                $route->transport           = $request->transport;
                $route->source_location     = $request->source_location;
                $route->destination_location = $request->destination_location;
                $route->send_date           = $request->send_date;
                $route->received_date       = $request->received_date;
                $route->workspace           = getActiveWorkSpace();
                $route->created_by          = creatorId();
                $route->save();
                $services = $request->items;
                $total_cost=0;
                $total_sale=0;
                for ($i = 0; $i < count($services); $i++) {
                    if (!empty($services[$i]['service'])) {
                        $service                      = new FreightShippingService();
                        $service->shipping_id         = $shipping->id;
                        $service->route_id            = $route->id;
                        $service->vendor              = $services[$i]['vendor'];
                        $service->service             = $services[$i]['service'];
                        $service->qty                 = $services[$i]['qty'];
                        $service->sale_price          = $services[$i]['sale_price'];
                        $service->cost_price          = $services[$i]['cost_price'];
                        $service->workspace           = getActiveWorkSpace();
                        $service->created_by          = creatorId();
                        $service->save();
                        $total_cost+=$services[$i]['total_cost_price'];
                        $total_sale+=$services[$i]['total_sale_price'];
                    }
                }
                $route->cost_price=$total_cost;
                $route->sale_price=$total_sale;
                $route->save();
                event(new CreateFreightShippingRoute($request, $route));

                return redirect()->back()->with('success', __('Route successfully created.'));
            }
            else {
                return redirect()->back()->with('error', __('Shipping Not Found.'));
            }
        } else {
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
        if (Auth::user()->isAbleTo('freight route edit')) {
            $route = FreightShippingRoute::where('id', $id)->where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->first();
            $vendors = User::where('workspace_id', getActiveWorkSpace())
                ->leftjoin('vendors', 'users.id', '=', 'vendors.user_id')
                ->where('users.type', 'vendor')
                ->select('users.*', 'vendors.*', 'users.name as name', 'users.email as email', 'users.id as id', 'users.mobile_no as contact')
                ->get()->pluck('name', 'id');
            $vendors->prepend('Select Vendor', ''); 
            $services_list = FreightService::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get()->pluck('name', 'id');
            $services_list->prepend('Select Service', '');
            $services=FreightShippingService::where('route_id',$route->id)->get();
            return view('freightmanagementsystem::route.edit', compact('route', 'services_list', 'vendors','services'));
        } else {
            return response()->json(['error' => __('Permission Denied.')], 401);
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
        if (Auth::user()->isAbleTo('freight route edit')) {
           
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'route_operation' => 'required',
                        'transport' => 'required',
                        'source_location' => 'required',
                        'destination_location' => 'required',
                        'send_date' => 'required',
                        'received_date' => 'required',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->withInput()->with('error', $messages->first());
                }
               
                $route                      = FreightShippingRoute::find($id);
                $route->route_operation     = $request->route_operation;
                $route->transport           = $request->transport;
                $route->source_location     = $request->source_location;
                $route->destination_location= $request->destination_location;
                $route->send_date           = $request->send_date;
                $route->received_date       = $request->received_date;
                $route->workspace           = getActiveWorkSpace();
                $route->created_by          = creatorId();
                $route->save();
                $services = $request->items;
                $total_cost=0;
                $total_sale=0;
                for ($i = 0; $i < count($services); $i++) {
                    if (!empty($services[$i]['service'])) {
                        $service=FreightShippingService::where('route_id',$route->id)->where('id',$services[$i]['id'])->first();
                        if(empty($service))
                        {
                            $service                  = new FreightShippingService();
                        }
                        $service->shipping_id         = $route->shipping_id;
                        $service->route_id            = $route->id;
                        $service->vendor              = $services[$i]['vendor'];
                        $service->service             = $services[$i]['service'];
                        $service->qty                 = $services[$i]['qty'];
                        $service->sale_price          = $services[$i]['sale_price'];
                        $service->cost_price          = $services[$i]['cost_price'];
                        $service->workspace           = getActiveWorkSpace();
                        $service->created_by          = creatorId();
                        $service->save();
                        $total_cost+=$services[$i]['total_cost_price'];
                        $total_sale+=$services[$i]['total_sale_price'];
                    }
                }
                $route->cost_price=$total_cost;
                $route->sale_price=$total_sale;
                $route->save();
                event(new UpdateFreightShippingRoute($request, $route));

                return redirect()->back()->with('success', __('Route successfully created.'));
           
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
        if (Auth::user()->isAbleTo('freight route delete')) {
            $route = FreightShippingRoute::find($id);
            if ($route->created_by == creatorId() && $route->workspace == getActiveWorkSpace()) {
                $service=FreightShippingService::where('route_id',$id)->delete();
                event(new DestroyFreightShippingRoute($route));
                $route->delete();

                return redirect()->back()->with('success', __('Route deleted successfully'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
