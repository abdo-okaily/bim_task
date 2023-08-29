<?php echo $__env->yieldContent('css'); ?>
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

<?php /**PATH /Users/abdo/Sites/localhost/saudi-dates/resources/views/layouts/head-css.blade.php ENDPATH**/ ?>