@extends('layouts.main')
@section('page-title')
    {{ __('Manage Shipping') }}
@endsection
@section('page-breadcrumb')
    {{ __('Manage Shipping') }}
@endsection
@section('page-action')
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
                                <th> {{ __('Transport Type') }}</th>
                                <th> {{ __('Direction') }}</th>
                                <th> {{ __('Customer Name') }}</th>
                                <th> {{ __('Loading Port') }}</th>
                                <th> {{ __('Discharging Port') }}</th>
                                <th> {{ __('Status') }}</th>
                                <th> {{ __('Invoicing Status') }}</th>
                                @if (Laratrust::hasPermission('shipping edit') ||
                                        Laratrust::hasPermission('shipping delete') ||
                                        Laratrust::hasPermission('shipping show') ||
                                        Laratrust::hasPermission('shipping convert') ||
                                        Laratrust::hasPermission('shipping accept') ||
                                        Laratrust::hasPermission('shipping reject'))
                                    <th width="10%"> {{ __('Action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shippings as $shipping)
                                <tr class="font-style">
                                    <td>
                                        @permission('shipping show')

                                            <a href="{{ $shipping->status != 2 ? route('shipping.show', \Crypt::encrypt($shipping->id)) : "" }}"
                                                data-title="{{ __('Shipping Detail') }}"
                                                class="btn btn-outline-primary">{{ Modules\FreightManagementSystem\Entities\FreightShipping::shippingCodeNumberFormat($shipping->code) }}</a>
                                        @else
                                            <a
                                                class="btn btn-outline-primary">{{ Modules\FreightManagementSystem\Entities\FreightShipping::shippingCodeNumberFormat($shipping->code) }}</a>
                                @endif
                                </td>
                                <td>{{ $shipping->transport }}</td>
                                <td>{{ $shipping->direction }}</td>
                                <td>{{ $shipping->customer_name }}</td>
                                <td>{{ $shipping->loading_port }}</td>
                                <td>{{ $shipping->discharge_port }}</td>
                                <td>
                                    @if ($shipping->status == 0)
                                        <span
                                            class="badge fix_badges bg-info p-2 px-3 rounded shipping_status">{{ __(Modules\FreightManagementSystem\Entities\FreightShipping::$statues[$shipping->status]) }}</span>
                                    @elseif($shipping->status == 1)
                                        <span
                                            class="badge fix_badges bg-success p-2 px-3 rounded shipping_status">{{ __(Modules\FreightManagementSystem\Entities\FreightShipping::$statues[$shipping->status]) }}</span>
                                    @elseif($shipping->status == 2)
                                        <span
                                            class="badge fix_badges bg-danger p-2 px-3 rounded shipping_status">{{ __(Modules\FreightManagementSystem\Entities\FreightShipping::$statues[$shipping->status]) }}</span>
                                    @elseif($shipping->status == 3)
                                        <span
                                            class="badge fix_badges bg-warning p-2 px-3 rounded shipping_status">{{ __(Modules\FreightManagementSystem\Entities\FreightShipping::$statues[$shipping->status]) }}</span>
                                    @elseif($shipping->status == 4)
                                        <span
                                            class="badge fix_badges bg-primary p-2 px-3 rounded shipping_status">{{ __(Modules\FreightManagementSystem\Entities\FreightShipping::$statues[$shipping->status]) }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($shipping->invoice_status == 0)
                                        <span
                                            class="badge fix_badges bg-info p-2 px-3 rounded shipping_invoice_status">{{ __(Modules\FreightManagementSystem\Entities\FreightShipping::$invoiceStatues[$shipping->invoice_status]) }}</span>
                                    @elseif($shipping->invoice_status == 1)
                                        <span
                                            class="badge fix_badges bg-danger p-2 px-3 rounded shipping_invoice_status">{{ __(Modules\FreightManagementSystem\Entities\FreightShipping::$invoiceStatues[$shipping->invoice_status]) }}</span>
                                    @elseif($shipping->invoice_status == 2)
                                        <span
                                            class="badge fix_badges bg-warning p-2 px-3 rounded shipping_invoice_status">{{ __(Modules\FreightManagementSystem\Entities\FreightShipping::$invoiceStatues[$shipping->invoice_status]) }}</span>
                                    @elseif($shipping->invoice_status == 3)
                                        <span
                                            class="badge fix_badges bg-success p-2 px-3 rounded shipping_invoice_status">{{ __(Modules\FreightManagementSystem\Entities\FreightShipping::$invoiceStatues[$shipping->invoice_status]) }}</span>
                                    @endif
                                </td>
                                @if (Laratrust::hasPermission('shipping edit') ||
                                        Laratrust::hasPermission('shipping delete') ||
                                        Laratrust::hasPermission('shipping show') ||
                                        Laratrust::hasPermission('shipping convert') ||
                                        Laratrust::hasPermission('shipping accept') ||
                                        Laratrust::hasPermission('shipping reject'))
                                    <td class="Action text-end">
                                        <span>
                                            @permission('shipping accept')
                                                @if ($shipping->status == 0)
                                                    <div class="action-btn bg-success ms-2">
                                                        {{ Form::open(['route' => ['shipping.store.status', [$shipping->id, 1]], 'class' => 'm-0']) }}
                                                        @method('POST')
                                                        <a class="mx-3 btn btn-sm  align-items-center  bs-pass-para show_confirm"
                                                            data-bs-toggle="tooltip" title=""
                                                            data-bs-original-title="{{ __('Accept') }}"
                                                            aria-label="{{ __('Accept') }}"
                                                            data-confirm="{{ __('Are You Sure?') }}"
                                                            data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                            data-confirm-yes="accept-form-{{ $shipping->id }}"><i
                                                                class="ti ti-check text-white text-white"></i></a>
                                                        {{ Form::close() }}
                                                    </div>
                                                @endif
                                            @endpermission
                                            @permission('shipping reject')
                                                @if ($shipping->status == 0)
                                                    <div class="action-btn bg-danger ms-2">
                                                        {{ Form::open(['route' => ['shipping.store.status', [$shipping->id, 2]], 'class' => 'm-0']) }}
                                                        @method('POST')
                                                        <a class="mx-3 btn btn-sm  align-items-center  bs-pass-para show_confirm"
                                                            data-bs-toggle="tooltip" title=""
                                                            data-bs-original-title="{{ __('Reject') }}"
                                                            aria-label="{{ __('Reject') }}"
                                                            data-confirm="{{ __('Are You Sure?') }}"
                                                            data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                            data-confirm-yes="reject-form-{{ $shipping->id }}"><i
                                                                class="ti ti-x text-white"></i></a>
                                                        {{ Form::close() }}
                                                    </div>
                                                @endif
                                            @endpermission

                                            @permission('shipping show')
                                                @if ($shipping->status != 2)
                                                    <div class="action-btn bg-warning ms-2">
                                                        <a class="mx-3 btn btn-sm align-items-center"
                                                            href="{{ route('shipping.show', \Crypt::encrypt($shipping->id)) }}"
                                                            title="{{ __('Show') }}">
                                                            <i class="ti ti-eye text-white"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                            @endpermission
                                            @permission('shipping edit')
                                                <div class="action-btn bg-info ms-2">
                                                    <a class="mx-3 btn btn-sm align-items-center"
                                                        data-url="{{ route('shipping.edit', $shipping->id) }}"
                                                        data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" t
                                                        title="{{ __('Edit') }}" data-title="{{ __('Edit shipping') }}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                            @endpermission
                                            @permission('shipping delete')
                                                <div class="action-btn bg-danger ms-2">
                                                    {{ Form::open(['route' => ['shipping.destroy', $shipping->id], 'class' => 'm-0']) }}
                                                    @method('DELETE')
                                                    <a class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm"
                                                        data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                                                        aria-label="Delete" data-confirm="{{ __('Are You Sure?') }}"
                                                        data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                        data-confirm-yes="delete-form-{{ $shipping->id }}"><i
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
