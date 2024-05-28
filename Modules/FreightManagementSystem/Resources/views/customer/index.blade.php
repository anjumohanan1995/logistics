@extends('layouts.main')
@section('page-title')
    {{ __('Manage Customer') }}
@endsection
@section('page-breadcrumb')
    {{ __('Manage Customer') }}
@endsection
@section('page-action')
    <div>
        @permission('freight customer create')
            <a class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="md" data-title="{{ __('Create Customer') }}"
                data-url="{{ route('customers.create') }}" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Create') }}">
                <i class="ti ti-plus"></i>
            </a>
        @endpermission
    </div>
@endsection
@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table mb-0 pc-dt-simple" id="assets">
                        <thead>
                            <tr>
                                <th> {{ __('Name') }}</th>
                                <th> {{ __('Email') }}</th>
                                @if (Laratrust::hasPermission('freight customer edit') || Laratrust::hasPermission('freight customer delete'))
                                    <th width="10%"> {{ __('Action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                @if (Laratrust::hasPermission('freight customer edit') || Laratrust::hasPermission('freight customer delete'))
                                    <td class="Action">
                                        <span>
                                            @permission('freight customer edit')
                                                <div class="action-btn bg-info ms-2">
                                                    <a class="mx-3 btn btn-sm align-items-center"
                                                        data-url="{{ route('customers.edit', $customer->id) }}"
                                                        data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip" t
                                                        title="{{ __('Edit') }}" data-title="{{ __('Edit Customer') }}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                            @endpermission
                                            @php
                                                $user = \App\Models\User::where('id', $customer->user_id)->first();
                                            @endphp
                                            @if (!empty($user->id))
                                                @permission('freight customer delete')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {{ Form::open(['route' => ['customers.destroy', $customer->id], 'class' => 'm-0']) }}
                                                        @method('DELETE')
                                                        <a class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm"
                                                            data-bs-toggle="tooltip" title=""
                                                            data-bs-original-title="Delete" aria-label="Delete"
                                                            data-confirm="{{ __('Are You Sure?') }}"
                                                            data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                            data-confirm-yes="delete-form-{{ $customer->id }}"><i
                                                                class="ti ti-trash text-white text-white"></i></a>
                                                        {{ Form::close() }}
                                                    </div>
                                                @endpermission
                                            @endif
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
@endsection
