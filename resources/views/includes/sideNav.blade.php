<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                <!-- Sidenav Menu Heading (Account)-->
                <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                <div class="sidenav-menu-heading d-sm-none">Account</div>
                <!-- Sidenav Link (Alerts)-->
                <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                <a class="nav-link d-sm-none" href="#!">
                    <div class="nav-link-icon"><i data-feather="bell"></i></div>
                    Alerts
                    <span class="badge bg-warning-soft text-warning ms-auto">4 New!</span>
                </a>
                <!-- Sidenav Link (Messages)-->
                <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                <a class="nav-link d-sm-none" href="#!">
                    <div class="nav-link-icon"><i data-feather="mail"></i></div>
                    Messages
                    <span class="badge bg-success-soft text-success ms-auto">2 New!</span>
                </a>
                <!-- Sidenav Menu Heading (Core)-->
                <div class="sidenav-menu-heading">Core</div>
                <!-- Sidenav Accordion (Dashboard)-->
                <a class="nav-link {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    {{ __('Dashboard') }}
                </a>
                <!-- Sidenav Heading (App Views)-->
                <div class="sidenav-menu-heading">{{ __('Manage') }}</div>
                <!-- Sidenav Accordion (Goods)-->
                <a class="nav-link {{ Request::segment(1) == 'goods' ? 'active' : 'collapsed' }}" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="{{ Request::segment(1) == 'goods' ? 'true' : 'false' }}" aria-controls="collapsePages">
                    <div class="nav-link-icon"><i data-feather="grid"></i></div>
                    {{ __('Goods') }}
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ Request::segment(1) == 'goods' ? 'show' : '' }}" id="collapsePages" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPagesMenu">
                        <!-- Nested Sidenav Accordion (Goods -> Brands)-->
                        <a class="nav-link {{ Request::segment(2) == 'companies' ? 'active' : '' }}" href="{{ route('companies.index') }}">
                            {{ __('Companies') }}
                        </a>
                        <!-- Nested Sidenav Accordion (Goods -> Categories)-->
                        @if (Auth::user()->role->name == 'administrator')
                            <a class="nav-link {{ Request::segment(2) == 'categories' ? 'active' : '' }}" href="{{ route('categories.index') }}">
                                {{ __('Categories') }}
                            </a>
                        @endif
                        <!-- Nested Sidenav Accordion (Goods -> Products)-->
                        <a class="nav-link {{ Request::segment(2) == 'products' ? 'active' : '' }}" href="{{ route('products.index') }}">
                            {{ __('Products') }}
                        </a>
                    </nav>
                </div>

                <a class="nav-link {{ Request::segment(1) == 'customers' ? 'active' : 'collapsed' }}" href="{{ route("customers.index") }}">
                    <div class="nav-link-icon"><i data-feather="users"></i></div>
                    {{ __('Customers') }}
                </a>

                <!-- Sidenav Accordion (Flows)-->
                <a class="nav-link {{ Request::segment(1) == 'orders' ? 'active' : 'collapsed' }}" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseFlows" aria-expanded="false" aria-controls="collapseFlows">
                    <div class="nav-link-icon"><i data-feather="list"></i></div>
                    {{ __('Orders') }}
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ Request::segment(1) == 'orders' ? 'show' : '' }}" id="collapseFlows" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link {{ Request::segment(1) == 'orders' && !Request::has('trash') ? 'active' : '' }}" href="{{ route('orders.index') }}">{{ __("All Orders") }}</a>
                    </nav>
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link {{ Request::segment(1) == 'orders' && Request::has('trash') ? 'active' : '' }}" href="{{ route('orders.index', 'trash') }}">{{ __("Deleted Orders") }}</a>
                    </nav>
                </div>

            </div>
        </div>
        <!-- Sidenav Footer-->
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">Logged in as:</div>
                <div class="sidenav-footer-title">{{ Auth::user()->name }}</div>
            </div>
        </div>
    </nav>
</div>
