@extends('layouts.main')
@section('page-title')
    {{ __('Quotation Detail') }}
@endsection
@section('page-breadcrumb')
    {{ __('Quotation Detail') }}
@endsection
@section('content')
@section('content')
    <div class="row">
        <div class="text-end align-items-center mb-3">
            <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">
                <div class="all-button-box mx-2">
                    <a href="{{ route('quotation.pdf', Crypt::encrypt($quotation->id)) }}" target="_blank"
                        class="btn btn-xs btn-primary btn-icon-only width-auto">
                        {{ __('Download') }}
                    </a>
                </div>
                {{-- @if ($invoice->getDue() > 0 && !empty($company_payment_setting) && ($company_payment_setting['is_stripe_enabled'] == 'on' || $company_payment_setting['is_paypal_enabled'] == 'on' || $company_payment_setting['is_paystack_enabled'] == 'on' || $company_payment_setting['is_flutterwave_enabled'] == 'on' || $company_payment_setting['is_razorpay_enabled'] == 'on' || $company_payment_setting['is_mercado_enabled'] == 'on' || $company_payment_setting['is_paytm_enabled'] == 'on' || $company_payment_setting['is_mollie_enabled'] == 'on' || $company_payment_setting['is_paypal_enabled'] == 'on' || $company_payment_setting['is_skrill_enabled'] == 'on' || $company_payment_setting['is_coingate_enabled'] == 'on' || $company_payment_setting['is_paymentwall_enabled'] == 'on'))
                    <div class="all-button-box">
                        <a href="#" class="btn btn-xs btn-primary btn-icon-only width-auto" data-bs-toggle="modal" data-bs-target="#paymentModal">
                            {{__('Pay Now')}}
                        </a>
                    </div>
                @endif --}}
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice">
                        <div class="invoice-print">
                            <div class="row invoice-title mt-2">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-12">
                                    <h2>{{ __('Quotation') }}</h2>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-12 text-end">
                                    <h3 class="invoice-number">
                                        {{ \Modules\Quotation\Entities\Quotation::quotationNumberFormat($quotation->quotation_id) }}
                                    </h3>
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
                                                <strong>{{ __('Start Date') }} :</strong><br>
                                                {{ company_date_formate($quotation->quotation_date) }}<br><br>
                                            </small>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @if (!empty($customer->billing_name) && !empty($customer->billing_address) && !empty($customer->billing_zip))
                                    <div class="col">
                                        <small class="font-style">
                                            <strong>{{ __('Billed To') }} :</strong><br>
                                            {{ !empty($customer->billing_name) ? $customer->billing_name : '' }}<br>
                                            {{ !empty($customer->billing_address) ? $customer->billing_address : '' }}<br>
                                            {{ !empty($customer->billing_city) ? $customer->billing_city . ' ,' : '' }}
                                            {{ !empty($customer->billing_state) ? $customer->billing_state . ' ,' : '' }}
                                            {{ !empty($customer->billing_zip) ? $customer->billing_zip : '' }}<br>
                                            {{ !empty($customer->billing_country) ? $customer->billing_country : '' }}<br>
                                            {{ !empty($customer->billing_phone) ? $customer->billing_phone : '' }}<br>
                                            <strong>{{ __('Tax Number ') }} :
                                            </strong>{{ !empty($customer->tax_number) ? $customer->tax_number : '' }}

                                        </small>
                                    </div>
                                @endif
                                @if (company_setting('quotation_shipping_display') == 'on')
                                    @if (!empty($customer->shipping_name) && !empty($customer->shipping_address) && !empty($customer->shipping_zip))
                                        <div class="col">
                                            <small>
                                                <strong>{{ __('Shipped To') }} :</strong><br>
                                                {{ !empty($customer->shipping_name) ? $customer->shipping_name : '' }}<br>
                                                {{ !empty($customer->shipping_address) ? $customer->shipping_address : '' }}<br>
                                                {{ !empty($customer->shipping_city) ? $customer->shipping_city . ' ,' : '' }}
                                                {{ !empty($customer->shipping_state) ? $customer->shipping_state . ' ,' : '' }}
                                                {{ !empty($customer->shipping_zip) ? $customer->shipping_zip : '' }}<br>
                                                {{ !empty($customer->shipping_country) ? $customer->shipping_country : '' }}<br>
                                                {{ !empty($customer->shipping_phone) ? $customer->shipping_phone : '' }}<br>
                                                <strong>{{ __('Tax Number ') }} :
                                                </strong>{{ !empty($customer->tax_number) ? $customer->tax_number : '' }}

                                            </small>
                                        </div>
                                    @endif
                                @endif

                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="font-weight-bold">{{ __('Item Summary') }}</div>
                                    <small>{{ __('All items here cannot be deleted.') }}</small>
                                    <div class="table-responsive mt-2">
                                        <table class="table mb-0 table-striped">
                                            <tr>
                                                <th class="text-dark" data-width="40">#</th>

                                                <th class="text-dark">{{ __('Item Type') }}</th>
                                                <th class="text-dark">{{ __('Item') }}</th>
                                                <th class="text-dark">{{ __('Quantity') }}</th>
                                                <th class="text-dark">{{ __('Rate') }}</th>
                                                <th class="text-dark">{{ __('Discount') }}</th>
                                                <th class="text-dark">{{ __('Tax') }}</th>
                                                <th class="text-dark">{{ __('Description') }}</th>
                                                <th class="text-end text-dark" width="12%">{{ __('Price') }}<br>
                                                    <small
                                                        class="text-danger font-weight-bold">{{ __('After discount & tax') }}</small>
                                                </th>
                                            </tr>
                                            @php
                                                $totalQuantity = 0;
                                                $totalRate = 0;
                                                $totalTaxPrice = 0;
                                                $totalDiscount = 0;
                                                $taxesData = [];
                                                $TaxPrice_array = [];
                                            @endphp


                                            @foreach ($iteams as $key => $iteam)
                                                @if (!empty($iteam->tax))
                                                    @php
                                                        $taxes = \Modules\RentalManagement\Entities\Rental::tax($iteam->tax);
                                                        $totalQuantity += $iteam->quantity;
                                                        $totalRate += $iteam->price;
                                                        $totalDiscount += $iteam->discount;
                                                        foreach ($taxes as $taxe) {
                                                            $taxDataPrice = \Modules\RentalManagement\Entities\Rental::taxRate($taxe->rate, $iteam->price, $iteam->quantity, $iteam->discount);
                                                            if (array_key_exists($taxe->name, $taxesData)) {
                                                                $taxesData[$taxe->name] = $taxesData[$taxe->name] + $taxDataPrice;
                                                            } else {
                                                                $taxesData[$taxe->name] = $taxDataPrice;
                                                            }
                                                        }
                                                    @endphp
                                                @endif
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>

                                                    <td>{{ !empty($iteam->product_type) ? Str::ucfirst($iteam->product_type) : '--' }}
                                                    <td>{{ !empty($iteam->product()) ? $iteam->product()->name : '' }}</td>
                                                    <td>{{ $iteam->quantity }}</td>
                                                    <td>{{ currency_format_with_sym($iteam->price) }}</td>
                                                    <td>
                                                        {{ currency_format_with_sym($iteam->discount) }}
                                                    </td>
                                                    <td>
                                                        @if (!empty($iteam->tax))
                                                            <table>
                                                                @php
                                                                    $totalTaxRate = 0;
                                                                    $data = 0;
                                                                @endphp
                                                                @foreach ($taxes as $tax)
                                                                    @php
                                                                        $taxPrice = \Modules\RentalManagement\Entities\Rental::taxRate($tax->rate, $iteam->price, $iteam->quantity, $iteam->discount);
                                                                        $totalTaxPrice += $taxPrice;
                                                                        $data += $taxPrice;
                                                                    @endphp
                                                                    <tr>
                                                                        <td>{{ $tax->name . ' (' . $tax->rate . '%)' }}
                                                                        </td>
                                                                        <td>{{ currency_format_with_sym($taxPrice) }}</td>
                                                                    </tr>
                                                                @endforeach
                                                                @php
                                                                    array_push($TaxPrice_array, $data);
                                                                @endphp
                                                            </table>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    @php
                                                        $tr_tex = array_key_exists($key, $TaxPrice_array) == true ? $TaxPrice_array[$key] : 0;
                                                    @endphp
                                                    <td style="white-space: break-spaces;">
                                                        {{ !empty($iteam->description) ? $iteam->description : '-' }}</td>
                                                    <td class="text-end">
                                                        {{ currency_format_with_sym($iteam->price * $iteam->quantity - $iteam->discount + $tr_tex) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tfoot>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td><b>{{ __('Total') }}</b></td>
                                                    <td><b>{{ $totalQuantity }}</b></td>
                                                    <td><b>{{ currency_format_with_sym($totalRate) }}</b></td>
                                                    <td><b>{{ currency_format_with_sym($totalDiscount) }}</b></td>
                                                    <td><b>{{ currency_format_with_sym($totalTaxPrice) }}</b></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                @php
                                                    $colspan = 7;

                                                @endphp
                                                <tr>
                                                    <td colspan="{{ $colspan }}"></td>
                                                    <td class="text-end"><b>{{ __('Sub Total') }}</b></td>
                                                    <td class="text-end">
                                                        {{ currency_format_with_sym($quotation->getSubTotal()) }}</td>
                                                </tr>
                                                <tr>

                                                    <td colspan="{{ $colspan }}"></td>
                                                    <td class="text-end"><b>{{ __('Discount') }}</b></td>
                                                    <td class="text-end">
                                                        {{ currency_format_with_sym($quotation->getTotalDiscount()) }}
                                                    </td>
                                                </tr>
                                                @if (!empty($taxesData))
                                                    @foreach ($taxesData as $taxName => $taxPrice)
                                                        <tr>
                                                            <td colspan="{{ $colspan }}"></td>
                                                            <td class="text-end"><b>{{ $taxName }}</b></td>
                                                            <td class="text-end">
                                                                {{ currency_format_with_sym($taxPrice) }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                <tr>
                                                    <td colspan="{{ $colspan }}"></td>
                                                    <td class="blue-text text-end"><b>{{ __('Total') }}</b></td>
                                                    <td class="blue-text text-end">
                                                        {{ currency_format_with_sym($quotation->getTotal()) }}</td>
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
    </div>
@endsection
@endsection
