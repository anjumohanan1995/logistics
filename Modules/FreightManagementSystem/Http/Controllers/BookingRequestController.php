<?php

namespace Modules\FreightManagementSystem\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\WorkSpace;
use App\Models\User;
use Modules\FreightManagementSystem\Entities\FreightCustomer;
use Modules\FreightManagementSystem\Entities\FreightShipping;
use Modules\FreightManagementSystem\Entities\FreightBookingRequest;
use Modules\FreightManagementSystem\Events\CreateFreightShipping;
use Modules\FreightManagementSystem\Events\CreateFreightBookingRequest;
use Modules\FreightManagementSystem\Events\UpdateFreightBookingRequest;
use Modules\FreightManagementSystem\Events\DestroyFreightBookingRequest;
use App\Models\Role;
use Illuminate\Support\Facades\Crypt;

class BookingRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function index()
    {
        if (Auth::user()->isAbleTo('booking request manage')) {
            $booking_requests = FreightBookingRequest::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get();
            return view('freightmanagementsystem::booking-request.index', compact('booking_requests'));
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
        if (Auth::user()->isAbleTo('booking request create')) {
            $code = FreightBookingRequest::bookingRequestCodeNumberFormat(FreightBookingRequest::bookingRequestCode());
            return view('freightmanagementsystem::booking-request.create', compact('code'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        if (Auth::user()->isAbleTo('booking request create')) {
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

                return redirect()->back()->withInput()->with('error', $messages->first());
            }

            $booking_request                 = new FreightBookingRequest();
            $booking_request->code           = FreightBookingRequest::bookingRequestCode();
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
            $booking_request->workspace      = getActiveWorkSpace();;
            $booking_request->created_by     = creatorId();
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
            FreightBookingRequest::starting_number($booking_request->code + 1, 'booking_request');
            return redirect()->route('booking-request.index')->with('success', __('Book Request successfully created.'));
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
        if (Auth::user()->isAbleTo('booking request create')) {
            try {
                $id = Crypt::decrypt($id);
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', __('Booking Not Found.'));
            }
            $book_request = FreightBookingRequest::where('id', $id)->where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->first();
            return view('freightmanagementsystem::booking-request.view', compact('book_request'));
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
        if (Auth::user()->isAbleTo('booking request edit')) {
            $booking_request = FreightBookingRequest::find($id);
            if ($booking_request->created_by == creatorId() && $booking_request->workspace == getActiveWorkSpace()) {
                return view('freightmanagementsystem::booking-request.edit', compact('booking_request'));
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
        if (Auth::user()->isAbleTo('booking request edit')) {
            $booking_request = FreightBookingRequest::find($id);
            if ($booking_request->created_by == creatorId() && $booking_request->workspace == getActiveWorkSpace()) {
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
                $booking_request->workspace      = getActiveWorkSpace();;
                $booking_request->created_by     = creatorId();
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
                event(new UpdateFreightBookingRequest($request, $booking_request));
                return redirect()->route('booking-request.index')->with('success', __('Book Request successfully updated.'));
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
        if (Auth::user()->isAbleTo('booking request delete')) {
            $booking_request = FreightBookingRequest::find($id);
            if ($booking_request->created_by == creatorId() && $booking_request->workspace == getActiveWorkSpace()) {

                event(new DestroyFreightBookingRequest($booking_request));

                $booking_request->delete();

                return redirect()->route('booking-request.index')->with('success', __('Booking Request deleted successfully'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function manage_status($id, $status)
    {
        if (Auth::user()->isAbleTo('booking request accept')) {
            $booking_request = FreightBookingRequest::find($id);
            return view('freightmanagementsystem::booking-request.customer', compact('booking_request', 'status'));
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }
    public function store_status(Request $request, $id, $status)
    {
        $booking_request = FreightBookingRequest::find($id);
        if ($booking_request) {
            if ($status == 1) {
                if (Auth::user()->isAbleTo('booking request accept')) {
                    $user = User::where('email', $booking_request->customer_email)->first();
                    if (empty($user)) {
                        $validator = \Validator::make(
                            $request->all(),
                            [
                                'name' => 'required|max:120',
                                'email' => 'required|email|max:100|unique:users,email',
                                'password' => 'required|min:6',
                            ]
                        );
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
                        $userpassword               = $request->password;
                        $user['name']               = $request->name;
                        $user['email']              = $request->email;
                        $user['password']           = \Hash::make($userpassword);
                        $user['email_verified_at']  = date('Y-m-d h:i:s');
                        $user['lang']               = \Auth::user()->lang;
                        $user['type']               = $roles->name;
                        $user['created_by']         = \Auth::user()->id;
                        $user['workspace_id']       = getActiveWorkSpace();
                        $user['active_workspace']   = getActiveWorkSpace();
                        $user = User::create($user);
                        $user->addRole($roles);
                        $customer                 = new FreightCustomer();
                        $customer->user_id        = $user->id;
                        $customer->name           = $user->name;
                        $customer->email          = !empty($user->email) ? $user->email : null;
                        $customer->country        = !empty($request->country) ? $request->country : null;
                        $customer->state          = !empty($request->state) ? $request->state : null;
                        $customer->city           = !empty($request->city) ? $request->city : null;
                        $customer->zip            = !empty($request->zip) ? $request->zip : null;
                        $customer->address        = !empty($request->address) ? $request->address : null;
                        $customer->workspace      = getActiveWorkSpace();
                        $customer->created_by     = creatorId();
                        $customer->save();

                        $booking_request->user_id  = $customer->id;
                    } else {
                        $customer=FreightCustomer::where('email',$user->email)->first();
                        if(empty($customer))
                        {
                            $customer                 = new FreightCustomer();
                        }
                        
                        $customer->user_id        = $user->id;
                        $customer->name           = $user->name;
                        $customer->email          = !empty($user->email) ? $user->email : null;
                        $customer->country        = !empty($request->country) ? $request->country : null;
                        $customer->state          = !empty($request->state) ? $request->state : null;
                        $customer->city           = !empty($request->city) ? $request->city : null;
                        $customer->zip            = !empty($request->zip) ? $request->zip : null;
                        $customer->address        = !empty($request->address) ? $request->address : null;
                        $customer->workspace      = getActiveWorkSpace();
                        $customer->created_by     = creatorId();
                        $customer->save();
                        $booking_request->user_id  = $customer->id;
                    }
                    $booking_request->status = 1;
                    $booking_request->save();
                    return redirect()->route('booking-request.index')->with('success', __('Booking Request Accept successfully.'));
                } else {
                    return redirect()->back()->with('error', __('Permission denied.'));
                }
            } elseif ($status == 2) {
                if (Auth::user()->isAbleTo('booking request reject')) {
                    $booking_request->status = 2;
                    $booking_request->save();
                    return redirect()->route('booking-request.index')->with('success', __('Booking Request Reject successfully.'));
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
    public function convert(Request $request, $id)
    {
        if (Auth::user()->isAbleTo('booking request convert')) {
            $booking_request                 = FreightBookingRequest::where('id', $id)->first();
            if (!empty($booking_request)) {
                $shipping                 = new FreightShipping();
                $shipping->code           = FreightShipping::shippingCode();
                $shipping->booking_id     = $booking_request->id;
                $shipping->status         = 0;
                $shipping->invoice_status = 0;
                $shipping->user_id        = $booking_request->user_id;
                $shipping->direction      = $booking_request->direction;
                $shipping->transport      = $booking_request->transport;
                $shipping->customer_name  = $booking_request->customer_name;
                $shipping->customer_email = $booking_request->customer_email;
                $shipping->loading_port   = $booking_request->loading_port;
                $shipping->discharge_port = $booking_request->discharge_port;
                $shipping->vessel         = $booking_request->vessel;
                $shipping->date           = $booking_request->date;
                $shipping->barcode        = $booking_request->barcode;
                $shipping->tracking_no    = $booking_request->tracking_no;
                $shipping->workspace      = getActiveWorkSpace();;
                $shipping->created_by     = creatorId();
                $shipping->attechment      = $booking_request->attechment;
                $shipping->save();
                $booking_request->status = 3;
                $booking_request->is_convert = 1;
                $booking_request->convert_shipping_id = $shipping->id;
                $booking_request->save();
                event(new CreateFreightShipping($booking_request, $shipping));
                FreightShipping::starting_number($shipping->code + 1, 'shipping');
                return redirect()->route('booking-request.index')->with('success', __('Booking to Shipping convert successfully.'));
            } else {
                return redirect()->back()->with('error', __('Request not found.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
