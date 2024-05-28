{{ Form::model($service, ['route' => ['service.update', $service->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-12">
            {{ Form::label('name', __('Name'), ['class' => 'col-form-label']) }}
            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Name'), 'required' => 'required']) }}
        </div>
        <div class="form-group col-12">
            {{ Form::label('cost_price', __('Cost Price'), ['class' => 'col-form-label']) }}
            {{ Form::number('cost_price', null, ['class' => 'form-control ', 'placeholder' => __('Enter Cost Price'), 'required' => 'required']) }}
        </div>
        <div class="form-group col-12">
            {{ Form::label('sale_price', __('Sale Price'), ['class' => 'col-form-label']) }}
            {{ Form::number('sale_price', null, ['class' => 'form-control ', 'placeholder' => __('Enter Sale Price'), 'required' => 'required']) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    {{ Form::submit(__('Update'), ['class' => 'btn  btn-primary']) }}
</div>
{{ Form::close() }}
