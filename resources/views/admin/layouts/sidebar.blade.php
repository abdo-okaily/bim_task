<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('admin.home') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('images/logo.svg') }}" alt="" height="80">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('images/logo.svg') }}" alt="" height="80">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('admin.home') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('images/logo.svg') }}" alt="" height="80">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('images/logo.svg') }}" alt="" height="80">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>@lang('admin.menu')</span></li>
                <li class="nav-item">
                    <a href="{{ route('admin.customers.index') }}" class="nav-link">
                        <i data-feather="home" class="icon-dual"></i>
                        <span>@lang('admin.customers_list')</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#orders" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="orders">
                        <i data-feather="home" class="icon-dual"></i> <span>@lang('admin.transactions')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="orders">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.transactions.index') }}" class="nav-link">@lang('admin.transactions_list')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.carts.index') }}" class="nav-link">@lang('admin.carts_list')</a>
                            </li>
                        </ul>
                    </div>
                </li><li class="nav-item">
                    <a class="nav-link menu-link" href="#categories" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="categories">
                        <i class="bx bx-purchase-tag-alt"></i> <span>@lang('admin.categories.title_main')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="categories">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.categories.index') }}" >
                                    <i class="bx bx-category-alt"></i> @lang('admin.categories.title')
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
