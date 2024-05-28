@extends('layouts.main')
@section('page-title')
    {{ __('Manage Quotation') }}
@endsection
@section('page-breadcrumb')
    {{ __('Quotataion') }}
@endsection
@section('page-action')
    <div>
        @permission('quotation create')
            <a href="{{ route('quotation.create', 0) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                data-bs-original-title="{{ __('Create') }}">
                <i class="ti ti-plus"></i>
            </a>
        @endpermission
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table mb-0 pc-dt-simple" id="assets">
                            <thead>
                                <tr>
                                    <th> {{ __('Quotation') }}</th>
                                    <th>{{ __('Account Type') }}</th>

                                    @if (\Auth::user()->type != 'client')
                                        <th> {{ __('Customer') }}</th>
                                    @endif
                                    <th> {{ __('Warehouse') }}</th>
                                    <th> {{ __('Quotation Date') }}</th>
                                    <th> {{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($quotations as $quotation)
                                    <tr class="font-style">
                                        <td class="Id">
                                            <a href="{{ route('quotation.show', \Crypt::encrypt($quotation->id)) }}"
                                                class="btn btn-outline-primary">{{ Modules\Quotation\Entities\Quotation::quotationNumberFormat($quotation->quotation_id) }}
                                            </a>
                                        </td>
                                        <td>{{ $quotation->account_type }}</td>
                                        @if (\Auth::user()->type != 'client')
                                            <td> {{ !empty($quotation->customer) ? $quotation->customer->name : '' }} </td>
                                        @endif
                                        <td>{{ !empty($quotation->warehouse) ? $quotation->warehouse->name : '' }}</td>
                                        <td>{{ company_date_formate($quotation->quotation_date) }}</td>

                                        @if (Laratrust::hasPermission('quotation edit') ||
                                                Laratrust::hasPermission('quotation delete') ||
                                                Laratrust::hasPermission('quotation convert'))
                                            <td class="Action">
                                                <span>
                                                @if (module_is_active('Pos'))

                                                    @if ($quotation->quotation == 'pos')
                                                        @permission('quotation convert')
                                                            <div class="action-btn bg-warning ms-2">
                                                                <a href="{{ route('pos.index', ['quotation_id' => $quotation->id]) }}"
                                                                    class="mx-3 btn btn-sm align-items-center"
                                                                    data-bs-toggle="tooltip" title="{{ __('Convert to POS') }}"
                                                                    data-original-title="{{ __('Detail') }}">
                                                                    <i class="ti ti-exchange text-white"></i>
                                                                </a>
                                                            </div>
                                                        @endpermission
                                                    @endif
                                                @endif


                                                    @if ($quotation->quotation == 'invoice')
                                                        @permission('quotation convert')
                                                            <div class="action-btn bg-success ms-2">
                                                                <a href="{{ route('quotation.convert.invoice', \Crypt::encrypt($quotation->id)) }}"
                                                                    class="mx-3 btn btn-sm  align-items-center"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-original-title="{{ __('Convert to Invoice') }}"
                                                                    data-text="{{ __('This action can not be undone. Do you want to continue?') }}">
                                                                    <i class="ti ti-exchange text-white"></i>
                                                                </a>
                                                            </div>
                                                        @endpermission
                                                    @endif


                                                    @permission('quotation edit')
                                                        <div class="action-btn bg-primary ms-2">
                                                            <a href="{{ route('quotation.edit', \Crypt::encrypt($quotation->id)) }}"
                                                                class="mx-3 btn btn-sm align-items-center"
                                                                data-bs-toggle="tooltip" title="Edit"
                                                                data-original-title="{{ __('Edit') }}">
                                                                <i class="ti ti-pencil text-white"></i>
                                                            </a>
                                                        </div>
                                                    @endpermission
                                                    @permission('quotation delete')
                                                        <div class="action-btn bg-danger ms-2">
                                                            {{ Form::open(['route' => ['quotation.destroy', $quotation->id], 'class' => 'm-0']) }}
                                                            @method('DELETE')
                                                            <a href="#"
                                                                class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm"
                                                                data-bs-toggle="tooltip" title=""
                                                                data-bs-original-title="Delete" aria-label="Delete"
                                                                data-confirm="{{ __('Are You Sure?') }}"
                                                                data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                                data-confirm-yes="delete-form-{{ $quotation->id }}"><i
                                                                    class="ti ti-trash text-white text-white"></i></a>
                                                            {{ Form::close() }}
                                                        </div>
                                                    @endpermission
                                                </span>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
