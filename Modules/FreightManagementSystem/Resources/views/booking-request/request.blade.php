@extends('freightmanagementsystem::layouts.master')
@section('page-title')
    {{ __('Booking Request') }}
@endsection

@section('content')
    <div class="auth-wrapper auth-v1">
        <div class="bg-auth-side bg-primary"></div>
        <div class="auth-content">
            <nav class="navbar navbar-expand-md navbar-dark default dark_background_color">
                <div class="container-fluid pe-2">
                    <a class="navbar-brand" href="#">
                        <img src="{{ !empty(company_setting('logo_light', $workspace->created_by, $workspace->id)) ? get_file(company_setting('logo_light', $workspace->created_by, $workspace->id)) : get_file(!empty(admin_setting('logo_light', $workspace->created_by, $workspace->id)) ? admin_setting('logo_light') : 'uploads/logo/logo_light.png', $workspace->created_by, $workspace->id) }}{{ '?' . time() }}"
                            class="navbar-brand-img auth-navbar-brand" style="
                    max-width: 168px;">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                        <ul class="navbar-nav align-items-center ms-auto mb-2 mb-lg-0">
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="row align-items-center justify-content-center text-start">
                <div class="col-xl-12 text-center">
                    <div class="mx-3 mx-md-5 mt-3">
                    </div>
                    @if (Session::has('create_request'))
                        <div class="alert alert-success">
                            <p>{!! session('create_request') !!}</p>

                        </div>
                    @endif
                    @if (Session::has('create_request_error'))
                        <div class="alert alert-danger">
                            <p>{!! session('create_request_error') !!}</p>

                        </div>
                    @endif
                    <div class="card">
                        <div class="card-body w-100">
                            <div class="">
                                <h4 class="text-primary mb-4">{{ __('Booking Request') }}</h4>
                            </div>
                            <form method="post" action="{{ route('freight.request.store', $workspace->slug) }}"
                                class="create-form" enctype="multipart/form-data">
                                @csrf
                                <div class="text-start row">
                                    <div class="form-group col-md-6">
                                        <div class="row mt-1">
                                            <label class="form-check-label form-label" for="direction">{{ __('Direction') }}
                                            </label>
                                            <div class="d-flex radio-check">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="import" value="import" name="direction"
                                                        class="custom-control-input" checked>
                                                    <label class="custom-control-label" for="import">
                                                        {{ __('Import') }}</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="export" value="export" name="direction"
                                                        class="custom-control-input">
                                                    <label class="custom-control-label" for="export">
                                                        {{ __('Export') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="row mt-1">
                                            <label class="form-check-label form-label" for="transport">{{ __('Transport') }}
                                            </label>
                                            <div class="d-flex radio-check">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="air" value="air" name="transport"
                                                        class="custom-control-input" checked>
                                                    <label class="custom-control-label" for="air">
                                                        {{ __('Air') }}</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="ocean" value="ocean" name="transport"
                                                        class="custom-control-input">
                                                    <label class="custom-control-label" for="ocean">
                                                        {{ __('Ocean') }}</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="land" value="land" name="transport"
                                                        class="custom-control-input">
                                                    <label class="custom-control-label" for="land">
                                                        {{ __('Land') }}</label>
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
                                                <div class=" bg-primary "> <i
                                                        class="ti ti-upload px-1"></i>{{ __('Choose file here') }}</div>
                                                <input type="file" class="form-control file" name="attechment"
                                                    id="attechment"
                                                    onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])"
                                                    data-filename="attechment">
                                            </label>
                                            <img id="blah" width="100" src="" />
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <div class="d-block ">
                                            <button class="btn btn-primary">
                                                {{ __('Create Request') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
