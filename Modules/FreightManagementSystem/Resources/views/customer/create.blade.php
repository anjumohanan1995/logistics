{{ Form::open(['url' => 'freightmanagementsystem/customers']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-12">
            {{ Form::label('name', __('Name'), ['class' => 'col-form-label']) }}
            {{ Form::text('name', '', ['class' => 'form-control', 'placeholder' => __('Enter Name'), 'required' => 'required']) }}
        </div>
        <div class="form-group col-12">
            {{ Form::label('email', __('Email'), ['class' => 'col-form-label']) }}
            {{ Form::email('email', ' ', ['class' => 'form-control', 'placeholder' => __('Enter Email'), 'required' => 'required']) }}
        </div>
        <div class="form-group col-12">
            {{ Form::label('paasword', __('Password'), ['class' => 'col-form-label']) }}
            {{ Form::password('password', ['class' => 'form-control', 'placeholder' => __('Enter Password'), 'required' => 'required']) }}
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('address', __('Address'), ['class' => 'form-label']) }}
                <div class="input-group">
                    {{ Form::textarea('address', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => __('Enter Address'), 'required' => 'required']) }}
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('city', __('City'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    {{ Form::text('city', null, ['class' => 'form-control', 'placeholder' => __('Enter City'), 'required' => 'required']) }}
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('state', __('State'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    {{ Form::text('state', null, ['class' => 'form-control', 'placeholder' => __('Enter State'), 'required' => 'required']) }}
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('country', __('Country'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    {{ Form::text('country', null, ['class' => 'form-control', 'placeholder' => __('Enter Country'), 'required' => 'required']) }}
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('zip', __('Zip Code'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    {{ Form::text('zip', null, ['class' => 'form-control', 'placeholder' => __('Enter Zip Code'), 'required' => 'required']) }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    <button type="submit" class="btn  btn-primary">{{ __('Create') }}</button>
</div>

{{ Form::close() }}
