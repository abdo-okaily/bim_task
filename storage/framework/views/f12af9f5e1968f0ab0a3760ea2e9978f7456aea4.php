<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><?php echo app('translator')->get('translation.categories'); ?></h5>
            </div>
            <div class="card-body">
                <div class="mb-3" >
                    <label for="choices-publish-status-input" class="form-label"><?php echo app('translator')->get('translation.main_category'); ?><span class="required" >*</span></label>
                    <?php echo e(Form::select('category_id', $main_categories, $row->category_id ?? old('category_id'), ['class'=>'js-example-basic-single form-select','id'=>'main-choices-publish-status-input', 'placeholder'=>__('translation.main_category_placeholder'),'onchange'=>'getSubCategories($(this),2)',])); ?>

                    <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="error text-danger"> <?php echo e($message); ?> </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div id="sub-cat" style="margin-top:23px;" class="mb-3">
                    <label for="sub-choices-publish-visibility-input" class="form-label"><?php echo app('translator')->get('translation.sub_category'); ?></label>
                    <?php echo e(Form::select('sub_category_id', $sub_categories, $row->sub_category_id ?? old('sub_category_id'), ['class'=>'js-example-basic-single form-select ','id'=>'sub-choices-publish-status-input', 'placeholder'=>__('translation.main_category_placeholder'),'onchange'=>'getSubCategories($(this),3)'])); ?>

                    <?php $__errorArgs = ['sub_category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="error text-danger"> <?php echo e($message); ?> </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div id="final-cat" style="margin-top: 23px;" class="mb-3">
                    <label for="final-choices-publish-visibility-input" class="form-label"><?php echo app('translator')->get('translation.final_category'); ?></label>
                    <?php echo e(Form::select('final_category_id', $final_categories, $row->final_category_id ?? old('final_category_id'), ['class'=>'js-example-basic-single form-select','id'=>'final-choices-publish-status-input', 'placeholder'=>__('translation.main_category_placeholder')])); ?>

                    <?php $__errorArgs = ['final_category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="error text-danger"> <?php echo e($message); ?> </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <div class="card card-ar">
            <div class="card-body">
                <div class="mb-3">
                    <div class="mb-3">
                        <label class="form-label" for="product-name-input"><?php echo app('translator')->get('translation.product_name'); ?><span class="required" >*</span> (<?php echo app('translator')->get('admin.products.arabic_date'); ?>) </label>
                        <input type="text" class="form-control d-none" id="product-id-input">
                        <input type="hidden" class="form-control" id="formAction" name="formAction" value="add">
                        <?php echo e(Form::text('name[ar]',(isset($row))?$row->ar['name']:null,['class'=>'form-control','id'=>'product-name-input','placeholder'=> __('translation.product_name_plcaholder'),])); ?>

                        <div class="invalid-feedback"><?php echo app('translator')->get('translation.product_name_plcaholder'); ?></div>
                        <?php $__errorArgs = ['name[ar]'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="error text-danger"> <?php echo e($message); ?> </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div>
                    <input type="hidden" name="desc[ar]" id="desc-hidden">
                    <label><?php echo app('translator')->get('translation.product_desc'); ?></label>
                    <?php $__errorArgs = ['desc[ar]'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="error text-danger"> <?php echo e($message); ?> </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div id="ckeditor-classic">
                        <?php if(isset($row)): ?>
                            <?php echo $row->ar['desc']; ?>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-en">
            <div class="card-body">
                <div class="mb-3">
                    <div class="mb-3">
                        <label class="form-label" for="product-name-inputs"><?php echo app('translator')->get('translation.product_name'); ?><span class="required" >*</span> (<?php echo app('translator')->get('admin.products.english_date'); ?>)</label>
                        <input type="text" class="form-control d-none" id="product-id-inputs">
                        <?php echo e(Form::text('name[en]',(isset($row))?$row->en['name']:'',['class'=>'form-control','id'=>'product-name-inputs','placeholder'=> __('translation.product_name_plcaholder'),])); ?>

                        <div class="invalid-feedback"><?php echo app('translator')->get('translation.product_name_plcaholder'); ?></div>
                        <?php $__errorArgs = ['name[en]'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="error text-danger"> <?php echo e($message); ?> </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div>
                    <input type="hidden" name="desc[en]" id="desc-hiddens">
                    <label><?php echo app('translator')->get('translation.product_desc'); ?></label>
                    <?php $__errorArgs = ['desc[en]'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="error text-danger"> <?php echo e($message); ?> </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div id="ckeditor-classic_2">
                        <?php if(isset($row)): ?>
                            <?php echo $row->en['desc']; ?>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- end card -->

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><?php echo app('translator')->get('translation.product_gallery'); ?></h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <h5 class="fs-14 mb-1"><?php echo app('translator')->get('translation.product_image'); ?><span class="required" >*</span></h5>
                    <p class="text-muted"><?php echo app('translator')->get('translation.add_product_main_image'); ?></p>
                    <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="error text-danger"> <?php echo e($message); ?> </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <p id="main-image-preview-error" class="mt-3 error text-danger" style="display: none"></p>
                    <div class="text-center">
                        <div class="position-relative d-inline-block">
                            <div class="position-absolute top-100 start-100 translate-middle">
                                <label for="product-image-input" class="mb-0"  data-bs-toggle="tooltip" data-bs-placement="right" title="Select Image">
                                    <div class="avatar-xs">
                                        <div class="avatar-title bg-light border rounded-circle text-muted cursor-pointer">
                                            <i class="ri-image-fill"></i>
                                        </div>
                                    </div>
                                </label>
                                <input class="form-control d-none" value="" id="product-image-input" type="file"
                                    accept="image/png, image/gif, image/jpeg" name="image">
                            </div>
                            <div class="avatar-lg">
                                <div class="avatar-title bg-light rounded">
                                    <img src="<?php if(isset($row)): ?> <?php echo e(asset($row->image)); ?> <?php endif; ?>" id="product-img" class="avatar-md h-auto" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="images_array[]" id="images-hidden">
                <input type="hidden" name="deleted_images_array[]" id="deleted-images-hidden">
                <div>
                    <h5 class="fs-14 mb-1"><?php echo app('translator')->get('translation.product_gallery'); ?></h5>
                    <p class="text-muted"><?php echo app('translator')->get('translation.add_product_gallery_images'); ?></p>

                    <div class="dropzone">
                        <div class="fallback">
                            <input name="file" type="file" multiple="multiple">
                        </div>
                        <div class="dz-message needsclick">
                            <div class="mb-3">
                                <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                            </div>

                            <h5><?php echo app('translator')->get('translation.drop_files_here_or_click_to_upload'); ?></h5>
                        </div>
                    </div>

                    <p id="dropzone-preview-error" class="mt-3 error text-danger" style="display: none"></p>
                    <ul class="list-unstyled mb-0" id="dropzone-preview">
                        <li class="mt-2" id="dropzone-preview-list">
                            <!-- This is used as the file preview template -->
                            <div class="border rounded">
                                <div class="d-flex p-2">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar-sm bg-light rounded">
                                            <img data-dz-thumbnail class="img-fluid rounded d-block" src="#" alt="Product-Image" />
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="pt-1">
                                            <h5 class="fs-14 mb-1" data-dz-name>&nbsp;</h5>
                                            <p class="fs-13 text-muted mb-0" data-dz-size></p>
                                            <strong class="error text-danger" data-dz-errormessage></strong>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 ms-3">
                                        <button data-dz-remove class="btn btn-sm btn-danger"><?php echo app('translator')->get('translation.delete'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <!-- end dropzon-preview -->
                </div>
            </div>
        </div>
        <!-- end card -->
        <div class="text-end mb-3">
            <button type="submit" class="btn btn-success w-sm"><?php echo app('translator')->get('translation.submit'); ?></button>
        </div>
    </div>
    <!-- end col -->

    <div class="col-lg-4">
        <!-- end card -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><?php echo app('translator')->get('translation.sizes'); ?></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 col-sm-6">
                        <div class="mb-4">
                            <label class="form-label" for="manufacturer-name-input"><?php echo app('translator')->get('translation.total_weight'); ?> <?php echo app('translator')->get('translation.gram'); ?><span class="required" >*</span></label>
                            <?php echo e(Form::text('total_weight',$row->total_weight ?? old('total_weight'),['class'=>'form-control','id'=>'total-weight','placeholder'=> __('translation.total_weight_place_holder'),])); ?>

                            <?php $__errorArgs = ['total_weight'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error text-danger"> <?php echo e($message); ?> </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <div class="mb-2">
                            <label class="form-label" for="manufacturer-name-input"><?php echo app('translator')->get('translation.net_weight'); ?> <?php echo app('translator')->get('translation.gram'); ?><span class="required" >*</span></label>
                            <?php echo e(Form::text('net_weight', $row->net_weight ?? old('net_weight'), ['class'=>'form-control','id'=>'net-weight','placeholder'=> __('translation.net_weight_placeholder'),])); ?>

                            <?php $__errorArgs = ['net_weight'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error text-danger"> <?php echo e($message); ?> </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="manufacturer-name-input"><?php echo app('translator')->get('translation.length'); ?> <?php echo app('translator')->get('translation.cm'); ?></label>
                            <?php echo e(Form::text('length', $row->length ?? old('length'), ['class'=>'form-control','id'=>'length','placeholder'=> __('translation.length_placeholder')])); ?>

                            <?php $__errorArgs = ['length'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error text-danger"> <?php echo e($message); ?> </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="manufacturer-name-input"><?php echo app('translator')->get('translation.width'); ?> <?php echo app('translator')->get('translation.cm'); ?></label>
                            <?php echo e(Form::text('width', $row->width ?? old('width'), ['class'=>'form-control','id'=>'width','placeholder'=> __('translation.width_placeholder')])); ?>

                            <?php $__errorArgs = ['width'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error text-danger"> <?php echo e($message); ?> </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="manufacturer-name-input"><?php echo app('translator')->get('translation.height'); ?> <?php echo app('translator')->get('translation.cm'); ?></label>
                            <?php echo e(Form::text('height', $row->height ?? old('height'), ['class'=>'form-control','id'=>'height','placeholder'=> __('translation.height_placeholder')])); ?>

                            <?php $__errorArgs = ['height'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error text-danger"> <?php echo e($message); ?> </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <!-- end col -->
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->

        <!-- end card -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><?php echo app('translator')->get('translation.accessable'); ?></h5>
            </div>
            <div class="card-body">
                <div>
                    <label for="choices-publish-visibility-input" class="form-label"><?php echo app('translator')->get('translation.is_active'); ?></label>

                    <?php echo e(Form::select('is_visible', ['0' => __('translation.hidden'), '1' => __('translation.visible')], null, ['class'=>'form-select','id'=>'choices-publish-visibility-input','data-choices' ])); ?>

                    <?php $__errorArgs = ['is_visible'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="error text-danger"> <?php echo e($message); ?> </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><?php echo app('translator')->get('translation.pricing'); ?></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="product-price-input"><?php echo app('translator')->get('translation.price'); ?> <?php echo app('translator')->get('translation.sar'); ?><span class="required" >*</span></label>
                            <div class="input-group has-validation mb-3">
                                <span class="input-group-text" id="product-price-addon"><?php echo app('translator')->get('translation.sar'); ?></span>
                                <input type="number" step=".01" min="0"  name="price" id="price" value="<?php echo e($row->price_in_sar ?? old('price')); ?>" placeholder="<?php echo e(trans('translation.price_placeholder')); ?>" class="form-control">
                                <div class="invalid-feedback"><?php echo app('translator')->get('translation.price_placeholder'); ?></div>
                            </div>
                            <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error text-danger"> <?php echo e($message); ?> </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="product-price-input"><?php echo app('translator')->get('translation.price_before_offer'); ?> <?php echo app('translator')->get('translation.sar'); ?></label>
                            <div class="input-group has-validation mb-3">
                                <span class="input-group-text" id="product-price-addon"><?php echo app('translator')->get('translation.sar'); ?></span>
                                <input type="number" step=".01" min="0"  name="price_before_offer" id="price_before_offer" value="<?php echo e($row->price_before_offer_in_sar ?? old('price_before_offer')); ?>" placeholder="<?php echo e(trans('translation.price_before_offer_placeholder')); ?>" class="form-control">
                                <div class="invalid-feedback"><?php echo app('translator')->get('translation.price_before_offer_placeholder'); ?></div>
                            </div>
                            <?php $__errorArgs = ['price_before_offer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error text-danger"> <?php echo e($message); ?> </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    
                </div>
            </div>
            <!-- end card body -->
        </div>



        <div class="card ">
            <div class="card-header">
                <h5 class="card-title mb-0"><?php echo app('translator')->get('translation.quantity'); ?></h5>
            </div>
            <div class="card-body">
                <div>
                    <label for="main-choices-input-type_id" class="form-label"><?php echo app('translator')->get('translation.type'); ?></label>
                    <?php echo e(Form::select('type_id', $types, $row->type_id ?? old('type_id'), ['class'=>'form-select','id'=>'main-choices-input-type_id', 'placeholder'=>__('translation.type_placeholder'),'data-choices','data-choices-search-true',])); ?>

                    <?php $__errorArgs = ['type_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="error text-danger"> <?php echo e($message); ?> </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3" style="margin-top: 10px;">
                    <label for="choices-publish-status-input" class="form-label"><?php echo app('translator')->get('translation.quantity_type'); ?><span class="required" >*</span></label>
                    <?php echo e(Form::select('quantity_type_id', $quantity_types, $row->quantity_type_id ?? old('quantity_type_id'), ['class'=>'form-select','id'=>'main-choices-input-quantity-type_id', 'placeholder'=>__('translation.quantity_type_placeholder'),'data-choices','data-choices-search-true',])); ?>

                    <?php $__errorArgs = ['quantity_type_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="error text-danger"> <?php echo e($message); ?> </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="row" style="margin-top:20px">
                    <div class="col-lg-6 col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="product-price-input"><?php echo app('translator')->get('translation.quantity_bill_count'); ?></label>
                            <div class="input-group has-validation mb-3">
                                <?php echo e(Form::number('quantity_bill_count', $row->quantity_bill_count ?? old('quantity_bill_count'), ['class'=>'form-control','id'=>'quantity-bill-counts-input','placeholder'=> __('translation.product_quantity_bill_count_sort_placeholder'),'aria-label'=>'Price','aria-describedby'=>'product-quantity-bill-count-addon',])); ?>

                                <div class="invalid-feedback"><?php echo app('translator')->get('translation.quantity_bill_count_placeholder'); ?></div>
                            </div>
                            <?php $__errorArgs = ['quantity_bill_count'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error text-danger"> <?php echo e($message); ?> </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="product-price-input"><?php echo app('translator')->get('translation.bill_weight'); ?> <?php echo app('translator')->get('translation.gram'); ?></label>
                            <div class="input-group has-validation mb-3">
                                <?php echo e(Form::number('bill_weight', $row->bill_weight ?? old('bill_weight'), ['class'=>'form-control','id'=>'quantity-bill-counts-input','placeholder'=> __('translation.bill_weight_placeholder'),'aria-label'=>'Price','aria-describedby'=>'product-quantity-bill-count-addon',])); ?>

                                <div class="invalid-feedback"><?php echo app('translator')->get('translation.bill_weight_placeholder'); ?></div>
                            </div>
                            <?php $__errorArgs = ['bill_weight'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error text-danger"> <?php echo e($message); ?> </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
        
    </div>
</div>
<!-- end row -->

<?php $__env->startSection('script-bottom'); ?>
<!--select2 cdn-->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="<?php echo e(URL::asset('assets/js/pages/select2.init.js')); ?>"></script>
    <script>

        $(document).ready(function() {
            $("#form-loader").hide()
        })

        function getSubCategories(ele,level)
        {
            if (!ele.val()) return
            $.get('/vendor/get-category-by-parent-id?parent_id='+ele.val()+'&level='+level,(response)=>{
                data = Object.entries(response)
                select_options = '';
                data.forEach(value => select_options += `<option ${value[0] == '' ? 'selected' : ''} value="${value[0]}"> ${value[1]} </option>`)

                if (level===2) {
                    $('#sub-choices-publish-status-input').html(select_options)
                    $('#sub-choices-publish-status-input').select2();
                }
                if (level===3) {
                    $('#final-choices-publish-status-input').html(select_options)
                    $('#final-choices-publish-status-input').select2();
                }
                $("#form-loader").hide()
            })
        }

        $("#price").on('change', function(){   // 1st
            if(!isDecimalNumber($(this).val()) || typeof $(this).val() == undefined) {
                var price = $(this).val()
                $(this).val(parseFloat(price).toFixed(2))
            }
        });

        $("#price_before_offer").on('change', function(){   // 1st
            if(!isDecimalNumber($(this).val()) || typeof $(this).val() == undefined) {
                var price_before_offer = $(this).val()
                $(this).val(parseFloat(price_before_offer).toFixed(2))
            }
        });

        // Check if the given number is decimal or not.
        function isDecimalNumber(number)
        {
            return number % 1 != 0 ?? true;
        }
    </script>
<?php $__env->stopSection(); ?>
<?php /**PATH /Users/abdo/Sites/localhost/saudi-dates/resources/views/vendor/products/form.blade.php ENDPATH**/ ?>