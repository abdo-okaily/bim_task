<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18"><?php echo e($title); ?></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo e($li_1); ?></a></li>
                    <?php if(isset($link_name)): ?>
                        <li class="breadcrumb-item"><a href="<?php echo e($link); ?>"><?php echo e($link_name); ?></a></li>
                    <?php endif; ?>
                    <?php if(isset($breadcrumbParent)): ?>
                        <li class="breadcrumb-item">
                            <a href="<?php if(isset($breadcrumbParentUrl)): ?><?php echo e($breadcrumbParentUrl); ?><?php endif; ?>">
                                <?php echo e(__('breadcrumb.'. $breadcrumbParent)); ?>

                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(isset($title)): ?>
                        <li class="breadcrumb-item active"><?php echo e($title); ?></li>
                    <?php endif; ?>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->
<?php /**PATH /Users/abdo/Sites/localhost/saudi-dates/resources/views/components/breadcrumb.blade.php ENDPATH**/ ?>