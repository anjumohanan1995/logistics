<?php

namespace Modules\FreightManagementSystem\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\FreightManagementSystem\Entities\FreightService;
use Modules\FreightManagementSystem\Events\CreateFreightService;
use Modules\FreightManagementSystem\Events\UpdateFreightService;
use Modules\FreightManagementSystem\Events\DestroyFreightService;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (Auth::user()->isAbleTo('service manage')) {
            $services = FreightService::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get();
            return view('freightmanagementsystem::service.index', compact('services'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function detail($id)
    {
        $service = FreightService::find($id);
        if ($service->created_by == creatorId() && $service->workspace == getActiveWorkSpace()) {
            return response()->json(['data' => $service], 200);
        } else {
            return response()->json(['error' => __('Service Not Found.')], 401);
        }
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        if (Auth::user()->isAbleTo('service create')) {

            return view('freightmanagementsystem::service.create');
        } else {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        if (Auth::user()->isAbleTo('service create')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'cost_price' => 'required',
                    'sale_price' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->withInput()->with('error', $messages->first());
            }

            $service                = new FreightService();
            $service->name          = $request->name;
            $service->cost_price    = $request->cost_price;
            $service->sale_price    = $request->sale_price;
            $service->workspace     = getActiveWorkSpace();
            $service->created_by    = creatorId();
            $service->save();

            event(new CreateFreightService($request, $service));

            return redirect()->route('service.index')->with('success', __('Service successfully created.'));
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
        if (Auth::user()->isAbleTo('service edit')) {
            $service = FreightService::find($id);
            if ($service->created_by == creatorId() && $service->workspace == getActiveWorkSpace()) {
                return view('freightmanagementsystem::service.edit', compact('service'));
            } else {
                return response()->json(['error' => __('Service not found.')], 401);
            }
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
        if (Auth::user()->isAbleTo('service edit')) {
            $service = FreightService::find($id);
            if ($service->created_by == creatorId() && $service->workspace == getActiveWorkSpace()) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'name' => 'required',
                        'cost_price' => 'required',
                        'sale_price' => 'required',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();
    
                    return redirect()->back()->withInput()->with('error', $messages->first());
                }
                $service->name          = $request->name;
                $service->cost_price    = $request->cost_price;
                $service->sale_price    = $request->sale_price;
                $service->workspace     = getActiveWorkSpace();
                $service->created_by    = creatorId();
                $service->save();

                event(new UpdateFreightService($request, $service));

                return redirect()->route('service.index')->with('success', __('Service successfully updated.'));
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
        if (Auth::user()->isAbleTo('service delete')) {
            $service = FreightService::find($id);
            if ($service->created_by == creatorId() && $service->workspace == getActiveWorkSpace()) {

                event(new DestroyFreightService($service));

                $service->delete();

                return redirect()->route('service.index')->with('success', __('Service deleted successfully.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
