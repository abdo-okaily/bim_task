<div class="accordion accordion-flush" id="accordionFlushExample">
<?php if(count($row->new_images) > 0): ?>
<div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingImages">
        <button class="accordion-button" type="button" data-bs-toggle="collapse"
            data-bs-target="#flush-collapseImages" aria-expanded="true" aria-controls="flush-collapseImages">
            <?php echo app('translator')->get('admin.products.images'); ?>
        </button>
    </h2>
    <div id="flush-collapseImages" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne"
        data-bs-parent="#accordionFlushExample">
        <div class="accordion-body">
            <?php $__currentLoopData = $row->temp->images(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $temp_image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <img src="<?php echo e(url($temp_image)); ?>" style="max-width: 270px;">
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__currentLoopData = json_decode($row->temp->updated_data,true) ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$fieldUpdated): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($key=='image'): ?>
        <?php if(! $fieldUpdated): ?>
            <?php continue; ?>
        <?php endif; ?>
    <?php endif; ?>
    <div class="accordion-item">
        <h2 class="accordion-header" id="flush-headingOne<?php echo e($key); ?>">
            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                data-bs-target="#flush-collapseOne<?php echo e($key); ?>" aria-expanded="true" aria-controls="flush-collapseOne">
                <?php echo app('translator')->get('admin.'.$key); ?>
            </button>
        </h2>
        <div id="flush-collapseOne<?php echo e($key); ?>" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne"
            data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
                <?php echo app('translator')->get('admin.products.field_changed'); ?> <?php echo app('translator')->get('admin.'.$key); ?>
                
                <?php if($key=='image'): ?>
                    <?php echo app('translator')->get('admin.from'); ?>
                    <img src="<?php echo e(url($row->image)); ?>" style="max-width: 270px;">
                    <?php echo app('translator')->get('admin.to'); ?>
                    <img src="<?php echo e(url($fieldUpdated)); ?>" style="max-width: 270px;">
                <?php else: ?>
                    <?php if($row->$key != $row->temp->$key): ?>
                        <?php if($key=='quantity_type_id'): ?>
                            <?php echo app('translator')->get('admin.from'); ?>
                                <?php echo e($row->quantity_type?->name); ?>

                            <?php echo app('translator')->get('admin.to'); ?>
                                <?php echo e($row->temp->quantity_type?->name); ?>

                        <?php elseif($key=='category_id'): ?>
                            <?php echo app('translator')->get('admin.from'); ?>
                                <?php echo e($row->category?->name); ?>

                            <?php echo app('translator')->get('admin.to'); ?>
                                <?php echo e($row->temp->category?->name); ?>

                        <?php elseif($key=='sub_category_id'): ?>
                            <?php echo app('translator')->get('admin.from'); ?>
                                <?php echo e($row->subCategory?->name); ?>

                            <?php echo app('translator')->get('admin.to'); ?>
                                <?php echo e($row->temp->subCategory?->name); ?>

                        <?php elseif($key=='final_category_id'): ?>
                            <?php echo app('translator')->get('admin.from'); ?>
                                <?php echo e($row->finalSubCategory?->name); ?>

                            <?php echo app('translator')->get('admin.to'); ?>
                                <?php echo e($row->temp->finalSubCategory?->name); ?>

                        <?php elseif($key=='type_id'): ?>
                            <?php echo app('translator')->get('admin.from'); ?>
                                <?php echo e($row->type?->name); ?>

                            <?php echo app('translator')->get('admin.to'); ?>
                                <?php echo e($row->temp->type?->name); ?>

                        <?php elseif($key == "price"): ?>
                            <?php echo e(number_format(json_decode($row->temp?->updated_data,true)["price"] / 100, 2)); ?> <?php echo app('translator')->get("translation.sar"); ?>
                        <?php elseif($key == "price_before_offer"): ?>
                            <?php echo e(number_format(json_decode($row->temp?->updated_data,true)["price_before_offer"] / 100, 2)); ?> <?php echo app('translator')->get("translation.sar"); ?>
                        <?php else: ?>
                        <?php echo app('translator')->get('admin.from'); ?>
                            <?php echo e($row->$key); ?>

                        <?php echo app('translator')->get('admin.to'); ?>
                            <?php echo e($fieldUpdated); ?>

                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <?php $__currentLoopData = Config::get('app.locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $locale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <!-- translated name -->
                        <?php if($key=='name_'.$locale && $row->getTranslation('name',$locale) != $row->temp->getTranslation('name',$locale)): ?>
                            <?php echo app('translator')->get('admin.from'); ?>
                            <?php echo e($row->getTranslation('name',$locale)); ?>

                            <?php echo app('translator')->get('admin.to'); ?>
                            <?php echo e($row->temp->getTranslation('name',$locale)); ?>

                        <?php endif; ?>
                         <!-- translated desc -->
                        <?php if($key=='desc_'.$locale && $row->getTranslation('desc',$locale) != $row->temp->getTranslation('desc',$locale)): ?>
                            <?php echo app('translator')->get('admin.from'); ?>
                            <?php echo $row->getTranslation('desc',$locale); ?>

                            <?php echo app('translator')->get('admin.to'); ?>
                            <?php echo $row->temp->getTranslation('desc',$locale); ?>

                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div><?php /**PATH /Users/abdo/Sites/localhost/saudi-dates/resources/views/admin/products/updates_accordion.blade.php ENDPATH**/ ?>