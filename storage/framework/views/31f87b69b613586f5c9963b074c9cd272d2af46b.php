<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="<?php echo e(route("vendor.index")); ?>" class="logo logo-dark">
            <span class="logo-sm">
                <img src="<?php echo e(URL::asset('images/logo.svg')); ?>" alt="" height="80">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(URL::asset('images/logo.svg')); ?>" alt="" height="80">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="<?php echo e(route("vendor.index")); ?>" class="logo logo-light">
            <span class="logo-sm">
                <img src="<?php echo e(url('images/logo.svg')); ?>" alt="" height="80">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(url('images/logo.svg')); ?>" alt="" height="80">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span><?php echo app('translator')->get('translation.menu'); ?></span></li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('vendor.index')); ?>">
                        <i data-feather="home" class="icon-dual"></i> <span><?php echo app('translator')->get('translation.dashboard'); ?></span>
                    </a>
                </li> <!-- end Dashboard Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i data-feather="grid" class="icon-dual"></i> <span><?php echo app('translator')->get('translation.products'); ?></span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApps">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('vendor.products.index')); ?>" class="nav-link"><?php echo app('translator')->get('translation.products_list'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('vendor.products.create')); ?>" class="nav-link"><?php echo app('translator')->get('translation.create_product'); ?></a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarOrders" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarOrders">
                        <i class="ri-shopping-cart-fill"></i> <span><?php echo app('translator')->get('translation.orders'); ?></span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarOrders">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('vendor.orders.index')); ?>" class="nav-link"><?php echo app('translator')->get('translation.all_orders_list'); ?></a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?php echo e(route('vendor.wallet')); ?>">
                        <i class="  ri-wallet-fill"></i> <span><?php echo app('translator')->get('translation.wallet'); ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?php echo e(route('vendor.product-reviews')); ?>">
                        <i class=" ri-star-half-line"></i> <span><?php echo app('translator')->get('translation.reviews'); ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?php echo e(route('vendor.users.index')); ?>">
                        <i class="ri-group-fill"></i> <span><?php echo app('translator')->get('translation.users'); ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?php echo e(route('vendor.roles.index')); ?>">
                        <i class="ri-admin-fill"></i> <span><?php echo app('translator')->get('translation.roles'); ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    
                    <a class="nav-link menu-link" href="<?php echo e(route('vendor.certificates.index')); ?>">
                        <i class=" ri-file-paper-2-fill"></i> <span><?php echo app('translator')->get('translation.certificates'); ?></span>
                    </a>
                </li>

                <li class="nav-item">
                    
                    <a class="nav-link menu-link" href="<?php echo e(route('vendor.warhouse_request.index')); ?>">
                        <i class="bx bx-git-pull-request"></i> <span><?php echo app('translator')->get('translation.warehouse-requests'); ?></span>
                    </a>
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
<?php /**PATH /Users/abdo/Sites/localhost/saudi-dates/resources/views/vendor/layouts/sidebar.blade.php ENDPATH**/ ?>