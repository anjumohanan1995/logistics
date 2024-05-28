@extends('layouts.main')
@section('page-title')
    {{ __('Dashboard') }}
@endsection
@section('page-breadcrumb')
    {{ __('Freight') }}
@endsection

@php
    $user = \Auth::user();
@endphp

@section('content')
    <div class="col-sm-12">
        <div class="row">
            <div class="row">
                <div class="col-lg-4 col-6 d-flex">
                    <div class="card w-100">
                        <div class="card-body">
                            <h3 class="mb-1 col-12 mb-4" id="greetings">{{ __('Welcome,') }} {{ Auth::user()->name }}</h3>
                            <p>{{ __('Have a nice day! Did you know that you can quickly book request from here?') }}
                            </p>
                            <div class="row">
                                <div class="col-md-10 stats mt-4">
                                    <a href="#" class="btn btn-primary cp_link"
                                        data-link="{{ route('freight.booking.request', $slug) }}"
                                        data-bs-whatever="{{ __('Copy Link') }}" data-bs-toggle="tooltip"
                                        data-bs-original-title="{{ __('Copy Link') }}"
                                        title="{{ __('Click to copy link') }}">
                                        <i class="ti ti-link"></i>
                                        {{ __('Copy Link') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="theme-avtar bg-warning">
                                <i class="ti ti-users"></i>
                            </div>
                            <p class="text-muted text-sm mt-4 mb-2">{{ __('Total') }}</p>
                            <h6 class="mb-3">{{ __('Customer') }}</h6>
                            <h3 class="mb-0">{{ count($Customers)}}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="theme-avtar bg-success">
                                <i class="ti ti-car"></i>
                            </div>
                            <p class="text-muted text-sm mt-4 mb-2">{{ __('Total') }}</p>
                            <h6 class="mb-3">{{ __('Booking') }}</h6>
                            <h3 class="mb-0">{{ count($booking_requests)}}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="theme-avtar bg-primary">
                                <i class="ti ti-compass"></i>
                            </div>
                            <p class="text-muted text-sm mt-4 mb-2">{{ __('Total') }}</p>
                            <h6 class="mb-3">{{ __('Shipping') }}</h6>
                            <h3 class="mb-0">{{ count($all_shippings)}}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="theme-avtar bg-secondary">
                                <i class="ti ti-check"></i>
                            </div>
                            <p class="text-muted text-sm mt-4 mb-2">{{ __('Total') }}</p>
                            <h6 class="mb-3">{{ __('Invoice') }}</h6>
                            <h3 class="mb-0">{{ count($all_invoices)}}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mt-1 mb-0">{{ __('Invoice Payment') }}</h5>
            </div>
            <div class="card-body">
                <div id="invoice-payment"></div>
            </div>
        </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__('Recent Invoice')}}</h5>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table mb-0" id="invoice">
                            <thead>
                                <tr>
                                    <th> {{ __('Invoice') }}</th>
                                    <th> {{ __('Customer') }}</th>
                                    <th> {{ __('Issue Date') }}</th>
                                    <th> {{ __('Due Date') }}</th>
                                    <th> {{ __('Due Amount') }}</th>
                                    <th> {{ __('Status') }}</th>
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
                                   
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{__('Recent Shipping')}}</h5>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table mb-0" id="assets">
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
                                       
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
@endsection
@push('scripts')
<script>
    $('.cp_link').on('click', function() {
        var value = $(this).attr('data-link');
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(value).select();
        document.execCommand("copy");
        $temp.remove();
        toastrs('Success', '{{ __('Link Copy on Clipboard') }}', 'success');
    });
</script>
    <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
    <script>
        (function() {
            var chartBarOptions = {
                series: [{
                        name: "{{ __('Invoice Payment') }}",
                        data: {!! json_encode($paymentLineChartData['payment']) !!}
                    }
                ],

                chart: {
                    height: 250,
                    type: 'area',
                    dropShadow: {
                        enabled: true,
                        color: '#000',
                        top: 18,
                        left: 7,
                        blur: 10,
                        opacity: 0.2
                    },
                    toolbar: {
                        show: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                title: {
                    text: '',
                    align: 'left'
                },
                xaxis: {
                    categories: {!! json_encode($paymentLineChartData['day']) !!},
                    title: {
                        text: '{{ __('Date') }}'
                    }
                },
                colors: ['#ffa21d', '#FF3A6E'],

                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: false,
                },
                yaxis: {
                    title: {
                        text: '{{ __('Amount') }}'
                    },

                }

            };
            var arChart = new ApexCharts(document.querySelector("#invoice-payment"), chartBarOptions);
            arChart.render();
        })();
        </script>
@endpush
