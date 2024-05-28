<div class="modal-body">
    <div class="row">
        <div class="col-md-12 mb-2">
            <div class="form-group mb-0 row ">
                <label class="form-label col-lg-2 col-md-auto col-auto mb-0" for="direction">{{ __('Code') }} :
                </label>
                <div class="col-auto p-0">
                    {{ Modules\FreightManagementSystem\Entities\FreightBookingRequest::bookingRequestCodeNumberFormat($book_request->code) }}
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group mb-0 row ">
                <label class="form-label col-lg-2 col-md-auto col-auto" for="direction">{{ __('Direction') }} :
                </label>
                <div class=" d-flex col-3 p-0" style="justify-content: space-between;">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="direction" value="import" id="import"
                            disabled {{ $book_request->direction == 'import' ? 'checked' : '' }}>
                        <label class="form-check-label" for="import">
                            {{ __('Import') }}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="direction" value="export" id="export"
                            disabled {{ $book_request->direction == 'export' ? 'checked' : '' }}>
                        <label class="form-check-label" for="export">
                            {{ __('Export') }}
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group row mb-0">
                <label class="form-label col-lg-2 col-md-auto col-auto" for="transport">{{ __('Transport') }} :
                </label>
                <div class=" d-flex col-md-5  col-auto p-0" style="justify-content: space-between;">
                    <div class="form-check mr-2">
                        <input class="form-check-input" type="radio" name="transport" value="air" id="air"
                            disabled {{ $book_request->transport == 'air' ? 'checked' : '' }}>
                        <label class="form-check-label" for="air" style="margin-right: 0.5rem;">
                            {{ __('Air') }}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="transport" value="ocean" id="ocean"
                            disabled {{ $book_request->transport == 'ocean' ? 'checked' : '' }}>
                        <label class="form-check-label" for="ocean">
                            {{ __('Ocean') }}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="transport" value="land" id="land"
                            disabled {{ $book_request->transport == 'land' ? 'checked' : '' }}>
                        <label class="form-check-label" for="land">
                            {{ __('Land') }}
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-2">
            <div class="form-group mb-0 row ">
                <label class="form-label col-lg-2 col-md-auto col-auto mb-0" for="direction">{{ __('Customer') }} :
                </label>
                <div class="col-auto p-0">
                    {{ $book_request->customer_name }}
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <small>
                    <strong>{{ __('Status') }} :</strong><br>
                    @if ($book_request->status == 0)
                        <span
                            class="badge fix_badges bg-info p-2 px-4 rounded book_request_status">{{ __(Modules\FreightManagementSystem\Entities\FreightBookingRequest::$statues[$book_request->status]) }}</span>
                    @elseif($book_request->status == 1)
                        <span
                            class="badge fix_badges bg-success p-2 px-4 rounded book_request_status">{{ __(Modules\FreightManagementSystem\Entities\FreightBookingRequest::$statues[$book_request->status]) }}</span>
                    @elseif($book_request->status == 2)
                        <span
                            class="badge fix_badges bg-danger p-2 px-4 rounded book_request_status">{{ __(Modules\FreightManagementSystem\Entities\FreightBookingRequest::$statues[$book_request->status]) }}</span>
                    @elseif($book_request->status == 3)
                        <span
                            class="badge fix_badges bg-warning p-2 px-4 rounded book_request_status">{{ __(Modules\FreightManagementSystem\Entities\FreightBookingRequest::$statues[$book_request->status]) }}</span>
                    @elseif($book_request->status == 4)
                        <span
                            class="badge fix_badges bg-danger p-2 px-4 rounded book_request_status">{{ __(Modules\FreightManagementSystem\Entities\FreightBookingRequest::$statues[$book_request->status]) }}</span>
                    @endif
                </small>
            </div>
        </div>
        <div class="row justify-content-between align-items-center mt-3">
            <div class="col-md-12">
                <ul class="nav nav-pills nav-fill cust-nav information-tab" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="maun_carriage-tab" data-bs-toggle="pill"
                            data-bs-target="#main_carriage" type="button">{{ __('Main Carriage') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="general-tab" data-bs-toggle="pill" data-bs-target="#general"
                            type="button">{{ __('General') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="image-tab" data-bs-toggle="pill" data-bs-target="#image"
                            type="button">{{ __('Image') }}</button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade active show" id="main_carriage" role="tabpanel"
                        aria-labelledby="pills-user-tab-2">
                        <div class="card-body my-4">
                            <div class="form-group mb-0 row ">
                                <label class="form-label col-lg-2 col-md-auto col-auto"
                                    for="loading_port">{{ __('Loading Port') }} :
                                </label>
                                <div class="col-auto p-0">
                                    {{ $book_request->loading_port }}
                                </div>
                            </div>
                            <div class="form-group row mb-0 ">
                                <label class="form-label col-lg-2 col-md-auto col-auto " for="discharge_port"
                                    style="padding-right:0px;">{{ __('Discharge Port') }} :
                                </label>
                                <div class="col-auto p-0">
                                    {{ $book_request->discharge_port }}
                                </div>
                            </div>
                            <div class="form-group  row mb-0 ">
                                <label class="form-label col-lg-2 col-md-auto col-auto "
                                    for="vessel">{{ __('Vessel') }} :
                                </label>
                                <div class="col-auto p-0">
                                    {{ $book_request->vessel }}
                                </div>
                            </div>
                            <div class="form-group  row mb-0 ">
                                <label class="form-label col-lg-2 col-md-auto col-auto "
                                    for="date">{{ __('Date') }} :
                                </label>
                                <div class="col-auto p-0">
                                    {{ company_date_formate($book_request->date) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="general" role="tabpanel" aria-labelledby="pills-user-tab-2">
                        <div class="card-body my-4">
                            <div class="form-group  row mb-0 ">
                                <label class="form-label col-lg-2 col-md-auto col-auto "
                                    for="barcode">{{ __('Barcode No') }} :
                                </label>
                                <div class="col-auto p-0">
                                    {{ $book_request->barcode }}
                                </div>
                            </div>
                            <div class="form-group  row mb-0 ">
                                <label class="form-label col-lg-2 col-md-auto col-auto "
                                    for="tracking_no">{{ __('Tracking No') }} :
                                </label>
                                <div class="col-auto p-0">
                                    {{ $book_request->tracking_no }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="image" role="tabpanel" aria-labelledby="pills-user-tab-2">
                        <div class="card-body my-4 text-center">
                            <img width="25%"
                                src="{{ !empty($book_request->attechment) ? get_file($book_request->attechment) : '' }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
