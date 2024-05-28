<?php

namespace Modules\FreightManagementSystem\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\WorkSpace;
use App\Models\User;
use Modules\FreightManagementSystem\Entities\FreightShipping;
use Modules\FreightManagementSystem\Entities\FreightBookingRequest;
use Modules\FreightManagementSystem\Entities\FreightCustomer;
use Modules\FreightManagementSystem\Events\CreateFreightCustomer;
use Modules\FreightManagementSystem\Events\DestroyFreightCustomer;
use Modules\FreightManagementSystem\Events\UpdateFreightCustomer;
use App\Models\Role;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (Auth::user()->isAbleTo('freight customer manage')) {
            $customers = User::where('workspace_id', getActiveWorkSpace())
                ->leftjoin('freight_customers', 'users.id', '=', 'freight_customers.user_id')
                ->where('users.type', 'Client')
                ->select('users.*', 'freight_customers.*', 'users.name as name', 'users.email as email', 'users.id as id')
                ->get();
            return view('freightmanagementsystem::customer.index', compact('customers'));
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
        if (Auth::user()->isAbleTo('freight customer create')) {

            return view('freightmanagementsystem::customer.create');
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
        if (Auth::user()->isAbleTo('freight customer create')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:120',

                ]
            );
            if (empty($request->user_id)) {
                $rules = [
                    'password' => 'required|min:6',
                    'email' => 'required|email|unique:users',
                ];
                $validator = \Validator::make($request->all(), $rules);
            }
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->withInput()->with('error', $messages->first());
            }

            $canUse =  PlanCheck('User', Auth::user()->id);
            if ($canUse == false) {
                return redirect()->back()->with('error', 'You have maxed out the total number of User allowed on your current plan');
            }
            $roles = Role::where('name', 'client')->where('guard_name', 'web')->where('created_by', creatorId())->first();
            if (empty($roles)) {
                return redirect()->back()->with('error', 'Please create Client role first');
            }
            if (isset($request->user_id)) {
                $user = User::find($request->user_id);

                if (empty($user)) {
                    return redirect()->back()->with('error', __('Something went wrong please try again.'));
                }
                if ($user->name != $request->name) {
                    $user->name = $request->name;
                    $user->save();
                }
            } else {
                $user                     = new User();
                $userpassword             = $request->paasword;
                $user->name               = $request->name;
                $user->email              = $request->email;
                $user->password           = \Hash::make($userpassword);
                $user->email_verified_at  = date('Y-m-d h:i:s');
                $user->lang               = \Auth::user()->lang;
                $user->type               = $roles->name;
                $user->created_by         = \Auth::user()->id;
                $user->workspace_id       = getActiveWorkSpace();
                $user->active_workspace   =getActiveWorkSpace();
                $user->save();
                $user->addRole($roles);
            }
            $customer                 = new FreightCustomer();
            $customer->user_id        = $user->id;
            $customer->name           = $request->name;
            $customer->email          = !empty($user->email) ? $user->email : null;
            $customer->country        = !empty($request->country) ? $request->country : null;
            $customer->state          = !empty($request->state) ? $request->state : null;
            $customer->city           = !empty($request->city) ? $request->city : null;
            $customer->zip            = !empty($request->zip) ? $request->zip : null;
            $customer->address        = !empty($request->address) ? $request->address : null;
            $customer->workspace      = getActiveWorkSpace();
            $customer->workspace      = getActiveWorkSpace();
            $customer->created_by     = creatorId();
            $customer->save();
            event(new CreateFreightCustomer($request, $customer));

            return redirect()->route('customers.index')->with('success', __('Customer successfully created.'));
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
        if (Auth::user()->isAbleTo('freight customer edit')) {
            $user         = User::where('id', $id)->where('workspace_id', getActiveWorkSpace())->first();
            $customer     = FreightCustomer::where('user_id', $id)->where('workspace', getActiveWorkSpace())->first();
            return view('freightmanagementsystem::customer.edit', compact('customer', 'user'));
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
        if (Auth::user()->isAbleTo('freight customer edit')) {
            $user = User::where('id', $request->user_id)->first();

            if (empty($user)) {
                return redirect()->back()->with('error', __('Something went wrong please try again.'));
            }
            if ($user->name != $request->name) {
                $user->name = $request->name;
                $user->save();
            }
            $customer               = FreightCustomer::where('user_id',$user->id)->first();
            $customer->name         = $request->name;
            $customer->country        = !empty($request->country) ? $request->country : null;
            $customer->state          = !empty($request->state) ? $request->state : null;
            $customer->city           = !empty($request->city) ? $request->city : null;
            $customer->zip            = !empty($request->zip) ? $request->zip : null;
            $customer->address        = !empty($request->address) ? $request->address : null;
            $customer->workspace    = getActiveWorkSpace();
            $customer->created_by   = creatorId();

            $customer->save();
            event(new UpdateFreightCustomer($request,$customer));

            return redirect()->back()->with('success', __('Customer successfully updated.'));

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
        if (Auth::user()->isAbleTo('freight customer delete')) {
            $customer     = FreightCustomer::where('user_id', $id)->where('workspace', getActiveWorkSpace())->first();
            if (!empty($customer)) {

                $booking_check = FreightBookingRequest::where('user_id', $customer->id)->get();
                $shiiping_check = FreightShipping::where('user_id', $customer->id)->get();
                if (count($booking_check) > 0 || count($shiiping_check) > 0) {
                    return redirect()->back()->with('error', __('This customer is already use so please transfer or delete this customer related data.'));
                }
                event(new DestroyFreightCustomer($customer));
                $customer->delete();
            } else {
                return redirect()->back()->with('error', __('Employee already delete.'));
            }

            return redirect()->back()->with('success', 'Employee successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
