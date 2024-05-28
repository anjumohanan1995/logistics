@extends('layouts.main')
@section('page-title')
    {{ __('Manage Booking') }}
@endsection
@section('page-breadcrumb')
    {{ __('Manage Booking') }}
@endsection
@section('page-action')
    <div>
        @permission('booking request create')
            <a class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="lg" data-title="{{ __('Create Booking Request') }}"
                data-url="{{ route('booking-request.create') }}" data-bs-toggle="tooltip"
                data-bs-original-title="{{ __('Create') }}">
                <i class="ti ti-plus"></i>
            </a>
        @endpermission
    </div>
@endsection
@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table mb-0 pc-dt-simple" id="assets">
                        <thead>
                            <tr>
                                <th> {{ __('Name') }}</th>
                                <th> {{ __('Customer') }}</th>
                                <th> {{ __('Vessel') }}</th>
                                <th> {{ __('Transport') }}</th>
                                <th> {{ __('Status') }}</th>
                                @if (Laratrust::hasPermission('booking request edit') ||
                                        Laratrust::hasPermission('booking request delete') ||
                                        Laratrust::hasPermission('booking request show') ||
                                        Laratrust::hasPermission('booking request convert') ||
                                        Laratrust::hasPermission('booking request accept') ||
                                        Laratrust::hasPermission('booking request reject'))
                                    <th width="10%"> {{ __('Action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($booking_requests as $booking_request)
                                <tr class="font-style">
                                    <td>
                                        @permission('booking request show')

                                            <a data-url="{{ route('booking-request.show', \Crypt::encrypt($booking_request->id)) }}"
                                                data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" t
                                                title="{{ __('Show') }}" data-title="{{ __('Booking Request Detail') }}"
                                                class="btn btn-outline-primary">{{ Modules\FreightManagementSystem\Entities\FreightBookingRequest::bookingRequestCodeNumberFormat($booking_request->code) }}</a>
                                        @else
                                            <a
                                                class="btn btn-outline-primary">{{ Modules\FreightManagementSystem\Entities\FreightBookingRequest::bookingRequestCodeNumberFormat($booking_request->code) }}</a>
                                @endif
                                </td>
                                <td>{{ $booking_request->customer_name }}</td>
                                <td>{{ $booking_request->vessel }}</td>
                                <td>{{ $booking_request->transport }}</td>
                                <td>
                                    @if ($booking_request->status == 0)
                                        <span
                                            class="badge fix_badges bg-info p-2 px-3 rounded booking_request_status">{{ __(Modules\FreightManagementSystem\Entities\FreightBookingRequest::$statues[$booking_request->status]) }}</span>
                                    @elseif($booking_request->status == 1)
                                        <span
                                            class="badge fix_badges bg-success p-2 px-3 rounded booking_request_status">{{ __(Modules\FreightManagementSystem\Entities\FreightBookingRequest::$statues[$booking_request->status]) }}</span>
                                    @elseif($booking_request->status == 2)
                                        <span
                                            class="badge fix_badges bg-danger p-2 px-3 rounded booking_request_status">{{ __(Modules\FreightManagementSystem\Entities\FreightBookingRequest::$statues[$booking_request->status]) }}</span>
                                    @elseif($booking_request->status == 3)
                                        <span
                                            class="badge fix_badges bg-warning p-2 px-3 rounded booking_request_status">{{ __(Modules\FreightManagementSystem\Entities\FreightBookingRequest::$statues[$booking_request->status]) }}</span>
                                    @elseif($booking_request->status == 4)
                                        <span
                                            class="badge fix_badges bg-primary p-2 px-3 rounded booking_request_status">{{ __(Modules\FreightManagementSystem\Entities\FreightBookingRequest::$statues[$booking_request->status]) }}</span>
                                    @endif
                                </td>

                                @if (Laratrust::hasPermission('booking request edit') ||
                                        Laratrust::hasPermission('booking request delete') ||
                                        Laratrust::hasPermission('booking request show') ||
                                        Laratrust::hasPermission('booking request convert') ||
                                        Laratrust::hasPermission('booking request accept') ||
                                        Laratrust::hasPermission('booking request reject'))
                                    <td class="Action text-end">
                                        <span>
                                            @permission('booking request accept')
                                                @if ($booking_request->status == 0)
                                                    @if ($booking_request->customer == null)

                                                        <div class="action-btn bg-success ms-2">
                                                            <a class="mx-3 btn btn-sm align-items-center"
                                                                data-url="{{ route('booking-request.manage.status', [$booking_request->id, 1]) }}"
                                                                data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                                title="{{ __('Accept') }}"
                                                                data-title="{{ __('Create Customer') }}">
                                                                <i class="ti ti-check text-white"></i>
                                                            </a>
                                                        </div>
                                                    @else
                                                        <div class="action-btn bg-success ms-2">
                                                            {{ Form::open(['route' => ['booking-request.store.status', [$booking_request->id, 1]], 'class' => 'm-0']) }}
                                                            @method('POST')
                                                            <a class="mx-3 btn btn-sm  align-items-center  bs-pass-para show_confirm"
                                                                data-bs-toggle="tooltip" title=""
                                                                data-bs-original-title="{{ __('Accept') }}"
                                                                aria-label="{{ __('Accept') }}"
                                                                data-confirm="{{ __('Are You Sure?') }}"
                                                                data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                                data-confirm-yes="accept-form-{{ $booking_request->id }}"><i
                                                                    class="ti ti-check text-white text-white"></i></a>
                                                            {{ Form::close() }}
                                                        </div>
                                                    @endif
                                                @endif
                                            @endpermission
                                            @permission('booking request reject')
                                                @if ($booking_request->status == 0)
                                                    <div class="action-btn bg-danger ms-2">
                                                        {{ Form::open(['route' => ['booking-request.store.status', [$booking_request->id, 2]], 'class' => 'm-0']) }}
                                                        @method('POST')
                                                        <a class="mx-3 btn btn-sm  align-items-center  bs-pass-para show_confirm"
                                                            data-bs-toggle="tooltip" title=""
                                                            data-bs-original-title="{{ __('Reject') }}"
                                                            aria-label="{{ __('Reject') }}"
                                                            data-confirm="{{ __('Are You Sure?') }}"
                                                            data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                            data-confirm-yes="reject-form-{{ $booking_request->id }}"><i
                                                                class="ti ti-x text-white"></i></a>
                                                        {{ Form::close() }}
                                                    </div>
                                                @endif
                                            @endpermission
                                            @if ($booking_request->is_convert != 1 && $booking_request->status==1)
                                                @permission('booking request convert')
                                                    <div class="action-btn bg-primary ms-2">
                                                        {{ Form::open(['route' => ['convert.cooking.to.shipping', $booking_request->id], 'class' => 'm-0']) }}
                                                        @method('POST')
                                                        <a class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm"
                                                            data-bs-toggle="tooltip" title=""
                                                            data-bs-original-title="{{ __('Convert to Ship') }}"
                                                            aria-label="convert" data-confirm="{{ __('Are You Sure?') }}"
                                                            data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                            data-confirm-yes="convert-form-{{ $booking_request->id }}"><i
                                                                class="ti ti-exchange text-white"></i></a>
                                                        {{ Form::close() }}
                                                    </div>
                                                @endpermission
                                            @endif
                                            @if ($booking_request->is_convert==1)
                                                @permission('shipping show')
                                                    <div class="action-btn bg-success ms-2">
                                                        <a class="mx-3 btn btn-sm align-items-center"href="{{ route('shipping.show', \Crypt::encrypt($booking_request->convert_shipping_id)) }}"
                                                            title="{{ __('Already convert to Shipping') }}"data-bs-toggle="tooltip">
                                                            <i class="ti ti-eye text-white"></i>
                                                        </a>
                                                    </div>
                                                @endpermission
                                            @endif
                                            @if ($booking_request->status!=0)
                                            @permission('booking request show')
                                                <div class="action-btn bg-warning ms-2">
                                                    <a class="mx-3 btn btn-sm align-items-center"
                                                        data-url="{{ route('booking-request.show', \Crypt::encrypt($booking_request->id)) }}"
                                                        data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip"
                                                        title="{{ __('Show') }}"
                                                        data-title="{{ __('Booking Request Detail') }}">
                                                        <i class="ti ti-eye text-white"></i>
                                                    </a>
                                                </div>
                                            @endpermission
                                            @endif
                                            @permission('booking request edit')
                                                <div class="action-btn bg-info ms-2">
                                                    <a class="mx-3 btn btn-sm align-items-center"
                                                        data-url="{{ route('booking-request.edit', $booking_request->id) }}"
                                                        data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip"
                                                        title="{{ __('Edit') }}" data-title="{{ __('Edit Booking Request') }}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                            @endpermission
                                            @permission('booking request delete')
                                                <div class="action-btn bg-danger ms-2">
                                                    {{ Form::open(['route' => ['booking-request.destroy', $booking_request->id], 'class' => 'm-0']) }}
                                                    @method('DELETE')
                                                    <a class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm"
                                                        data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                                                        aria-label="Delete" data-confirm="{{ __('Are You Sure?') }}"
                                                        data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                        data-confirm-yes="delete-form-{{ $booking_request->id }}"><i
                                                            class="ti ti-trash text-white text-white"></i></a>
                                                    {{ Form::close() }}
                                                </div>
                                            @endpermission
                                        </span>
                                    </td>
                                @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
