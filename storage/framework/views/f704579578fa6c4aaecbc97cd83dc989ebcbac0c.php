
<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.create-product'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('assets/libs/dropzone/dropzone.min.css')); ?>" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    <style>
        #form-loader {
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: black;
            z-index: 9999;
            opacity: .5;
            display: flex;
            justify-content: center;
            align-items: center
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Ecommerce
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            <?php echo app('translator')->get('translation.edit_product'); ?>
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <?php echo e(Form::model($row,['route' => ['vendor.products.update',$row->id],'id'=>'createproduct-form','autocomplete'=>'off','class'=>'needs-validation','method'=>'PATCH','enctype'=>'multipart/form-data'])); ?>

        
        <?php echo $__env->make('vendor.products.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo Form::close(); ?>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('assets/libs/@ckeditor/@ckeditor.min.js')); ?>"></script>

    <script src="<?php echo e(URL::asset('assets/libs/dropzone/dropzone.min.js')); ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <script src="<?php echo e(URL::asset('assets/js/pages/vendor-product-create.init.js')); ?>"></script>

    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
    <script>
        //dropzone is defined before at assets/js/pages/ecommerce-product-create.init.js
        <?php $__currentLoopData = $row->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            productImages_ids.push('<?php echo e($image->id); ?>')
            $('#images-hidden').val(productImages_ids.toString())
            dropzone.displayExistingFile({ name: "Filename", size: 12345 , id: "<?php echo e($image->id); ?>"}, '/<?php echo e($image->image); ?>');
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('vendor.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/abdo/Sites/localhost/saudi-dates/resources/views/vendor/products/edit.blade.php ENDPATH**/ ?>