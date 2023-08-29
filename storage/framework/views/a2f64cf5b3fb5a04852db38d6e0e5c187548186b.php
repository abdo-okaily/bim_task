<!-- Layout config Js -->
<script src="<?php echo e(URL::asset('assets/js/layout.js')); ?>"></script>
<!-- Bootstrap Css -->
<!-- Icons Css -->
<?php if(app()->getLocale() == 'en'): ?>
<link href="<?php echo e(URL::asset('assets/css/bootstrap.min.css')); ?>"  rel="stylesheet" type="text/css" />
<?php endif; ?>
<?php if(app()->getLocale() == 'ar'): ?>
<link href="<?php echo e(URL::asset('assets/css/bootstrap.rtl.css')); ?>"  rel="stylesheet" type="text/css" />
<?php endif; ?>
<link href="<?php echo e(URL::asset('assets/css/icons.min.css')); ?>" rel="stylesheet" type="text/css" />
<!-- App Css-->
<?php if(app()->getLocale() == 'en'): ?>
<link href="<?php echo e(URL::asset('assets/css/app.min.css')); ?>"  rel="stylesheet" type="text/css" />
<?php endif; ?>
<?php if(app()->getLocale() == 'ar'): ?>
<link href="<?php echo e(URL::asset('assets/css/app.rtl.css')); ?>"  rel="stylesheet" type="text/css" />
<?php endif; ?>
<!-- custom Css-->
<link href="<?php echo e(URL::asset('assets/css/custom.min.css')); ?>"  rel="stylesheet" type="text/css" />
<style>
	.required {
		color: red;
	}
</style>

<link href="https://fonts.cdnfonts.com/css/dubai" rel="stylesheet">
<style>
    @font-face {
        font-family: 'Dubai', sans-serif;
    }
    * {
        /* font-family: "Tahoma", sans-serif;
        font-weight: bolder; */
        font-family: 'Dubai', sans-serif !important;

    }
    h1, h2, h3, h4, h5, h6 {
        font-family: 'Dubai', sans-serif;

    }
    .menu-link {
        font-weight: bolder!important;
    }
    .mb-4 {
        font-family: 'Dubai', sans-serif;
        font-weight: bold!important;
    }
    .nav-link{
        font-family: 'Dubai', sans-serif;
        font-weight: bolder!important;
    }
</style>
<?php echo $__env->yieldContent('css'); ?>

<?php /**PATH /Users/abdo/Sites/localhost/saudi-dates/resources/views/vendor/layouts/head-css.blade.php ENDPATH**/ ?>