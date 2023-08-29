
<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('admin.products.manage_products'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet" type="text/css"/>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('sweetalert::alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="products">
                <?php if(session()->has('success')): ?>
                    <div class="alert alert-success alert-borderless" role="alert">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1"><?php echo app('translator')->get('admin.products.manage_products'); ?></h5>
                        <div class="flex-shrink-0">
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="<?php echo e(route("vendor.products.create")); ?>" class="btn btn-primary add-btn"
                                   id="create-btn">
                                    <i class="ri-add-line align-bottom me-1"></i> <?php echo app('translator')->get("admin.products.create"); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <div class="row g-3">
                            <div class="col-xxl-5 col-sm-6">
                                <div class="search-box">
                                    <input type="text" class="form-control search" 
                                           placeholder="<?php echo app('translator')->get("admin.products.search"); ?>" name="search" value="<?php echo e($request->search); ?>">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-2 col-sm-6">
                                <div>
                                    <input type="text" class="form-control" data-provider="flatpickr"
                                           data-date-format="d M, Y" data-range-date="true" name="created_date" id="demo-datepicker"
                                           placeholder="<?php echo app('translator')->get("admin.products.created_at_select"); ?>" value="<?php echo e($request->created_date); ?>">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-control" data-choices data-choices-search-false
                                            name="is_active" id="is_active">
                                        <option value="all" selected><?php echo app('translator')->get("admin.products.all"); ?></option>
                                        <option value="1"><?php echo app('translator')->get("admin.products.active"); ?></option>
                                        <option value="0"><?php echo app('translator')->get("admin.products.inactive"); ?></option>
                                    </select>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-control" data-choices data-choices-search-false
                                            name="type" id="is_temp">
                                        <option value="all" selected><?php echo app('translator')->get("admin.products.all"); ?></option>
                                        <option value="temp"><?php echo app('translator')->get("admin.products.updated_products"); ?></option>
                                        <option value="pending"><?php echo app('translator')->get("admin.products.pending_products"); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="submit" class="btn btn-secondary w-100" onclick="SearchData();"><i
                                            class="ri-equalizer-fill me-1 align-bottom"></i>
                                        <?php echo app('translator')->get("admin.products.filter"); ?>
                                    </button>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <div class="card-body pt-0">
                    <div>
                        <br>
                        <br>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="productsTable">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th><?php echo app('translator')->get('admin.products.id'); ?></th>
                                    <th><?php echo app('translator')->get('translation.product_image'); ?></th>
                                    <th><?php echo app('translator')->get('admin.products.name_ar'); ?></th>
                                    <th><?php echo app('translator')->get('admin.products.name_en'); ?></th>
                                    <th><?php echo app('translator')->get('admin.products.category'); ?></th>
                                    <th><?php echo app('translator')->get('admin.products.vendor'); ?></th>
                                    <th><?php echo app('translator')->get('admin.products.price'); ?></th>
                                    <th><?php echo app('translator')->get('translation.visible'); ?></th>
                                    <th><?php echo app('translator')->get('admin.products.is_active'); ?></th>
                                    <th><?php echo app('translator')->get('translation.actions'); ?></th>

                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    <?php if($products->count() > 0): ?>
                                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="id">
                                                    <a href="<?php echo e(route("vendor.products.show", $product->id)); ?>"
                                                    class="fw-medium link-primary">
                                                        #<?php echo e($product->id); ?>

                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-3">
                                                            <div class="avatar-sm bg-light rounded p-1"><img src="<?php echo e(url($product->image)); ?>" alt="" class="img-fluid d-block">
                                                            </div>
                                                        </div>
                                                    <div class="flex-grow-1">
                                                    <!-- <h5 class="fs-14 mb-1"><a href="#" class="text-dark"><?php echo e($product->getTranslation('name','ar')); ?></a></h5><p class="text-muted mb-0"> <span class="fw-medium"><?php echo e($product?->category?->name); ?></span></p> </div>
                                                    </div> -->
                                                </td>
                                                <td class="name_ar"><?php echo e($product->getTranslation('name', 'ar')); ?></td>
                                                <td class="name_en"><?php echo e($product->getTranslation('name', 'en')); ?></td>
                                                <td class="category"><?php echo e($product?->category?->name); ?></td>
                                                <td class="vendor"><?php echo e($product?->vendor?->name); ?></td>
                                                <td class="price"><?php echo e(number_format($product?->price_in_sar, 2)); ?> <?php echo app('translator')->get('translation.sar'); ?></td>
                                                <td class="is_active"><?php if( $product?->is_visible == 1): ?> <span class="badge badge-soft-success text-uppercase"><?php echo app('translator')->get('admin.products.yes'); ?></span> <?php else: ?> <span class="badge badge-soft-danger text-uppercase"> <?php echo app('translator')->get('admin.products.no'); ?> </span>   <?php endif; ?> </td>
                                                <td class="status"><?php if( $product?->status == 'accepted'): ?> <span class="badge badge-soft-success text-uppercase"> <?php echo app('translator')->get('admin.products.yes'); ?> </span> <?php else: ?> <span class="badge badge-soft-danger text-uppercase"><?php echo app('translator')->get("admin.products.{$product->status}"); ?> </span>  <?php endif; ?> </td>
                                                <td>
                                                    <ul class="list-inline hstack gap-2 mb-0">
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="<?php echo app('translator')->get('admin.products.show'); ?>">
                                                            <a href="<?php echo e(route("vendor.products.show", $product->id)); ?>"
                                                            class="text-primary d-inline-block">
                                                                <i class="ri-eye-fill fs-16"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="<?php echo app('translator')->get('admin.products.edit'); ?>">
                                                            <a href="<?php echo e(route("vendor.products.edit", $product->id)); ?>"
                                                            class="text-primary d-inline-block">
                                                                <i class="ri-edit-2-line"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="<?php echo app('translator')->get('admin.products.delete'); ?>">
                                                            <a class="text-danger d-inline-block remove-item-btn"
                                                            data-bs-toggle="modal" href="#deleteProduct-<?php echo e($product->id); ?>">
                                                                <i class="ri-delete-bin-5-fill fs-16"></i>
                                                            </a>
                                                            <!-- Start Delete Modal -->
                                                            <div class="modal fade flip" id="deleteProduct-<?php echo e($product->id); ?>" tabindex="-1" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-body p-5 text-center">
                                                                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                                                                    colors="primary:#25a0e2,secondary:#00bd9d"
                                                                                    style="width:90px;height:90px">
                                                                            </lord-icon>
                                                                            <div class="mt-4 text-center">
                                                                                <h4><?php echo app('translator')->get('admin.products.delete_modal.title'); ?></h4>
                                                                                <p class="text-muted fs-15 mb-4"><?php echo app('translator')->get('admin.products.delete_modal.description'); ?></p>
                                                                                <div class="hstack gap-2 justify-content-center remove">
                                                                                    <button class="btn btn-link link-primary fw-medium text-decoration-none"
                                                                                            data-bs-dismiss="modal" id="deleteRecord-close">
                                                                                        <i class="ri-close-line me-1 align-middle"></i>
                                                                                        <?php echo app('translator')->get('admin.close'); ?>
                                                                                    </button>
                                                                                    <form action="<?php echo e(route("vendor.products.destroy", $product->id)); ?>" method="post">
                                                                                        <?php echo csrf_field(); ?>
                                                                                        <?php echo method_field("DELETE"); ?>
                                                                                        <button type="submit" class="btn btn-primary" id="delete-record">
                                                                                            <?php echo app('translator')->get('admin.products.delete'); ?>
                                                                                        </button>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- End Delete Modal -->
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                               colors="primary:#25a0e2,secondary:#0ab39c"
                                               style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2"><?php echo app('translator')->get('admin.products.no_result_found'); ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                <?php echo e($products->appends(request()->query())->links("pagination::bootstrap-4")); ?>

                            </div>
                        </div>
                    </div>
                    <!-- Start Delete Modal -->
                    <div class="modal fade flip" id="deleteProduct" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body p-5 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                               colors="primary:#25a0e2,secondary:#00bd9d"
                                               style="width:90px;height:90px">
                                    </lord-icon>
                                    <div class="mt-4 text-center">
                                        <h4><?php echo app('translator')->get('admin.products.delete_modal.title'); ?></h4>
                                        <p class="text-muted fs-15 mb-4"><?php echo app('translator')->get('admin.products.delete_modal.description'); ?></p>
                                        <div class="hstack gap-2 justify-content-center remove">
                                            <button class="btn btn-link link-primary fw-medium text-decoration-none"
                                                    data-bs-dismiss="modal" id="deleteRecord-close"><i
                                                    class="ri-close-line me-1 align-middle"></i>
                                                Close
                                            </button>
                                            <button class="btn btn-primary" id="delete-record">Yes,
                                                Delete It
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Delete Modal -->
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('assets/libs/list.js/list.js.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/libs/list.pagination.js/list.pagination.js.min.js')); ?>"></script>

    <!--ecommerce-customer init js -->
    <script src="<?php echo e(URL::asset('assets/js/pages/ecommerce-order.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')); ?>"></script>

    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('vendor.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/abdo/Sites/localhost/saudi-dates/resources/views/vendor/products/index.blade.php ENDPATH**/ ?>