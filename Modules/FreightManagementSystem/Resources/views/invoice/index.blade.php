@extends('layouts.main')
@section('page-title')
    {{ __('Manage Invoices') }}
@endsection
@section('page-breadcrumb')
    {{ __('Manage Invoices') }}
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
                                <th> {{ __('Invoice') }}</th>
                                <th> {{ __('Customer') }}</th>
                                <th> {{ __('Issue Date') }}</th>
                                <th> {{ __('Due Date') }}</th>
                                <th> {{ __('Due Amount') }}</th>
                                <th> {{ __('Status') }}</th>
                                @if (Laratrust::hasPermission('freight invoice payment create') || Laratrust::hasPermission('freight invoice delete'))
                                    <th width="10%"> {{ __('Action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                                <td>
                                    @permission('freight invoice show')

                                        <a href="{{ route('freight-invoice.show', \Crypt::encrypt($invoice->id)) }}"
                                            title="{{ __('Show') }}"
                                            class="btn btn-outline-primary">{{ Modules\FreightManagementSystem\Entities\FreightInvoice::freightCodeNumberFormat($invoice->code) }}</a>
                                    @else
                                        <a
                                            class="btn btn-outline-primary">{{ Modules\FreightManagementSystem\Entities\FreightInvoice::freightCodeNumberFormat($invoice->code) }}</a>
                                @endif
                                </td>
                                <td>{{ $invoice->freightShipping->customer_name }}</td>
                                <td>{{ company_date_formate($invoice->invoice_date) }}</td>
                                <td>{{ company_date_formate($invoice->due_date) }}</td>
                                <td>{{ currency_format_with_sym($invoice->amount) }}</td>
                                <td>
                                    @if ($invoice->status == 0)
                                        <span
                                            class="badge fix_badges bg-danger p-2 px-3 rounded shipping_status">{{ __(Modules\FreightManagementSystem\Entities\FreightInvoice::$statues[$invoice->status]) }}</span>
                                    @elseif($invoice->status == 1)
                                        <span
                                            class="badge fix_badges bg-warning p-2 px-3 rounded shipping_status">{{ __(Modules\FreightManagementSystem\Entities\FreightInvoice::$statues[$invoice->status]) }}</span>
                                    @elseif($invoice->status == 2)
                                        <span
                                            class="badge fix_badges bg-success p-2 px-3 rounded shipping_status">{{ __(Modules\FreightManagementSystem\Entities\FreightInvoice::$statues[$invoice->status]) }}</span>
                                    @endif
                                </td>
                                @if (Laratrust::hasPermission('freight invoice payment create') || Laratrust::hasPermission('freight invoice delete'))
                                    <td class="Action text-end">
                                        <span>
                                            @permission('freight invoice payment create')
                                                @if ($invoice->status != 2)
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#"
                                                            data-url="{{ route('freight.invoice.payment', $invoice->id) }}"
                                                            data-ajax-popup="true" data-title="{{ __('Add Payment') }}"
                                                            class="mx-3 btn btn-sm text-white align-items-center"
                                                            data-original-title="{{ __('Add Payment') }}"><i
                                                                data-bs-toggle="tooltip" class="ti ti-report-money mr-2"></i></a>
                                                    </div>
                                                @endif
                                            @endpermission
                                            @permission('freight invoice delete')
                                                <div class="action-btn bg-danger ms-2">
                                                    {{ Form::open(['route' => ['freight-invoice.destroy', $invoice->id], 'class' => 'm-0']) }}
                                                    @method('DELETE')
                                                    <a class="mx-3 btn btn-sm align-items-center bs-pass-para show_confirm"
                                                        data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                                                        aria-label="Delete" data-confirm="{{ __('Are You Sure?') }}"
                                                        data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                        data-confirm-yes="delete-form-{{ $invoice->id }}"><i
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
