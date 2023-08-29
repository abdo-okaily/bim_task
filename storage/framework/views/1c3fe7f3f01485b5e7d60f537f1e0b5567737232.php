<!doctype html >
<html dir="rtl" lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo e(URL::asset('assets/images/favicon.ico')); ?>">
    <?php echo $__env->make('admin.layouts.head-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<?php $__env->startSection('body'); ?>
    <?php echo $__env->make('admin.layouts.body', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldSection(); ?>
    <!-- Begin page -->
    <div id="layout-wrapper">
        <?php echo $__env->make('admin.layouts.topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('admin.layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <?php if(Route::currentRouteName() != 'admin.home'): ?>
                        <?php $__env->startComponent('components.breadcrumb'); ?>
                            <?php if(isset($breadcrumbParent)): ?>
                                <?php $__env->slot('breadcrumbParent'); ?>
                                    <?php echo e($breadcrumbParent); ?>

                                <?php $__env->endSlot(); ?>
                                <?php if(isset($breadcrumbParentUrl)): ?>
                                    <?php $__env->slot('breadcrumbParentUrl'); ?>
                                        <?php echo e($breadcrumbParentUrl); ?>

                                    <?php $__env->endSlot(); ?>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php $__env->slot('li_1'); ?>
                                <?php $__env->slot('link'); ?>
                                    <?php echo e(route('admin.home')); ?>

                                <?php $__env->endSlot(); ?>
                                <?php $__env->slot('link_name'); ?>
                                    <?php echo app('translator')->get('translation.dashboard'); ?>
                                <?php $__env->endSlot(); ?>
                            <?php $__env->endSlot(); ?>
                            <?php $__env->slot('title'); ?>
                                <?php echo $__env->yieldContent('title'); ?>
                            <?php $__env->endSlot(); ?>
                        <?php echo $__env->renderComponent(); ?>
                    <?php endif; ?>
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            <?php echo $__env->make('admin.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- JAVASCRIPT -->
    <?php echo $__env->make('admin.layouts.vendor-scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>

</html>
<?php /**PATH /Users/abdo/Sites/localhost/bim_task/resources/views/admin/layouts/master.blade.php ENDPATH**/ ?>