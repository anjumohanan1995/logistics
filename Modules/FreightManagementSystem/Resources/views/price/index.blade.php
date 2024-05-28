@extends('layouts.main')
@section('page-title')
    {{ __('Manage Price') }}
@endsection
@section('page-breadcrumb')
    {{ __('Manage Price') }}
@endsection
@section('page-action')
    <div>
        @permission('price create')
            <a class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="md" data-title="{{ __('Create Price') }}"
                data-url="{{ route('price.create') }}" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Create') }}">
                <i class="ti ti-plus"></i>
            </a>
        @endpermission
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-3">
            @include('freightmanagementsystem::layouts.setup')
        </div>
        <div class="col-sm-9">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table mb-0 ">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Volume Price') }}</th>
                                    <th>{{ __('Weight Price') }}</th>
                                    <th>{{ __('Service Price') }}</th>
                                    @if (Laratrust::hasPermission('price edit') || Laratrust::hasPermission('price delete'))
                                        <th width="200px">{{ __('Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($prices as $price)
                                    <tr>
                                        <td>{{ $price->name }}</td>
                                        <td>{{ $price->volume_price }}</td>
                                        <td>{{ $price->weight_price }}</td>
                                        <td>{{ $price->service_price }}</td>
                                        @if (Laratrust::hasPermission('price edit') || Laratrust::hasPermission('price delete'))
                                            <td class="Action">
                                                <span>
                                                    @permission('price edit')
                                                        <div class="action-btn bg-info ms-2">
                                                            <a class="mx-3 btn btn-sm  align-items-center"
                                                                data-url="{{ route('price.edit', $price->id) }}"
                                                                data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                                title="" data-title="{{ __('Edit Price') }}"
                                                                data-bs-original-title="{{ __('Edit') }}">
                                                                <i class="ti ti-pencil text-white"></i>
                                                            </a>
                                                        </div>
                                                    @endpermission
                                                    @permission('price delete')
                                                        <div class="action-btn bg-danger ms-2">
                                                            {{ Form::open(['route' => ['price.destroy', $price->id], 'class' => 'm-0']) }}
                                                            @method('DELETE')
                                                            <a class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm"
                                                                data-bs-toggle="tooltip" title=""
                                                                data-bs-original-title="Delete" aria-label="Delete"
                                                                data-confirm="{{ __('Are You Sure?') }}"
                                                                data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                                data-confirm-yes="delete-form-{{ $price->id }}"><i
                                                                    class="ti ti-trash text-white text-white"></i></a>
                                                            {{ Form::close() }}
                                                        </div>
                                                    @endpermission
                                                </span>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    @include('layouts.nodatafound')
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
