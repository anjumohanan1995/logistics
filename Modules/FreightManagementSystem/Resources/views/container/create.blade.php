{{ Form::open(['url' => 'freightmanagementsystem/container']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-6">
            {{ Form::label('code', __('Code'), ['class' => 'col-form-label']) }}
            {{ Form::text('code', $code, ['class' => 'form-control' , 'readonly'=>'readonly' , 'placeholder' => __('Enter Code'), 'required' => 'required']) }}
        </div>
        <div class="form-group col-6">
            {{ Form::label('container_number', __('Container Number'), ['class' => 'col-form-label']) }}
            {{ Form::text('container_number', $container_number, ['class' => 'form-control' , 'readonly'=>'readonly' , 'placeholder' => __('Enter Container Number'), 'required' => 'required']) }}
        </div>
        <div class="col-12">
            <div class="form-check form-switch">
            <input type="checkbox" class="form-check-input" id="status" name="status" checked />
            <label class="form-check-label f-w-600 pl-1" for="status">{{ __('Status') }}</label>
            </div>
        </div>
        <div class="form-group col-6">
            {{ Form::label('name', __('Name'), ['class' => 'col-form-label']) }}
            {{ Form::text('name', '', ['class' => 'form-control', 'placeholder' => __('Enter Name'), 'required' => 'required']) }}
        </div>
        <div class="form-group col-6">
            {{ Form::label('size', __('Size'), ['class' => 'col-form-label']) }}
            {{ Form::number('size', '', ['class' => 'form-control', 'placeholder' => __('Enter Size'), 'required' => 'required']) }}
        </div>
        <div class="form-group col-6">
            {{ Form::label('size_uom', __('Size UOM'), ['class' => 'col-form-label']) }}
            {{ Form::text('size_uom', '', ['class' => 'form-control', 'placeholder' => __('Enter Size UOM'), 'required' => 'required']) }}
        </div>
        <div class="form-group col-6">
            {{ Form::label('volume_price', __('Volume Price'), ['class' => 'col-form-label']) }}
            {{ Form::number('volume_price', null, ['class' => 'form-control ', 'placeholder' => __('Enter Volume Price'), 'step' => '0.1', 'min' => '0']) }}
        </div>
        
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    <button type="submit" class="btn  btn-primary">{{ __('Create') }}</button>
</div>

{{ Form::close() }}
