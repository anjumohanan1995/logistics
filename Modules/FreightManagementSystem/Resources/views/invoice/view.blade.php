@extends('layouts.main')
@section('page-title')
    {{ __('Invoice Detail') }}
@endsection
@section('page-breadcrumb')
    {{ __('Invoice Detail') }}
@endsection
@push('css')
    <style>
        #card-element {
            border: 1px solid #a3afbb !important;
            border-radius: 10px !important;
            padding: 10px !important;
        }
    </style>
@endpush
@section('page-action')
@endsection
@section('content')
    <div class="row justify-content-between align-items-center mb-3">
        <div class="col-md-6">
            <ul class="nav nav-pills nav-fill cust-nav information-tab" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="invoice-tab" data-bs-toggle="pill" data-bs-target="#invoice"
                        type="button">{{ __('Invoice') }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="receipt-summary-tab" data-bs-toggle="pill"
                        data-bs-target="#receipt-summary" type="button">{{ __('Receipt Summary') }}</button>
                </li>
            </ul>
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-between justify-content-md-end">
            <div class="all-button-box mx-2">
                @if ($invoice->status != 2)
                    @permission('freight invoice payment create')
                        <a href="#" data-url="{{ route('freight.invoice.payment', $invoice->id) }}" data-ajax-popup="true"
                            data-title="{{ __('Add Payment') }}" class="btn btn-sm btn-info"
                            data-original-title="{{ __('Add Payment') }}"><i
                                class="ti ti-report-money mr-2"></i>{{ __('Add Payment') }}</a> <br>
                    @endpermission
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade active show" id="invoice" role="tabpanel" aria-labelledby="pills-user-tab-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="invoice">
                                <div class="invoice-print">
                                    <div class="row invoice-title mt-2">
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-12">
                                            <h2>{{ __('Invoice') }}</h2>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-12 text-end">
                                            <h3 class="invoice-number">
                                                {{ \App\Models\Invoice::invoiceNumberFormat($invoice->code) }}</h3>
                                        </div>
                                        <div class="col-12">
                                            <hr>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col text-end">
                                            <div class="d-flex align-items-center justify-content-end">
                                                <div class="me-4">
                                                    <small>
                                                        <strong>{{ __('Issue Date') }} :</strong><br>
                                                        {{ company_date_formate($invoice->invoice_date) }}<br><br>
                                                    </small>
                                                </div>
                                                <div>
                                                    <small>
                                                        <strong>{{ __('Due Date') }} :</strong><br>
                                                        {{ company_date_formate($invoice->due_date) }}<br><br>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="d-flex">

                                                <h5><strong>{{ __('Customer') }} :</strong></h5>
                                                <p class="px-2"> {{ !empty($customer->name) ? $customer->name : '' }}<br>
                                                    {{ !empty($customer->address) ? $customer->address : '' }}<br>
                                                    {{ !empty($customer->city) ? $customer->city . ' ,' : '' }}
                                                    {{ !empty($customer->state) ? $customer->state . ' ,' : '' }}
                                                    {{ !empty($customer->zip) ? $customer->zip : '' }}<br>
                                                    {{ !empty($customer->country) ? $customer->country : '' }}<br>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col">
                                            <small>
                                                <strong>{{ __('Status') }} :</strong><br>
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
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <div class="font-weight-bold">{{ __('Invoice Summary') }}</div>
                                            <small>{{ __('All items here cannot be deleted.') }}</small>
                                            <div class="table-responsive mt-2">
                                                <table class="table mb-0 table-striped">

                                                    <tbody>
                                                        <tr>
                                                            <th class="text-dark">{{ __('Product') }}</th>
                                                            <th class="text-dark">{{ __('Quantity') }}</th>
                                                            <th class="text-dark">{{ __('Price') }}</th>
                                                            <th class="text-right text-dark" width="12%">
                                                                {{ __('Subtotal') }}<br>
                                                            </th>
                                                        </tr>
                                                        @foreach ($services as $service)
                                                            <tr>
                                                                <td>{{ isset($service->serviceDetail->name) ? $service->serviceDetail->name : '' }}
                                                                </td>
                                                                <td>{{ $service->qty }}</td>
                                                                <td>{{ currency_format_with_sym($service->sale_price) }}
                                                                </td>
                                                                <td>
                                                                    {{ currency_format_with_sym($service->sale_price * $service->qty) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        @if(!empty($order))
                                                        <tr>
                                                            <td>{{ isset($order->container->name) ? $order->container->name : '' }}
                                                            </td>
                                                            <td>{{ $order->bill_on == 1 ? $order->weight : ($order->bill_on == 2 ? $order->volume : 1) }}
                                                            </td>
                                                            <td>{{ currency_format_with_sym($order->price) }}
                                                            </td>
                                                            <td>
                                                                {{ currency_format_with_sym($order->sale_price) }}
                                                            </td>
                                                        </tr>
                                                        @endif
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td>{{ __('Total') }}</td>
                                                            <td>{{ currency_format_with_sym($invoice->amount) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td><b>{{ __('Paid') }}</b></td>
                                                            <td>{{ currency_format_with_sym($invoice->amount - $invoice->getDue()) }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td><b>{{ __('Due') }}</b></td>
                                                            <td>{{ currency_format_with_sym($invoice->getDue()) }}</td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="receipt-summary" role="tabpanel" aria-labelledby="pills-user-tab-1">
                    <div class="card">
                        <div class="card-body table-border-style">
                            <div class="table-responsive">
                                <table class="table mb-0 " id="assets">
                                    <thead>
                                        <tr>
                                            <th> {{ __('Date') }}</th>
                                            <th> {{ __('Amount') }}</th>
                                            <th> {{ __('Reference') }}</th>
                                            <th> {{ __('Description') }}</th>
                                            <th class="text-center"> {{ __('Attachment') }}</th>
                                            @if (Laratrust::hasPermission('freight invoice payment delete'))
                                                <th> {{ __('Action') }}</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reciepts as $reciept)
                                            <tr>
                                                <td>{{ $reciept->date }}</td>
                                                <td>{{ $reciept->amount }}</td>
                                                <td>{{ $reciept->reference }}</td>
                                                <td>{{ $reciept->description }}</td>
                                                <td class="text-center">
                                                    @if (!empty($reciept->add_receipt) && (check_file($reciept->add_receipt)))
                                                        <a href="{{ get_file($reciept->add_receipt) }}" download="" class="btn btn-sm btn-primary btn-icon rounded-pill" target="_blank"><span
                                                            class="btn-inner--icon"><i class="ti ti-download"></i></span></a>
                                                        <a href="{{ get_file($reciept->add_receipt) }}"
                                                        class="btn btn-sm btn-secondary btn-icon rounded-pill"
                                                        target="_blank"><span class="btn-inner--icon"><i
                                                                class="ti ti-crosshair"></i></span></a>

                                                    @else
                                                    -
                                                    @endif
                                                </td>
                                                @if (Laratrust::hasPermission('freight invoice payment delete'))
                                                    <td class="Action">
                                                        <span>

                                                            @permission('freight invoice payment delete')
                                                                <div class="action-btn bg-danger ms-2">
                                                                    {{ Form::open(['route' => ['freight.invoice.payment.destroy', $invoice->id, $reciept->id], 'class' => 'm-0']) }}
                                                                    @method('DELETE')
                                                                    <a class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm"
                                                                        data-bs-toggle="tooltip" title=""
                                                                        data-bs-original-title="Delete" aria-label="Delete"
                                                                        data-confirm="{{ __('Are You Sure?') }}"
                                                                        data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                                        data-confirm-yes="delete-form-{{ $reciept->id }}"><i
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
            </div>
        </div>
    </div>
@endsection
