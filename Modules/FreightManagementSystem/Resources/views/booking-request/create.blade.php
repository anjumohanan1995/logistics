{{ Form::open(['url' => 'freightmanagementsystem/booking-request','enctype' => 'multipart/form-data']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="Direction">{{ __('Direction') }}</label>
                <div class="row ms-1">
                    <div class="form-check col-md-6">
                        <input class="form-check-input" type="radio" name="direction"
                            value="import" id="import" checked>
                        <label class="form-check-label" for="import">
                            {{ __('Import') }}
                        </label>
                    </div>
                    <div class="form-check col-md-6">
                        <input class="form-check-input" type="radio" name="direction"
                            value="export" id="export">
                        <label class="form-check-label" for="export">
                            {{ __('Export') }}
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label" for="transport">{{ __('Transport') }}</label>
                <div class="row ms-1">
                    <div class="form-check col-md-4">
                        <input class="form-check-input" type="radio" name="transport"
                            value="air" id="air" checked>
                        <label class="form-check-label" for="air">
                            {{ __('Air') }}
                        </label>
                    </div>
                    <div class="form-check col-md-4">
                        <input class="form-check-input" type="radio" name="transport"
                            value="ocean" id="ocean">
                        <label class="form-check-label" for="ocean">
                            {{ __('Ocean') }}
                        </label>
                    </div>
                    <div class="form-check col-md-4">
                        <input class="form-check-input" type="radio" name="transport"
                            value="land" id="land">
                        <label class="form-check-label" for="land">
                            {{ __('Land') }}
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group col-6">
            {{ Form::label('customer_name', __('Customer Name'), ['class' => 'col-form-label']) }}
            {{ Form::text('customer_name', '', ['class' => 'form-control', 'placeholder' => __('Enter Customer Name'), 'required' => 'required']) }}
        </div>
        <div class="form-group col-6">
            {{ Form::label('customer_email', __('Customer Email'), ['class' => 'col-form-label']) }}
            {{ Form::email('customer_email', '', ['class' => 'form-control', 'placeholder' => __('Enter Customer Email'), 'required' => 'required']) }}
        </div>
        <div class="form-group col-6">
            {{ Form::label('loading_port', __('Loading Port'), ['class' => 'col-form-label']) }}
            {{ Form::text('loading_port', '', ['class' => 'form-control', 'placeholder' => __('Enter Loading Port'), 'required' => 'required']) }}
        </div>
        <div class="form-group col-6">
            {{ Form::label('discharge_port', __('Discharge Port'), ['class' => 'col-form-label']) }}
            {{ Form::text('discharge_port', '', ['class' => 'form-control', 'placeholder' => __('Enter Discharge Port'), 'required' => 'required']) }}
        </div>
        <div class="form-group col-6">
            {{ Form::label('vessel', __('Vessel'), ['class' => 'col-form-label']) }}
            {{ Form::text('vessel', '', ['class' => 'form-control', 'placeholder' => __('Enter Vessel'), 'required' => 'required']) }}
        </div>
        <div class="form-group col-6">
            {{ Form::label('date', __('Date'), ['class' => 'col-form-label']) }}
            {{ Form::date('date', null, ['class' => 'form-control ', 'required' => 'required', 'placeholder' => 'Select Date']) }}
        </div>
        <div class="form-group col-6">
            {{ Form::label('barcode', __('BarCode'), ['class' => 'col-form-label']) }}
            {{ Form::text('barcode', '', ['class' => 'form-control', 'placeholder' => __('Enter BarCode'), 'required' => 'required']) }}
        </div>
        <div class="form-group col-6">
            {{ Form::label('tracking_no', __('Tracking No'), ['class' => 'col-form-label']) }}
            {{ Form::text('tracking_no', '', ['class' => 'form-control', 'placeholder' => __('Enter Tracking No'), 'required' => 'required']) }}
        </div>
        <div class="form-group col-6">
            {{ Form::label('attechment', __('Attechment File'), ['class' => 'form-label']) }}
            <div class="choose-files ">
                <label for="attechment">
                    <div class=" bg-primary "> <i class="ti ti-upload px-1"></i>{{ __('Choose file here') }}</div>
                    <input type="file" class="form-control file" name="attechment" id="attechment"
                        onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])"
                        data-filename="attechment">
                </label>
                <img id="blah" width="100" src="" />
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    <button type="submit" class="btn  btn-primary">{{ __('Create') }}</button>
</div>

{{ Form::close() }}
