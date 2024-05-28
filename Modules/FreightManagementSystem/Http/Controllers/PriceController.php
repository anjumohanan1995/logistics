<?php

namespace Modules\FreightManagementSystem\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FreightManagementSystem\Entities\FreightPrice;
use Modules\FreightManagementSystem\Events\CreateFreightPrice;
use Modules\FreightManagementSystem\Events\DestroyFreightPrice;
use Modules\FreightManagementSystem\Events\UpdateFreightPrice;
use Illuminate\Support\Facades\Auth;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (Auth::user()->isAbleTo('price manage')) {
            $prices = FreightPrice::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get();
            return view('freightmanagementsystem::price.index', compact('prices'));
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
        if (Auth::user()->isAbleTo('price create')) {

            return view('freightmanagementsystem::price.create');
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
        if (Auth::user()->isAbleTo('price create')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'volume_price' => 'required',
                    'weight_price' => 'required',
                    'service_price' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->withInput()->with('error', $messages->first());
            }

            $price                = new FreightPrice();
            $price->name          = $request->name;
            $price->volume_price  = $request->volume_price;
            $price->weight_price  = $request->weight_price;
            $price->service_price = $request->service_price;
            $price->workspace     = getActiveWorkSpace();
            $price->created_by    = creatorId();
            $price->save();

            event(new CreateFreightPrice($request, $price));

            return redirect()->route('price.index')->with('success', __('Price successfully created.'));
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
        if (Auth::user()->isAbleTo('price edit')) {
            $price = FreightPrice::find($id);
            if ($price->created_by == creatorId() && $price->workspace == getActiveWorkSpace()) {
                return view('freightmanagementsystem::price.edit', compact('price'));
            } else {
                return response()->json(['error' => __('Price not found.')], 401);
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
        if (Auth::user()->isAbleTo('price edit')) {
            $price = FreightPrice::find($id);
            if ($price->created_by == creatorId() && $price->workspace == getActiveWorkSpace()) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'name' => 'required',
                        'volume_price' => 'required',
                        'weight_price' => 'required',
                        'service_price' => 'required',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                $price->name          = $request->name;
                $price->volume_price  = $request->volume_price;
                $price->weight_price  = $request->weight_price;
                $price->service_price = $request->service_price;
                $price->workspace     = getActiveWorkSpace();
                $price->created_by    = creatorId();
                $price->save();

                event(new UpdateFreightPrice($request, $price));

                return redirect()->route('price.index')->with('success', __('Price successfully updated.'));
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
        if (Auth::user()->isAbleTo('price delete')) {
            $price = FreightPrice::find($id);
            if ($price->created_by == creatorId() && $price->workspace == getActiveWorkSpace()) {

                event(new DestroyFreightPrice($price));

                $price->delete();

                return redirect()->route('price.index')->with('success', __('Price deleted successfully.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function detail($id)
    {
        $price = FreightPrice::find($id);
        if ($price->created_by == creatorId() && $price->workspace == getActiveWorkSpace()) {
            return response()->json(['data' => $price], 200);
        } else {
            return response()->json(['error' => __('Price Not Found.')], 401);
        }
    }
}
