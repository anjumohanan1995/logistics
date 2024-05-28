@extends('layouts.main')
@section('page-title')
    {{ __('Manage Service') }}
@endsection
@section('page-breadcrumb')
    {{ __('Manage Service') }}
@endsection
@section('page-action')
    <div>
        @permission('service create')
            <a class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="md" data-title="{{ __('Create Service') }}"
                data-url="{{ route('service.create') }}" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Create') }}">
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
                                    <th>{{ __('Cost Price') }}</th>
                                    <th>{{ __('Sale Price') }}</th>
                                    @if (Laratrust::hasPermission('service edit') || Laratrust::hasPermission('service delete'))
                                        <th width="200px">{{ __('Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($services as $service)
                                    <tr>
                                        <td>{{ $service->name }}</td>
                                        <td>{{ $service->cost_price }}</td>
                                        <td>{{ $service->sale_price }}</td>
                                        @if (Laratrust::hasPermission('service edit') || Laratrust::hasPermission('service delete'))
                                            <td class="Action">
                                                <span>
                                                    @permission('service edit')
                                                        <div class="action-btn bg-info ms-2">
                                                            <a class="mx-3 btn btn-sm  align-items-center"
                                                                data-url="{{ route('service.edit', $service->id) }}"
                                                                data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                                title="" data-title="{{ __('Edit Service') }}"
                                                                data-bs-original-title="{{ __('Edit') }}">
                                                                <i class="ti ti-pencil text-white"></i>
                                                            </a>
                                                        </div>
                                                    @endpermission
                                                    @permission('service delete')
                                                        <div class="action-btn bg-danger ms-2">
                                                            {{ Form::open(['route' => ['service.destroy', $service->id], 'class' => 'm-0']) }}
                                                            @method('DELETE')
                                                            <a class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm"
                                                                data-bs-toggle="tooltip" title=""
                                                                data-bs-original-title="Delete" aria-label="Delete"
                                                                data-confirm="{{ __('Are You Sure?') }}"
                                                                data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                                data-confirm-yes="delete-form-{{ $service->id }}"><i
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
