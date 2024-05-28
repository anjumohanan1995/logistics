{{ Form::model($route, ['route' => ['route.update', $route->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-6">
            {{ Form::label('route_operation', __('Route Operation'), ['class' => 'col-form-label']) }}
            {{ Form::text('route_operation',null, ['class' => 'form-control', 'placeholder' => __('Enter Route Operation'), 'required' => 'required']) }}
        </div>
        <div class="form-group col-6">
            {{ Form::label('transport', __('Transport'), ['class' => 'col-form-label']) }}
            {{ Form::text('transport', null, ['class' => 'form-control ', 'placeholder' => __('Enter Transport'), 'required' => 'required']) }}
        </div>
        <div class="form-group col-6">
            {{ Form::label('source_location', __('From'), ['class' => 'col-form-label']) }}
            {{ Form::text('source_location', null, ['class' => 'form-control ', 'placeholder' => __('Enter From'), 'required' => 'required']) }}
        </div>
        <div class="form-group col-6">
            {{ Form::label('destination_location', __('To'), ['class' => 'col-form-label']) }}
            {{ Form::text('destination_location', null, ['class' => 'form-control ', 'placeholder' => __('Enter To'), 'required' => 'required']) }}
        </div>
        <div class="form-group col-6">
            {{ Form::label('send_date', __('Send Date'), ['class' => 'col-form-label']) }}
            {{ Form::date('send_date', null, ['class' => 'form-control ', 'required' => 'required', 'placeholder' => 'Select Send Date']) }}
        </div>
        <div class="form-group col-6">
            {{ Form::label('received_date', __('Received Date'), ['class' => 'col-form-label']) }}
            {{ Form::date('received_date', null, ['class' => 'form-control ', 'required' => 'required', 'placeholder' => 'Select Received Date']) }}
        </div>
    </div>

    <div class="card repeater"@if (count($services) > 0) data-value='{!! json_encode($services) !!}' @endif>
        <div class="item-section py-4">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-12 d-flex align-items-center justify-content-md-end px-5">
                    <a href="#" data-repeater-create="" class="btn btn-primary mr-2" data-toggle="modal"
                        data-target="#add-bank">
                        <i class="ti ti-plus"></i> {{ __('Add Service') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body table-border-style mt-2">
            <div class="table-responsive">
                <table class="table  mb-0 table-custom-style" data-repeater-list="items" id="sortable-table">
                    <thead>
                        <tr>
                            <th> {{ __('Vendor') }}</th>
                            <th> {{ __('Service') }}</th>
                            <th> {{ __('QTY') }}</th>
                            <th> {{ __('Cost Price') }}</th>
                            <th> {{ __('Sale Price') }}</th>
                            <th> {{ __('Total Cost') }}</th>
                            <th> {{ __('Total Sale') }}</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody class="ui-sortable" data-repeater-item>
                        <tr>
                            <td class="form-group pt-0" style="width: 160px">
                                {{ Form::hidden('id', null, ['class' => 'form-control id']) }}
                                {{ Form::select('vendor', $vendors, null, ['class' => 'form-control service', 'required' => 'required', 'style' => 'width: 160px;']) }}
                            </td>
                            <td class="form-group pt-0" style="width: 160px">
                                {{ Form::select('service', $services_list, null, ['class' => 'form-control route-service', 'required' => 'required', 'style' => 'width: 160px;']) }}
                            </td>
                            <td>
                                <div class="form-group input-group search-form" style="width: 160px">
                                    {{ Form::text('qty', null, ['class' => 'form-control route-qty', 'id' => 'route-qty', 'required' => 'required', 'placeholder' => __('Qty')]) }}
                                </div>
                            </td>
                            <td>
                                <div class="form-group input-group search-form" style="width: 160px">
                                    {{ Form::number('cost_price', null, ['class' => 'form-control route-cost-price', 'id' => 'route-cost-price', 'readonly' => 'readonly', 'placeholder' => __('Cost Price'), 'required' => 'required']) }}

                                </div>
                            </td>

                            <td>
                                <div class="form-group input-group search-form" style="width: 160px">
                                    {{ Form::number('sale_price', null, ['class' => 'form-control route-sale-price', 'id' => 'route-sale-price', 'readonly' => 'readonly', 'placeholder' => __('Sale Price'), 'required' => 'required']) }}

                                </div>
                            </td>
                            <td>
                                <div class="form-group input-group search-form" style="width: 160px">
                                    {{ Form::number('total_cost_price', null, ['class' => 'form-control route-total-cost-price', 'id' => 'route-total-cost-price', 'id' => 'route-cost-price', 'readonly' => 'readonly', 'placeholder' => __('Total Cost Price'), 'required' => 'required']) }}

                                </div>
                            </td>
                            <td>
                                <div class="form-group input-group search-form" style="width: 160px">
                                    {{ Form::number('total_sale_price', null, ['class' => 'form-control route-total-sale-price', 'id' => 'route-total-sale-price', 'readonly' => 'readonly', 'placeholder' => __('Total Sale Price'), 'required' => 'required']) }}

                                </div>
                            </td>
                            <td>
                                <a href="#" class="bs-pass-para repeater-action-btn" data-repeater-delete>
                                    <div class="repeater-action-btn action-btn bg-danger ms-2">
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
                            <td></td>
                        </tr>
                        <tr>
                            <td class="py-4"></td>
                            <td></td>
                            <td></td>
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
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="route-final-total-cost-price">0.00</td>
                            <td class="route-final-total-sale-price">0.00</td>
                            <td></td>

                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    <button type="submit" class="btn  btn-primary">{{ __('Create') }}</button>
</div>

{{ Form::close() }}

<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/jquery.repeater.min.js') }}"></script>
<script>
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
    function service_amounts()
    {
        var totalAmount = 0;
                    $('.route-total-cost-price').each(function() {
                        totalAmount += parseFloat($(this).val()) || 0;
                    });
                    $('.route-final-total-cost-price').html(totalAmount.toFixed(2));
                    var totalSaleAmount = 0;
                    $('.route-total-sale-price').each(function() {
                        totalSaleAmount += parseFloat($(this).val()) || 0;
                    });
                    $('.route-final-total-sale-price').html(totalSaleAmount.toFixed(2));
    }
    $(document).ready(function() {

        $('.route-qty').each(function() {
           
            var row = $(this).closest('tr');
            var qty = parseFloat($(this).val()) || 1;
            var sale_price = qty * row.find('.route-sale-price').val();
            row.find('.route-total-sale-price').val(sale_price.toFixed(2));
            var cost_price = qty * row.find('.route-cost-price').val();
            row.find('.route-total-cost-price').val(cost_price.toFixed(2));

        });
        service_amounts();
        
    });
    $('body').on('change', '.route-service', function() {
        var id = $(this).val();
        var row = $(this).closest('tr'); // Find the closest ancestor 'tr' element

        $.ajax({
            url: '{{ route('service.detail', ['__id']) }}'.replace('__id', id),
            method: 'POST',
            success: function(response) {
                var qty = row.find('.route-qty').val();
                var cost_price = qty * response.data.cost_price;
                var sale_price = qty * response.data.sale_price;
                row.find('.route-cost-price').val(response.data.cost_price);
                row.find('.route-sale-price').val(response.data.sale_price);
                row.find('.route-total-cost-price').val(cost_price.toFixed(2));
                row.find('.route-total-sale-price').val(sale_price.toFixed(2));
                var totalAmount = 0;
                $('.route-total-cost-price').each(function() {
                    totalAmount += parseFloat($(this).val()) || 0;
                });
                $('.route-final-total-cost-price').html(totalAmount.toFixed(2));
                var totalSaleAmount = 0;
                $('.route-total-sale-price').each(function() {
                    totalSaleAmount += parseFloat($(this).val()) || 0;
                });
                $('.route-final-total-sale-price').html(totalSaleAmount.toFixed(2));

            },
            error: function(error) {
                console.error(error);
            }
        });
    });

    $('body').on('change', '.route-qty', function() {
        var row = $(this).closest('tr');
        var qty = row.find('.route-qty').val();
        var cost_price = qty * row.find('.route-cost-price').val();
        var sale_price = qty * row.find('.route-sale-price').val();
        row.find('.route-total-cost-price').val(cost_price.toFixed(2));
        row.find('.route-total-sale-price').val(sale_price.toFixed(2));
        var totalAmount = 0;
        $('.route-total-cost-price').each(function() {
            totalAmount += parseFloat($(this).val()) || 0;
        });
        $('.route-final-total-cost-price').html(totalAmount.toFixed(2));
        var totalSaleAmount = 0;
        $('.route-total-sale-price').each(function() {
            totalSaleAmount += parseFloat($(this).val()) || 0;
        });
        $('.route-final-total-sale-price').html(totalSaleAmount.toFixed(2));

    });
    var selector = "body";

    if ($(selector + " .repeater").length) {

        var $dragAndDrop = $("body .repeater tbody").sortable({
            handle: '.sort-handler'
        });
        var $repeater = $(selector + ' .repeater').repeater({
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
                    var totalAmount = 0;
                    $('.route-total-cost-price').each(function() {
                        totalAmount += parseFloat($(this).val()) || 0;
                    });
                    $('.route-final-total-cost-price').html(totalAmount.toFixed(2));
                    var totalSaleAmount = 0;
                    $('.route-total-sale-price').each(function() {
                        totalSaleAmount += parseFloat($(this).val()) || 0;
                    });
                    $('.route-final-total-sale-price').html(totalSaleAmount.toFixed(2));
                }
            },
            ready: function(setIndexes) {
                $dragAndDrop.on('drop', setIndexes);
            },
            isFirstItemUndeletable: true
        });
        var value = $(selector + " .repeater").attr('data-value');
        if (typeof value != 'undefined' && value.length != 0) {
            value = JSON.parse(value);
            $repeater.setList(value);
        }
    }
</script>
