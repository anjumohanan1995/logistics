@extends('layouts.main')
@section('page-title')
    {{ __('Manage Container') }}
@endsection
@section('page-breadcrumb')
    {{ __('Manage Container') }}
@endsection
@section('page-action')
    <div>
        @permission('container create')
            <a class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="lg" data-title="{{ __('Create Container') }}"
                data-url="{{ route('container.create') }}" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Create') }}">
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
                                    <th>{{ __('Code') }}</th>
                                    <th>{{ __('Container Number') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Size') }}</th>
                                    <th>{{ __('Size UOM') }}</th>
                                    <th>{{ __('Volume') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    @if (Laratrust::hasPermission('container edit') || Laratrust::hasPermission('container delete'))
                                        <th width="200px" class="text-end">{{ __('Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($containers as $container)
                                    <tr>
                                        <td><a
                                                class="btn btn-outline-primary">{{ Modules\FreightManagementSystem\Entities\FreightContainer::containerCodeNumberFormat($container->code) }}</a>
                                        </td>
                                        <td><a
                                                class="btn btn-outline-primary">{{ Modules\FreightManagementSystem\Entities\FreightContainer::containerNumberNumberFormat($container->container_number) }}</a>
                                        </td>
                                        <td>{{ $container->name }}</td>
                                       
                                        <td>{{ $container->size }}</td>
                                        <td>{{ $container->size_uom }}</td>
                                        <td>{{ $container->volume_price }}</td>
                                        <td>{{ $container->status == 'on' ? "Available" : "Unavailable" }}</td>
                                        @if (Laratrust::hasPermission('container edit') || Laratrust::hasPermission('container delete'))
                                            <td class="Action text-end">
                                                <span>
                                                    @permission('container edit')
                                                        <div class="action-btn bg-info ms-2">
                                                            <a class="mx-3 btn btn-sm  align-items-center"
                                                                data-url="{{ route('container.edit', $container->id) }}"
                                                                data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                                title="" data-title="{{ __('Edit container') }}"
                                                                data-bs-original-title="{{ __('Edit') }}">
                                                                <i class="ti ti-pencil text-white"></i>
                                                            </a>
                                                        </div>
                                                    @endpermission
                                                    @permission('container delete')
                                                        <div class="action-btn bg-danger ms-2">
                                                            {{ Form::open(['route' => ['container.destroy', $container->id], 'class' => 'm-0']) }}
                                                            @method('DELETE')
                                                            <a class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm"
                                                                data-bs-toggle="tooltip" title=""
                                                                data-bs-original-title="Delete" aria-label="Delete"
                                                                data-confirm="{{ __('Are You Sure?') }}"
                                                                data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                                data-confirm-yes="delete-form-{{ $container->id }}"><i
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
