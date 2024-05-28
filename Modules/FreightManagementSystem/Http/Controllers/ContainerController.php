<?php

namespace Modules\FreightManagementSystem\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FreightManagementSystem\Entities\FreightContainer;
use Modules\FreightManagementSystem\Events\CreateFreightContainer;
use Modules\FreightManagementSystem\Events\DestroyFreightContainer;
use Modules\FreightManagementSystem\Events\UpdateFreightContainer;

class ContainerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (Auth::user()->isAbleTo('container manage')) {
            $containers = FreightContainer::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get();
            return view('freightmanagementsystem::container.index', compact('containers'));
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
        if (Auth::user()->isAbleTo('container create')) {

            $code = FreightContainer::containerCodeNumberFormat($this->containerCode());
            $container_number = FreightContainer::containerNumberNumberFormat($this->containerNumber());
            return view('freightmanagementsystem::container.create', compact('code', 'container_number'));
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
        if (Auth::user()->isAbleTo('container create')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'size' => 'required',
                    'size_uom' => 'required',
                    'volume_price' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->withInput()->with('error', $messages->first());
            }
           
            if (!isset($request->status)) {
                $status = 'off';
            } else {
                $status = $request->status;
            }
            $container                    = new FreightContainer();
            $container->code              = $this->containerCode();
            $container->container_number  = $this->containerNumber();
            $container->name              = $request->name;
            $container->size              = $request->size;
            $container->size_uom          = $request->size_uom;
            $container->volume_price      = $request->volume_price;
            $container->status            = $status;
            $container->workspace         = getActiveWorkSpace();
            $container->created_by        = creatorId();
            $container->save();
            FreightContainer::starting_number($container->code + 1, 'container_code');
            FreightContainer::starting_number($container->container_number + 1, 'container_number');
            event(new CreateFreightContainer($request, $container));

            return redirect()->route('container.index')->with('success', __('Container successfully created.'));
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
        if (Auth::user()->isAbleTo('container edit')) {
            $container = FreightContainer::find($id);
            if ($container->created_by == creatorId() && $container->workspace == getActiveWorkSpace()) {
                $code = FreightContainer::containerCodeNumberFormat($container->code);
                $container_number = FreightContainer::containerNumberNumberFormat($container->container_number);
                return view('freightmanagementsystem::container.edit', compact('container', 'code', 'container_number'));
            } else {
                return response()->json(['error' => __('Container not found.')], 401);
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
        if (Auth::user()->isAbleTo('container edit')) {
            $container = FreightContainer::find($id);
            if ($container->created_by == creatorId() && $container->workspace == getActiveWorkSpace()) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'name' => 'required|max:30',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                
                if (!isset($request->status)) {
                    $status = 'off';
                } else {
                    $status = $request->status;
                }
                $container->name              = $request->name;
                $container->size              = $request->size;
                $container->size_uom          = $request->size_uom;
                $container->volume_price      = $request->volume_price;
                $container->status            = $status;
                $container->workspace         = getActiveWorkSpace();
                $container->created_by        = creatorId();
                $container->save();

                event(new UpdateFreightContainer($request, $container));

                return redirect()->route('container.index')->with('success', __('Container successfully updated.'));
            } else {
                return redirect()->back()->with('error', __('Container not found.'));
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
        if (Auth::user()->isAbleTo('container delete')) {
            $container = FreightContainer::find($id);
            if ($container->created_by == creatorId() && $container->workspace == getActiveWorkSpace()) {

                event(new DestroyFreightContainer($container));

                $container->delete();

                return redirect()->route('container.index')->with('success', __('Container deleted successfully.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    function containerCode()
    {
        $latest = company_setting('container_code_starting_number');
        if ($latest == null) {
            return 1;
        } else {
            return $latest;
        }
    }
    function containerNumber()
    {
        $latest = company_setting('container_number_starting_number');
        
        if ($latest == null) {
            return 1;
        } else {
            return $latest;
        }
    }
    public function detail($id)
    {
        $container = FreightContainer::find($id);
        if ($container->created_by == creatorId() && $container->workspace == getActiveWorkSpace()) {
            return response()->json(['data' => $container], 200);
        } else {
            return response()->json(['error' => __('Container Not Found.')], 401);
        }
    }
}
