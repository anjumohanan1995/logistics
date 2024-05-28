@extends('layouts.main')
@section('page-title')
    {{ __('Shipping Detail') }}
@endsection
@section('page-breadcrumb')
    {{ __('Shipping Detail') }}
@endsection
@push('scripts')
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/jquery.repeater.min.js') }}"></script>
    <script type="text/javascript">
        $(document).on('click', '[data-repeater-delete]', function() {
            var el = $(this).parent().parent();
            var id = $(el.find('.id')).val();

            $.ajax({
                url: '{{ route('shipping.service.destroy') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': jQuery('#token').val()
                },
                data: {
                    'id': id
                },
                cache: false,
                success: function(data) {
                    if (data.error) {
                        toastrs('Error', data.error, 'error');
                    } else {
                        toastrs('Success', data.success, 'success');
                    }
                },
                error: function(data) {
                    toastrs('Error', '{{ __('something went wrong please try again') }}', 'error');
                },
            });
        });

        function service_amounts() {
            var final_sale_price = 0;
            var total_final_sale_price = 0;
            $('.service-sale-price').each(function() {
                final_sale_price += parseFloat($(this).val()) || 0;
            });
            $('.service-total-sale-price').each(function() {
                total_final_sale_price += parseFloat($(this).val()) || 0;
            });
            $('.service-final-sale-price').html(final_sale_price.toFixed(2));
            $('.service-final-total-sale-price').html(total_final_sale_price.toFixed(2));
        }
        $(document).ready(function() {

            $('.service-qty').each(function() {
                var row = $(this).closest('tr');
                var qty = parseFloat($(this).val()) || 1;
                var sale_price = qty * row.find('.service-sale-price').val();
                row.find('.service-total-sale-price').val(sale_price.toFixed(2));

            });
            service_amounts();
        });
        $('body').on('change', '.service-id', function() {
            var id = $(this).val();
            var row = $(this).closest('tr'); // Find the closest ancestor 'tr' element

            $.ajax({
                url: '{{ route('service.detail', ['__id']) }}'.replace('__id', id),
                method: 'POST',
                success: function(response) {
                    var qty = row.find('.service-qty').val();
                    var cost_price = qty * response.data.cost_price;
                    var sale_price = qty * response.data.sale_price;
                    row.find('.service-sale-price').val(response.data.sale_price);
                    row.find('.service-total-sale-price').val(sale_price.toFixed(2));
                    service_amounts();
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
        $('body').on('change', '.service-qty', function() {
            var row = $(this).closest('tr');
            var qty = row.find('.service-qty').val();
            var sale_price = qty * row.find('.service-sale-price').val();
            row.find('.service-total-sale-price').val(sale_price.toFixed(2));

            service_amounts();
        });
        var selector = "body";

        if ($(selector + " .service-repeater").length) {

            var $dragAndDrop = $("body .service-repeater tbody").sortable({
                handle: '.sort-handler'
            });
            var $repeater = $(selector + ' .service-repeater').repeater({
                initEmpty: false,
                defaultValues: {
                    'status': 1
                },
                show: function() {
                    $(this).slideDown();

                },
                hide: function(deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                        $(this).remove();
                        service_amounts();
                    }
                },
                ready: function(setIndexes) {
                    $dragAndDrop.on('drop', setIndexes);
                },
                isFirstItemUndeletable: true
            });
            var value = $(selector + " .service-repeater").attr('data-value');
            if (typeof value != 'undefined' && value.length != 0) {
                value = JSON.parse(value);
                $repeater.setList(value);
            }
        }
        $('.container-select').on('change', function() {
            var id = $(this).val();
            $.ajax({
                url: '{{ route('container.detail', ['__id']) }}'.replace('__id', id),
                method: 'POST',
                success: function(response) {
                    var qty = $('#quantity').val();

                    var volume = response.data.volume_price;
                    var total_volume = qty * response.data.volume_price;
                    $('#volume').val(volume)
                    $('.total_volume').html(total_volume.toFixed(2))
                    $('.total_quantity').html(qty)
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
        $('#order-pricing').on('change', function() {
            var id = $(this).val();
            $.ajax({
                url: '{{ route('price.detail', ['__id']) }}'.replace('__id', id),
                method: 'POST',
                success: function(response) {
                    $('.total_order_sale_price').html('0.00');
                    $('.total_order_weight').html('0');
                    $('.total_order_volume').html('0');
                    var bill_on = $('#order-bill-on').val();
                    if (bill_on == 1) {
                        $('#order-volume').prop('readonly', true);
                        $('#order-price').val(response.data.weight_price);
                    } else if (bill_on == 2) {
                        $('#order-weight').prop('readonly', true);
                        $('#order-price').val(response.data.volume_price);
                    } else if (bill_on == 3) {
                        $('#order-volume').prop('readonly', true);
                        $('#order-weight').prop('readonly', true);
                        $('#order-price').val(response.data.service_price);
                    } else {
                        $('#order-price').val(0.00);
                    }
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
        $('#order-bill-on').on('change', function() {
            var id = $('#order-pricing').val();
            $.ajax({
                url: '{{ route('price.detail', ['__id']) }}'.replace('__id', id),
                method: 'POST',
                success: function(response) {
                    $('.total_order_sale_price').html('0.00');
                    $('.total_order_weight').html('0');
                    $('.total_order_volume').html('0');
                    var bill_on = $('#order-bill-on').val();
                    if (bill_on == 1) {
                        $('#order-sale-price').val('0.00');
                        $('#order-volume').val('');
                        $('#order-volume').prop('readonly', true);
                        $('#order-weight').prop('readonly', false);
                        $('#order-price').val(response.data.weight_price);
                    } else if (bill_on == 2) {
                        $('#order-sale-price').val('0.00');
                        $('#order-weight').val('');
                        $('#order-weight').prop('readonly', true);
                        $('#order-volume').prop('readonly', false);
                        $('#order-price').val(response.data.volume_price);
                    } else if (bill_on == 3) {
                        $('#order-sale-price').val(response.data.service_price);
                        $('#order-volume').val('');
                        $('#order-weight').val('');
                        $('#order-volume').prop('readonly', true);
                        $('#order-weight').prop('readonly', true);
                        $('#order-price').val(response.data.service_price);
                    } else {
                        $('#order-price').val(0.00);
                    }
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });

        $('.quantity').on('change', function() {
            var qty = $(this).val();
            var volume = $('#volume').val();
            var total_volume = qty * volume;
            $('.total_volume').html(total_volume.toFixed(2));
            $('.total_quantity').html(qty);
        });
        $('#order-weight').on('change', function() {
            var weight = $(this).val();

            var price = $('#order-price').val();
            var sale_price = weight * price;
            $('#order-sale-price').val(sale_price.toFixed(2));
            $('.total_order_sale_price').html(sale_price.toFixed(2));
            $('.total_order_weight').html(weight);
        });
        $('#order-volume').on('change', function() {
            var volume = $(this).val();
            var price = $('#order-price').val();
            var sale_price = volume * price;
            $('#order-sale-price').val(sale_price.toFixed(2));
            $('.total_order_sale_price').html(sale_price.toFixed(2));
            $('.total_order_volume').html(volume);
        });
    </script>
@endpush
@section('page-action')
    <div>
        @if((!empty($order)|| count($services)>0 ) && $shipping->status == 1)
            @permission('freight invoice create')
                {{ Form::open(['route' => ['freight.invoice.save', $shipping->id], 'class' => 'm-0']) }}
                @method('POST')
                <a class="btn btn-sm text-white btn-primary bs-pass-para show_confirm"
                    data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                    aria-label="Create" data-confirm="{{ __('Are You Sure?') }}"
                    data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                    data-confirm-yes="delete-form-{{ $shipping->id }}">{{__("Create Invoice")}}</a>
                {{ Form::close() }}
            @endpermission
        @endif
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade active show" id="bill" role="tabpanel" aria-labelledby="pills-user-tab-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="invoice">
                                <div class="invoice-print">
                                    <div class="row invoice-title mt-2">
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-12">
                                            <h2>{{ __('Shipping') }}</h2>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-12 text-end">
                                            <h3 class="invoice-number float-end">
                                                {{ Modules\FreightManagementSystem\Entities\FreightShipping::shippingCodeNumberFormat($shipping->code) }}
                                            </h3>
                                        </div>
                                        <div class="col-12">
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-0 row">
                                                <label class="form-label col-lg-3 col-md-auto col-auto"
                                                    for="direction">{{ __('Direction') }} :
                                                </label>
                                                <div class="col-auto p-0">
                                                    {{ $shipping->direction }}
                                                </div>
                                            </div>
                                            <div class="form-group row mb-0 ">
                                                <label class="form-label col-lg-3 col-md-auto col-auto " for="transport"
                                                    style="padding-right:0px;">{{ __('Transport Type') }} :
                                                </label>
                                                <div class="col-auto p-0">
                                                    {{ $shipping->transport }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row mb-0 ">
                                                <label class="form-label col-lg-3 col-md-auto col-auto "
                                                    for="vessel">{{ __('Customer Name') }} :
                                                </label>
                                                <div class="col-auto p-0">
                                                    {{ $shipping->customer_name }}
                                                </div>
                                            </div>
                                            <div class="form-group row mb-0 ">
                                                <label class="form-label col-lg-3 col-md-auto col-auto "
                                                    for="vessel">{{ __('Order Date') }} :
                                                </label>
                                                <div class="col-auto p-0">
                                                    {{ company_date_formate($shipping->date) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col">
                                            <small>
                                                <strong>{{ __('Status') }} :</strong><br>
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
                                            </small>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-between align-items-center mt-3">
                        <div class="col-md-12">
                            <ul class="nav nav-pills nav-fill cust-nav information-tab" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="main_carriage-tab" data-bs-toggle="pill"
                                        data-bs-target="#main_carriage" type="button">{{ __('Main Carriage') }}</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="container-tab" data-bs-toggle="pill"
                                        data-bs-target="#container" type="button">{{ __('Container') }}</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="order-tab" data-bs-toggle="pill" data-bs-target="#order"
                                        type="button">{{ __('Order') }}</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="services-tab" data-bs-toggle="pill"
                                        data-bs-target="#services" type="button">{{ __('Services') }}</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="route-tab" data-bs-toggle="pill" data-bs-target="#route"
                                        type="button">{{ __('Route') }}</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade active show" id="main_carriage" role="tabpanel"
                                    aria-labelledby="pills-user-tab-2">
                                    <div class="card mt-3">
                                        <div class="card-body row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-0 row">
                                                    <label class="form-label col-lg-3 col-md-auto col-auto"
                                                        for="loading_port">{{ __('Loading Port') }} :
                                                    </label>
                                                    <div class="col-auto p-0">
                                                        {{ $shipping->loading_port }}
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-0 ">
                                                    <label class="form-label col-lg-3 col-md-auto col-auto "
                                                        for="discharge_port"
                                                        style="padding-right:0px;">{{ __('Discharge Port') }} :
                                                    </label>
                                                    <div class="col-auto p-0">
                                                        {{ $shipping->discharge_port }}
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-0 ">
                                                    <label class="form-label col-lg-3 col-md-auto col-auto "
                                                        for="vessel">{{ __('Vessel') }} :
                                                    </label>
                                                    <div class="col-auto p-0">
                                                        {{ $shipping->vessel }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row mb-0 ">
                                                    <label class="form-label col-lg-3 col-md-auto col-auto "
                                                        for="date">{{ __('Date') }} :
                                                    </label>
                                                    <div class="col-auto p-0">
                                                        {{ company_date_formate($shipping->date) }}
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-0 ">
                                                    <label class="form-label col-lg-3 col-md-auto col-auto "
                                                        for="date">{{ __('Barcode') }} :
                                                    </label>
                                                    <div class="col-auto p-0">
                                                        {{ $shipping->barcode }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="container" role="tabpanel"
                                    aria-labelledby="pills-user-tab-2">
                                    <div class="card mt-3">
                                        {{ Form::open(['route' => ['shipping.container.save', $shipping->id], 'method' => 'post']) }}
                                        <div class="card-body table-border-style">
                                            <div class="table-responsive">
                                                <table class="table mb-0 " id="assets">
                                                    <thead>
                                                        <tr>
                                                            <th> {{ __('Container') }}</th>
                                                            <th> {{ __('Quantity') }}</th>
                                                            <th> {{ __('Volume') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div
                                                                    class="form-group mb-0 price-input input-group search-form">
                                                                    {{ Form::select('container', $containers, !empty($shipping->container) ? $shipping->container : null, ['class' => 'form-control item container-select', 'required' => 'required']) }}
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="form-group mb-0 price-input input-group search-form">
                                                                    {{ Form::number('quantity', !empty($shipping->quantity) ? $shipping->quantity : 1, ['class' => 'form-control quantity', 'id' => 'quantity', 'required' => 'required', 'min' => 1, 'placeholder' => __('Quantity')]) }}
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="form-group mb-0 price-input input-group search-form">
                                                                    {{ Form::number('volume', !empty($shipping->volume) ? $shipping->volume : null, ['class' => 'form-control volume', 'id' => 'volume', 'required' => 'required', 'readonly' => 'readonly', 'placeholder' => __('Volume')]) }}
                                                                </div>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td class="p-4"></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-4"></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-4"></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-end">{{ __('Total') }}</td>
                                                            <td class="total_quantity text-dark ">
                                                                {{ !empty($shipping->quantity) ? $shipping->quantity : 1 }}
                                                            </td>
                                                            <td class="total_volume text-dark">
                                                                {{ currency_format_with_sym(!empty($shipping->volume) ? $shipping->volume * $shipping->quantity : 0.0) }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="card-footer text-end">
                                            <input class="btn btn-print-invoice  btn-primary " type="submit"
                                                value="Save Changes">
                                        </div>
                                        {{ Form::close() }}
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="order" role="tabpanel"
                                    aria-labelledby="pills-user-tab-2">
                                    <div class="card mt-3">
                                        {{ Form::open(['route' => ['shipping.order.save', $shipping->id], 'method' => 'post']) }}
                                        <div class="card-body table-border-style">
                                            <div class="table-responsive">
                                                <table class="table mb-0 " id="assets">
                                                    <thead>
                                                        <tr>
                                                            <th width="15%"> {{ __('Description') }}</th>
                                                            <th width="15%"> {{ __('Container') }}</th>
                                                            <th width="15%"> {{ __('Pricing') }}</th>
                                                            <th width="10%"> {{ __('Billing On') }}</th>
                                                            <th> {{ __('Weight') }}</th>
                                                            <th> {{ __('Volume') }}</th>
                                                            <th> {{ __('Price') }}</th>
                                                            <th> {{ __('Sale Price') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="form-group mb-0  input-group search-form">
                                                                    {{ Form::text('description', !empty($order->description) ? $order->description : null, ['class' => 'form-control description', 'id' => 'description', 'placeholder' => __('Description')]) }}
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="form-group mb-0 price-input input-group search-form">
                                                                    {{ Form::select(
                                                                        'container',
                                                                        $containers,
                                                                        !empty($order->container_id) ? $order->container_id : (!empty($shipping->container) ? $shipping->container : null),
                                                                        ['class' => 'form-control item container-select', 'required' => 'required'],
                                                                    ) }}
                                                                </div>

                                                            </td>
                                                            <td>
                                                                <div class="form-group mb-0  input-group search-form">
                                                                    {{ Form::select('pricing', $pricing, !empty($order->pricing_id) ? $order->pricing_id : null, ['class' => 'form-control item', 'id' => 'order-pricing', 'required' => 'required']) }}
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group mb-0  input-group search-form">
                                                                    {{ Form::select('bill_on', $bill_on, !empty($order->bill_on) ? $order->bill_on : null, ['class' => 'form-control item', 'id' => 'order-bill-on', 'required' => 'required']) }}
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group mb-0  input-group search-form">
                                                                    {{ Form::number('weight', !empty($order->weight) ? $order->weight : null, [
                                                                        'class' => 'form-control',
                                                                        'id' => 'order-weight',
                                                                        'placeholder' => __('Weight'),
                                                                        'required' => 'required',
                                                                        'readonly' => isset($order->bill_on) && $order->bill_on != 1 ? 'readonly' : null,
                                                                    ]) }}
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group mb-0  input-group search-form">
                                                                    {{ Form::number('volume', !empty($order->volume) ? $order->volume : null, [
                                                                        'class' => 'form-control',
                                                                        'id' => 'order-volume',
                                                                        'placeholder' => __('Volume'),
                                                                        'required' => 'required',
                                                                        'readonly' => isset($order->bill_on) && $order->bill_on != 2 ? 'readonly' : null,
                                                                    ]) }}

                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group mb-0  input-group search-form">
                                                                    {{ Form::number('price', !empty($order->price) ? $order->price : '0.00', ['class' => 'form-control', 'id' => 'order-price', 'placeholder' => __('Price'), 'required' => 'required']) }}
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group mb-0  input-group search-form">
                                                                    {{ Form::number('sale_price', !empty($order->sale_price) ? $order->sale_price : '0.00', ['class' => 'form-control', 'id' => 'order-sale-price', 'placeholder' => __('Sale Price    '), 'required' => 'required']) }}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-4"></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-4"></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-4"></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="total_order_weight">
                                                                {{ !empty($order->weight) ? $order->weight : 0 }}</td>
                                                            <td class="total_order_volume">
                                                                {{ !empty($order->volume) ? $order->volume : 0 }}</td>
                                                            <td></td>
                                                            <td class="total_order_sale_price">
                                                                {{ currency_format_with_sym(!empty($order->sale_price) ? $order->sale_price : 0.0) }}
                                                            </td>

                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="card-footer text-end">
                                            <input class="btn btn-print-invoice  btn-primary " type="submit"
                                                value="Save Changes">
                                        </div>
                                        {{ Form::close() }}
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="services" role="tabpanel"
                                    aria-labelledby="pills-user-tab-2">
                                    <div class="card mt-3 service-repeater"
                                        @if (count($shipping->frieghtServices) > 0) data-value='{!! json_encode($shipping->frieghtServices) !!}' @endif>
                                        <div class="item-section py-4">
                                            <div class="row justify-content-between align-items-center">
                                                <div
                                                    class="col-md-12 d-flex align-items-center justify-content-md-end px-5">
                                                    <a href="#" data-repeater-create=""
                                                        class="btn btn-primary mr-2" data-toggle="modal"
                                                        data-target="#add-bank">
                                                        <i class="ti ti-plus"></i> {{ __('Add Service') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        {{ Form::open(['route' => ['shipping.service.save', $shipping->id], 'method' => 'post']) }}
                                        <div class="card-body table-border-style mt-2">
                                            <div class="table-responsive">
                                                <table class="table  mb-0 table-custom-style" data-repeater-list="items"
                                                    id="sortable-table">
                                                    <thead>
                                                        <tr>
                                                            <th width="30%"> {{ __('Vendor') }}</th>
                                                            <th width="30%"> {{ __('Service') }}</th>
                                                            <th> {{ __('QTY') }}</th>
                                                            <th> {{ __('Sale Price') }}</th>
                                                            <th> {{ __('Total Sale') }}</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>

                                                    <tbody class="ui-sortable" data-repeater-item>
                                                        <tr>
                                                            <td class="form-group pt-0">
                                                                {{ Form::hidden('id', null, ['class' => 'form-control id']) }}
                                                                {{ Form::select('vendor', $vendors, null, ['class' => 'form-control service', 'required' => 'required']) }}
                                                            </td>
                                                            <td class="form-group pt-0">
                                                                {{ Form::select('service', $services_list, null, ['class' => 'form-control service-id', 'required' => 'required']) }}
                                                            </td>
                                                            <td>
                                                                <div class="form-group input-group search-form">
                                                                    {{ Form::text('qty', null, ['class' => 'form-control service-qty', 'id' => 'service-qty', 'required' => 'required', 'placeholder' => __('Qty')]) }}
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group input-group search-form">
                                                                    {{ Form::number('sale_price', null, ['class' => 'form-control service-sale-price', 'id' => 'service-sale-price', 'readonly' => 'readonly', 'placeholder' => __('Sale Price'), 'required' => 'required']) }}

                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group input-group search-form">
                                                                    {{ Form::number('total_sale_price', null, ['class' => 'form-control service-total-sale-price', 'id' => 'service-total-sale-price', 'readonly' => 'readonly', 'placeholder' => __('Total Sale Price'), 'required' => 'required']) }}

                                                                </div>
                                                            </td>
                                                            <td>
                                                                <a href="#" class="bs-pass-para repeater-action-btn"
                                                                    data-repeater-delete>
                                                                    <div
                                                                        class="repeater-action-btn action-btn bg-danger ms-2">
                                                                        <i class="ti ti-trash text-white"></i>
                                                                    </div>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td class="py-4"></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="py-4"></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="py-4"></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="service-final-sale-price">0.00</td>
                                                            <td class="service-final-total-sale-price">0.00</td>
                                                            <td></td>

                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="card-footer text-end">
                                            <input class="btn btn-print-invoice  btn-primary " type="submit"
                                                value="Save Changes">
                                        </div>
                                        {{ Form::close() }}
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="route" role="tabpanel"
                                    aria-labelledby="pills-user-tab-2">
                                    @permission('freight route create')
                                        <div
                                            class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">
                                            <div class="all-button-box my-2">
                                                <a class="btn btn-sm btn-primary btn-icon-only width-auto"
                                                    data-ajax-popup="true" data-size="lg"
                                                    data-title="{{ __('Create Route') }}"
                                                    data-url="{{ route('route.create', $shipping->id) }}"
                                                    data-bs-toggle="tooltip" data-bs-original-title="{{ __('Create') }}">
                                                    <i class="ti ti-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endpermission
                                    <div class="card mt-3">
                                        <div class="card-body table-border-style">
                                            <div class="table-responsive">
                                                <table class="table mb-0" id="assets">
                                                    <thead>
                                                        <tr>
                                                            <th> {{ __('Route Operations') }}</th>
                                                            <th> {{ __('Source Location') }}</th>
                                                            <th> {{ __('Destination Location') }}</th>
                                                            <th> {{ __('Transport') }}</th>
                                                            <th> {{ __('Cost') }}</th>
                                                            <th> {{ __('Sale') }}</th>
                                                             @if (Laratrust::hasPermission('freight route delete') || Laratrust::hasPermission('freight route edit'))
                                                                <th> {{ __('Action') }}</th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $routes_cost = 0.0;
                                                            $routes_sale = 0.0;
                                                        @endphp
                                                        @forelse ($routes as $route)
                                                            <tr>
                                                                <td>{{ $route->route_operation }}</td>
                                                                <td>{{ $route->source_location }}</td>
                                                                <td>{{ $route->destination_location }}</td>
                                                                <td>{{ $route->transport }}</td>
                                                                <td>{{ currency_format_with_sym($route->cost_price) }}
                                                                </td>
                                                                <td>{{ currency_format_with_sym($route->sale_price) }}
                                                                </td>
                                                                @if (Laratrust::hasPermission('route delete') || Laratrust::hasPermission('freight route edit'))
                                                                    <td class="Action">
                                                                        <span>
                                                                            @permission('freight route edit')
                                                                                <div class="action-btn bg-info ms-2">
                                                                                    <a class="mx-3 btn btn-sm align-items-center"
                                                                                        data-url="{{ route('route.edit', $route->id) }}"
                                                                                        data-ajax-popup="true" data-size="lg"
                                                                                        data-bs-toggle="tooltip"
                                                                                        title="{{ __('Edit') }}"
                                                                                        data-title="{{ __('Edit Route') }}">
                                                                                        <i class="ti ti-pencil text-white"></i>
                                                                                    </a>
                                                                                </div>
                                                                            @endpermission
                                                                            @permission('freight route delete')
                                                                                <div class="action-btn bg-danger ms-2">
                                                                                    {{ Form::open(['route' => ['route.destroy', $route->id], 'class' => 'm-0']) }}
                                                                                    @method('DELETE')
                                                                                    <a class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm"
                                                                                        data-bs-toggle="tooltip"
                                                                                        title=""
                                                                                        data-bs-original-title="Delete"
                                                                                        aria-label="Delete"
                                                                                        data-confirm="{{ __('Are You Sure?') }}"
                                                                                        data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                                                        data-confirm-yes="delete-form-{{ $route->id }}"><i
                                                                                            class="ti ti-trash text-white text-white"></i></a>
                                                                                    {{ Form::close() }}
                                                                                </div>
                                                                            @endpermission
                                                                        </span>
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                            @php
                                                                $routes_cost += $route->cost_price;
                                                                $routes_sale += $route->sale_price;
                                                            @endphp
                                                        @empty
                                                            @include('layouts.nodatafound')
                                                        @endforelse
                                                    </tbody>
                                                    @if (count($routes) > 0)
                                                        <tfoot>
                                                            <tr>
                                                                <td class="p-4"></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="p-4"></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="p-4"></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td class="route_final_cost">
                                                                    {{ currency_format_with_sym($routes_cost) }}</td>
                                                                <td class="route_final_sale">
                                                                    {{ currency_format_with_sym($routes_sale) }}</td>
                                                            </tr>
                                                        </tfoot>
                                                    @endif
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
        </div>
    </div>
    </div>
@endsection
