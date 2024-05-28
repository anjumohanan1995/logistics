{{ Form::open(array('url' => 'freightmanagementsystem/price')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-12">
            {{ Form::label('name', __('Name'),['class'=>'col-form-label']) }}
            {{ Form::text('name', '', array('class' => 'form-control','placeholder'=> __('Enter Name') ,'required'=>'required')) }}
        </div>
        <div class="form-group col-12">
            {{ Form::label('volume_price', __('Volume Price'),['class'=>'col-form-label']) }}
            {{ Form::number('volume_price',null, ['class' => 'form-control ','placeholder' => __('Enter Volume Price'),'step' => '0.1','min'=>'0']) }}
        </div>
        <div class="form-group col-12">
            {{ Form::label('weight_price', __('Weight Price'),['class'=>'col-form-label']) }}
            {{ Form::number('weight_price',null, ['class' => 'form-control ','placeholder' => __('Enter Weight Price'),'step' => '0.1','min'=>'0']) }}
        </div>
        <div class="form-group col-12">
            {{ Form::label('service_price', __('Service Price'),['class'=>'col-form-label']) }}
            {{ Form::number('service_price',null, ['class' => 'form-control ','placeholder' => __('Enter Service Price'),'step' => '0.1','min'=>'0']) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{__('Close')}}</button>
    <button type="submit" class="btn  btn-primary">{{__('Create')}}</button>
</div>

{{ Form::close() }}
