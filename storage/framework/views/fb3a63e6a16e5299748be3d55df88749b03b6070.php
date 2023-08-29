<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="<?php echo e(route('admin.home')); ?>" class="logo logo-dark">
            <span class="logo-sm">
                <img src="<?php echo e(URL::asset('images/logo.svg')); ?>" alt="" height="80">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(URL::asset('images/logo.svg')); ?>" alt="" height="80">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="<?php echo e(route('admin.home')); ?>" class="logo logo-light">
            <span class="logo-sm">
                <img src="<?php echo e(URL::asset('images/logo.svg')); ?>" alt="" height="80">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(URL::asset('images/logo.svg')); ?>" alt="" height="80">
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
                <?php if(auth()->user()?->isAdminPermittedTo('admin.customers.index')): ?>
                <li class="menu-title"><span><?php echo app('translator')->get('admin.menu'); ?></span></li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('admin.customers.index')); ?>" class="nav-link">
                            <i data-feather="home" class="icon-dual"></i>
                            <span><?php echo app('translator')->get('admin.customers_list'); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                
                <?php if(auth()->user()?->isAdminPermittedToList(['admin.vendors.index','admin.roles.index','admin.vendor-users.index'])): ?>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#vendors" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="vendors">
                        <i data-feather="home" class="icon-dual"></i> <span><?php echo app('translator')->get('admin.vendors'); ?></span>
                    </a>


                    <div class="collapse menu-dropdown" id="vendors">
                        <ul class="nav nav-sm flex-column">
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.vendors.index')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.vendors.index')); ?>" class="nav-link"><?php echo app('translator')->get('admin.vendors_list'); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.roles.index')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.roles.index')); ?>" class="nav-link"><?php echo app('translator')->get('admin.permission_vendor_roles'); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.vendor-users.index')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.vendor-users.index')); ?>" class="nav-link"><?php echo app('translator')->get('admin.permission_vendor_users'); ?></a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
                <?php endif; ?>
                <?php if(auth()->user()?->isAdminPermittedTo('admin.certificates.index')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.certificates.index')); ?>" class="nav-link">
                        <i data-feather="home" class="icon-dual"></i>
                        <span><?php echo app('translator')->get('admin.certificates'); ?></span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if(auth()->user()?->isAdminPermittedTo('admin.coupons.index')): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.coupons.index')); ?>">
                        <i data-feather="home"></i>
                        <span><?php echo app('translator')->get('admin.coupons_title'); ?></span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if(auth()->user()?->isAdminPermittedToList(['admin.transactions.index','admin.carts.index'])): ?>           
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#orders" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="orders">
                        <i data-feather="home" class="icon-dual"></i> <span><?php echo app('translator')->get('admin.transactions'); ?></span>
                    </a>
                    <div class="collapse menu-dropdown" id="orders">
                        <ul class="nav nav-sm flex-column">
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.transactions.index')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.transactions.index')); ?>" class="nav-link"><?php echo app('translator')->get('admin.transactions_list'); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.carts.index')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.carts.index')); ?>" class="nav-link"><?php echo app('translator')->get('admin.carts_list'); ?></a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
                <?php endif; ?>
                <?php if(auth()->user()?->isAdminPermittedToList(['admin.wallets.index','admin.customer-cash-withdraw.index'])): ?>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#customer_finances" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="customer_finances">
                        <i class="bx bx-dollar-circle"></i> <span><?php echo app('translator')->get('admin.customer_finances.title'); ?></span>
                    </a>
                    <div class="collapse menu-dropdown" id="customer_finances">
                        <ul class="nav nav-sm flex-column">
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.wallets.index')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('admin.wallets.index')); ?>">
                                    <i class="bx bx-wallet"></i> <?php echo app('translator')->get('admin.customer_finances.wallets.title'); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.customer-cash-withdraw.index')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('admin.customer-cash-withdraw.index')); ?>">
                                    <i class="bx bx-wallet"></i> <?php echo app('translator')->get('admin.customer_finances.customer-cash-withdraw.page-title'); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
                <?php endif; ?>
                <?php if(auth()->user()?->isAdminPermittedToList(['admin.categories.index','admin.productClasses.index','admin.product-quantities.index'])): ?>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#categories" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="categories">
                        <i class="bx bx-purchase-tag-alt"></i> <span><?php echo app('translator')->get('admin.categories.title_main'); ?></span>
                    </a>
                    <div class="collapse menu-dropdown" id="categories">
                        <ul class="nav nav-sm flex-column">
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.categories.index')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('admin.categories.index')); ?>" >
                                    <i class="bx bx-category-alt"></i> <?php echo app('translator')->get('admin.categories.title'); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.productClasses.index')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('admin.productClasses.index')); ?>">
                                    <i class="bx bx-shape-triangle"></i> <?php echo app('translator')->get('admin.productClasses.title'); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.product-quantities.index')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('admin.product-quantities.index')); ?>">
                                    <i class="bx bx-shape-circle"></i> <?php echo app('translator')->get('admin.productQuantities.title'); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
                <?php endif; ?>
                <?php if(auth()->user()?->isAdminPermittedToList(['admin.countries.index','admin.areas.index','admin.cities.index'])): ?>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#countries" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="countries">
                        <i class="bx bx-target-lock"></i> <span><?php echo app('translator')->get('admin.countries_and_cities_title'); ?></span>
                    </a>
                    <div class="collapse menu-dropdown" id="countries">
                        <ul class="nav nav-sm flex-column">
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.countries.index')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('admin.countries.index')); ?>">
                                    <i class="ri-flight-takeoff-line"></i> <?php echo app('translator')->get('admin.countries.title'); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.areas.index')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('admin.areas.index')); ?>">
                                    <i class="bx bx-map-alt"></i> <?php echo app('translator')->get('admin.areas.title'); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.cities.index')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('admin.cities.index')); ?>">
                                    <i class="bx bx-directions"></i> <?php echo app('translator')->get('admin.cities.title'); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
                <?php endif; ?>
                <?php if(auth()->user()?->isAdminPermittedTo('admin.products.index')): ?>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sideproducts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="categories">
                        <i data-feather="home" class="icon-dual"></i> <span><?php echo app('translator')->get('admin.products.title'); ?></span>
                    </a>
                    <div class="collapse menu-dropdown" id="sideproducts">
                        <ul class="nav nav-sm flex-column">
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.products.index')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.products.index')); ?>" class="nav-link"><?php echo app('translator')->get('admin.products.title'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.products.index',['temp'=>1])); ?>" class="nav-link"><?php echo app('translator')->get('admin.products.updated_products'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.products.index',['status'=>"pending"])); ?>" class="nav-link"><?php echo app('translator')->get('admin.products.pending_products'); ?></a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
                <?php endif; ?>
                <?php if(auth()->user()?->isAdminPermittedToList(['admin.about-us.index','admin.privacy-policy.index','admin.usage-agreement.index'
                   ,'admin.qna.index','admin.recipe.index','admin.blog.index','admin.slider.index'])): ?>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#static-content" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="categories">
                        <i data-feather="home" class="icon-dual"></i> <span><?php echo app('translator')->get('admin.static-content.title'); ?></span>
                    </a>
                    <div class="collapse menu-dropdown" id="static-content">
                        <ul class="nav nav-sm flex-column">
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.about-us.index')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.about-us.index')); ?>" class="nav-link"><?php echo app('translator')->get('admin.static-content.about-us.page-title'); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.privacy-policy.index')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.privacy-policy.index')); ?>" class="nav-link">
                                    <?php echo app('translator')->get('admin.static-content.privacy-policy.page-title'); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.usage-agreement.index')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.usage-agreement.index')); ?>" class="nav-link">
                                    <?php echo app('translator')->get('admin.static-content.usage-agreement.page-title'); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.qna.index')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.qna.index')); ?>" class="nav-link">
                                    <?php echo app('translator')->get('admin.qnas.manage_qnas'); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.recipe.index')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.recipe.index')); ?>" class="nav-link">
                                    <?php echo app('translator')->get('admin.recipes.manage_recipes'); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.blog.index')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.blog.index')); ?>" class="nav-link">
                                    <?php echo app('translator')->get('admin.blogPosts.manage_blogPosts'); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.slider.index')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.slider.index')); ?>" class="nav-link">
                                    <?php echo app('translator')->get('admin.sliders.manage_sliders'); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
                <?php endif; ?>
                <?php if(auth()->user()?->isAdminPermittedToList(['admin.productRates.index','admin.vendorRates.index'])): ?>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#productRates" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="productRates">
                        <i class="bx bx-line-chart"></i> <span><?php echo app('translator')->get('admin.rates_title'); ?></span>
                    </a>
                    <div class="collapse menu-dropdown" id="productRates">
                        <ul class="nav nav-sm flex-column">
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.productRates.index')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('admin.productRates.index')); ?>">
                                    <i class="bx bx-chart"></i> <?php echo app('translator')->get('admin.productRates.title'); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.vendorRates.index')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('admin.vendorRates.index')); ?>">
                                    <i class="bx bx-chart"></i> <?php echo app('translator')->get('admin.vendorRates.title'); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
                <?php endif; ?>
                <?php if(auth()->user()?->isAdminPermittedToList(['admin.warehouses.index','admin.wareHouseRequests.index'])): ?>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#warehouses" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="warehouses">
                        <i class="bx bx-building-house"></i> <span><?php echo app('translator')->get('admin.warehouses.title'); ?></span>
                    </a>
                    <div class="collapse menu-dropdown" id="warehouses">
                        <ul class="nav nav-sm flex-column">
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.warehouses.index')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('admin.warehouses.index')); ?>" >
                                    <i class="bx bx-building-house"></i> <?php echo app('translator')->get('admin.warehouses.title'); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.wareHouseRequests.index')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('admin.wareHouseRequests.index')); ?>" >
                                    <i class="bx bx-git-pull-request"></i> <?php echo app('translator')->get('admin.wareHouseRequests.title'); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
                <?php endif; ?>
                <?php if(auth()->user()?->isAdminPermittedToGroup('delivery')): ?>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#delivery" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="delivery">
                        <i data-feather="truck" class="icon-dual"></i> <span><?php echo app('translator')->get('admin.delivery.title'); ?></span>
                    </a>
                    <div class="collapse menu-dropdown" id="delivery">
                        <ul class="nav nav-sm flex-column">
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.domestic-zones.index')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.domestic-zones.index')); ?>" class="nav-link">
                                    <i class="bx bx-map"></i> <?php echo app('translator')->get('admin.delivery.domestic-zones.title'); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.torodCompanies.index')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('admin.torodCompanies.index')); ?>" >
                                    <i class="bx bx-git-pull-request"></i> <?php echo app('translator')->get('admin.torodCompanies.title'); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.shipping-methods.index')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.shipping-methods.index')); ?>" class="nav-link">
                                    <i class="bx bxs-cog"></i>
                                    <span><?php echo app('translator')->get('admin.shippingMethods.manage_shippingMethods'); ?></span>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
                <?php endif; ?>
                <?php if(auth()->user()?->isAdminPermittedToList(['admin.subAdmins.index','admin.rules.index'])): ?>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#subAdmins" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="subAdmins">
                        <i class="bx bx-user-check"></i> <span><?php echo app('translator')->get('admin.team_title'); ?></span>
                    </a>
                    <div class="collapse menu-dropdown" id="subAdmins">
                        <ul class="nav nav-sm flex-column">
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.subAdmins.index')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('admin.subAdmins.index')); ?>">
                                    <i class="bx bx-user-pin"></i> <?php echo app('translator')->get('admin.subAdmins.title'); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.rules.index')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('admin.rules.index')); ?>">
                                    <i class="bx bx-user-x"></i> <?php echo app('translator')->get('admin.rules.title'); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
                <?php endif; ?>
                <?php if(auth()->user()?->isAdminPermittedTo('admin.vendorWallets.index')): ?>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#vendors_finances" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="vendors_finances">
                        <i class="bx bx-user-check"></i> <span><?php echo app('translator')->get('admin.vendorWallets.vendors_finances'); ?></span>
                    </a>
                    <div class="collapse menu-dropdown" id="vendors_finances">
                        <ul class="nav nav-sm flex-column">
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.vendorWallets.index')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('admin.vendorWallets.index')); ?>">
                                    <i class="bx bx-user-x"></i> <?php echo app('translator')->get('admin.vendorWallets.manage'); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
                <?php endif; ?>
                <?php if(auth()->user()?->isAdminPermittedToList(['admin.settings.index','admin.banks.index'])): ?>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#general-settings" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="general-settings">
                        <i class="bx bx-cog"></i> <span><?php echo app('translator')->get('admin.general_settings'); ?></span>
                    </a>
                    <div class="collapse menu-dropdown" id="general-settings">
                        <ul class="nav nav-sm flex-column">
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.settings.index')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('admin.settings.index')); ?>">
                                    <i class="bx bxs-cog"></i> <?php echo app('translator')->get('admin.settings.main'); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(auth()->user()?->isAdminPermittedTo('admin.banks.index')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('admin.banks.index')); ?>">
                                    <i class="bx bxs-bank"></i> <?php echo app('translator')->get('admin.banks.manage_banks'); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
<?php /**PATH /Users/abdo/Sites/localhost/saudi-dates/resources/views/admin/layouts/sidebar.blade.php ENDPATH**/ ?>