<div class="card sticky-top" style="top:30px">
    <div class="list-group list-group-flush" id="useradd-sidenav">
        @permission('price manage')
            <a href="{{ route('price.index') }}"
                class="list-group-item list-group-item-action border-0 {{ request()->is('freightmanagementsystem/price*') ? 'active' : '' }}">{{ __('Price') }}
                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
            </a>
        @endpermission
        @permission('container manage')
            <a href="{{ route('container.index') }}"
                class="list-group-item list-group-item-action border-0 {{ request()->is('freightmanagementsystem/container*') ? 'active' : '' }}">{{ __('Container') }}
                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
            </a>
        @endpermission
        @permission('service manage')
            <a href="{{ route('service.index') }}"
                class="list-group-item list-group-item-action border-0 {{ request()->is('freightmanagementsystem/service*') ? 'active' : '' }}">{{ __('Service') }}
                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
            </a>
        @endpermission
    </div>
</div>
