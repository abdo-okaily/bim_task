
<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('admin.dashboard'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('assets/libs/jsvectormap/jsvectormap.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(URL::asset('assets/libs/swiper/swiper.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('sweetalert::alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <iframe id="dashboard-statistics" src="https://dash.ncpd.io/public/dashboard/0b8751d3-c164-40c0-b208-342054a899d0"
        frameborder="0" width="100%" height="2300" allowtransparency></iframe>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script>
        window.setInterval("reloadIFrame();", 50000);

        function reloadIFrame() {
            document.getElementById("dashboard-statistics").src =
                "https://dash.ncpd.io/public/dashboard/0b8751d3-c164-40c0-b208-342054a899d0";
        }
    </script>
    <!-- apexcharts -->
    <script src="<?php echo e(URL::asset('/assets/libs/apexcharts/apexcharts.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/libs/jsvectormap/jsvectormap.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/libs/swiper/swiper.min.js')); ?>"></script>
    <!-- dashboard init -->
    <script src="<?php echo e(URL::asset('/assets/js/pages/dashboard-ecommerce.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/abdo/Sites/localhost/bim_task/resources/views/admin/index.blade.php ENDPATH**/ ?>