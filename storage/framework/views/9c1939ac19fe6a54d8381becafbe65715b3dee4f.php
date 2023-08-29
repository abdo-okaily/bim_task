
<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get("admin.products.title"); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('assets/libs/swiper/swiper.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php if(session()->has('success')): ?>
        <div class="alert alert-success">
            <h3> <?php echo e(session('success')); ?> </h3>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row gx-lg-5">
                        <div class="col-xl-4 col-md-8 mx-auto">
                            <div class="product-img-slider sticky-side-div">
                                <div class="swiper product-thumbnail-slider p-2 rounded bg-light">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <img src="<?php echo e(URL::asset($row->square_image)); ?>" alt="" class="img-fluid d-block" />
                                        </div>
                                        <?php $__currentLoopData = $row->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="swiper-slide">
                                                <img src="<?php echo e(URL::asset($image->square_image)); ?>" alt="" class="img-fluid d-block" />
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </div>
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                </div>
                                <!-- end swiper thumbnail slide -->
                                <div class="swiper product-nav-slider mt-2">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="nav-slide-item ">
                                                <img src="<?php echo e(URL::asset($row->square_image)); ?>" alt=""
                                                     class="img-fluid d-block" />
                                            </div>
                                        </div>

                                        <?php $__currentLoopData = $row->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="swiper-slide">
                                                <div class="nav-slide-item ">
                                                    <img src="<?php echo e(URL::asset($image->square_image)); ?>" alt=""
                                                         class="img-fluid d-block" />
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                                <!-- end swiper nav slide -->
                            </div>
                        </div>
                        <!-- end col -->

                        <div class="col-xl-8">
                            <div class="mt-xl-0 mt-5">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <div class="hstack gap-3 flex-wrap">
                                            <div><a href="#" class="text-primary d-block"><?php echo e($row->vendor?->name); ?></a></div>
                                            <div class="vr"></div>
                                            <div class="text-muted"><?php echo app('translator')->get('translation.seller'); ?> :
                                                <span class="text-body fw-medium">
                                                    <?php echo e($row->vendor?->owner?->name); ?>

                                                </span>
                                            </div>
                                            <div class="vr"></div>
                                            <div class="text-muted"><?php echo app('translator')->get('translation.published_date'); ?> : <span class="text-body fw-medium"><?php echo e($row->created_at?->toFormattedDateString()); ?></span>
                                            </div>
                                            <div class="vr"></div>
                                            <div class="text-muted">
                                                <?php echo app('translator')->get('admin.products.is_active'); ?> :
                                                <?php if( $row?->status == 'accepted'): ?>
                                                    <span class="badge badge-soft-success text-uppercase">
                                                        <?php echo app('translator')->get('admin.products.yes'); ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-soft-danger text-uppercase">
                                                        <?php echo app('translator')->get("admin.products.{$row->status}"); ?>
                                                    </span>
                                                <?php endif; ?>    
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div class="d-flex align-items-center gap-2">
                                            <?php if($row->temp): ?>
                                           <!--  <a href="#" class="btn btn-warning"
                                               data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                               <?php echo app('translator')->get('admin.products.follow_edits'); ?>
                                            </a> -->
                                            <!-- Scrollable modal -->
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModalScrollable"><?php echo app('translator')->get('admin.products.follow_edits'); ?></button>

                                            <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalScrollableTitle"><?php echo app('translator')->get('admin.edits_history'); ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- <h6 class="fs-15"><?php echo app('translator')->get('admin.edits_history'); ?></h6> -->
                                                            <div class="live-preview">
                                                                <?php echo $__env->make('admin.products.updates_accordion', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" onclick="showRejectNote($(this))" ><?php echo app('translator')->get('admin.products.reject'); ?> <i class="ri-indeterminate-circle-fill"></i></button>
                                                            <form action="<?php echo e(route('admin.products.accept-update', ['product' => $row])); ?>" method="POST">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('put'); ?>
                                                                <button class="btn btn-success" title="<?php echo app('translator')->get('admin.products.accepting'); ?>"><?php echo app('translator')->get('admin.products.accept_update'); ?>
                                                                    <i class="ri-check-double-fill align-bottom"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                            <?php endif; ?>
                                            <a href="<?php echo e(route('admin.products.print-barcode', ['product' => $row])); ?>" class="btn btn-info"
                                               data-bs-toggle="tooltip" target="_blank" data-bs-placement="top" title="<?php echo app('translator')->get('admin.products.print-barcode'); ?>">
                                               <i class="ri-download-fill align-bottom"></i> <?php echo app('translator')->get('admin.products.print-barcode'); ?>
                                            </a>
                                            <a href="<?php echo e(route('admin.products.edit', ['product' => $row])); ?>" class="btn btn-light"
                                               data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                               <i class="ri-pencil-fill align-bottom"></i>
                                            </a>
                                            <form action="<?php echo e(route('admin.products.toggle-status', ['product' => $row])); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('put'); ?>
                                                <?php if($row->status != 'accepted'): ?>
                                                    <button class="btn btn-success" title="<?php echo app('translator')->get('admin.products.accepting'); ?>">
                                                        <i class="ri-check-double-fill align-bottom"></i>
                                                    </button>
                                                <?php else: ?>
                                                    <button class="btn btn-danger" title="<?php echo app('translator')->get('admin.products.re-pending'); ?>">
                                                        <i class="ri-forbid-fill align-bottom"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between mt-3">
                                    <?php if($row->reviews->isNotEmpty()): ?>
                                        <div class="text-muted fs-16">
                                            <?php for($i=0 ;$i < $row->reviews()->avg('rate') ; $i++): ?>
                                                <span class="mdi mdi-star text-warning"></span>
                                            <?php endfor; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="text-muted">( <?php echo e($row->reviews()->count()); ?> <?php echo app('translator')->get('translation.customers_rating'); ?> )</div>
                                    <div class="text-muted"><?php echo app('translator')->get('admin.products.barcode'); ?>: <?php echo e($row->sku); ?> </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="p-2 border border-dashed rounded">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-2">
                                                    <div class="avatar-title rounded bg-transparent text-primary fs-24">
                                                        <i class="ri-money-dollar-circle-fill"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <p class="text-muted mb-1"><?php echo app('translator')->get('translation.price'); ?> :</p>
                                                    <h5 class="mb-0"><?php echo e(number_format($row->price_in_sar, 2)); ?> <?php echo app('translator')->get('translation.sar'); ?></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="p-2 border border-dashed rounded">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-2">
                                                    <div class="avatar-title rounded bg-transparent text-primary fs-24">
                                                        <i class="ri-file-copy-2-fill"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <p class="text-muted mb-1"><?php echo app('translator')->get('translation.no_orders'); ?> :</p>
                                                    <h5 class="mb-0"><?php echo e($row->orderProducts->count()); ?></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="p-2 border border-dashed rounded">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-2">
                                                    <div class="avatar-title rounded bg-transparent text-primary fs-24">
                                                        <i class="ri-stack-fill"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <p class="text-muted mb-1"><?php echo app('translator')->get('translation.available_stock'); ?> :</p>
                                                    <h5 class="mb-0">
                                                        <?php if($row->stock): ?>
                                                            <?php echo e($row->stock); ?>

                                                        <?php else: ?>
                                                            <?php echo app('translator')->get("vendors.empty"); ?>
                                                        <?php endif; ?>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="p-2 border border-dashed rounded">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-2">
                                                    <div class="avatar-title rounded bg-transparent text-primary fs-24">
                                                        <i class="ri-inbox-archive-fill"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <p class="text-muted mb-1"><?php echo app('translator')->get('translation.total_revenue'); ?> :</p>
                                                    <h5 class="mb-0"><?php echo e($row->orderProducts->sum('totalInSar')); ?> <?php echo app('translator')->get('translation.sar'); ?></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                </div>

                                

                                <div class="mt-4 text-muted">
                                    <h5>
                                        <?php echo e($row->getTranslation('name', 'ar')); ?> <?php echo app('translator')->get('translation.arabic'); ?>
                                    </h5>
                                </div>
                                <div class="mt-4 text-muted">
                                    <h5>
                                        <?php echo e($row->getTranslation('name', 'en')); ?> <?php echo app('translator')->get('translation.english'); ?>
                                    </h5>
                                </div>
                                <div class="mt-4 text-muted">
                                    <h5 class="fs-14"><?php echo app('translator')->get('translation.product_desc'); ?> <?php echo app('translator')->get('translation.english'); ?> :</h5>
                                    <?php echo $row->getTranslation('desc', 'en'); ?>

                                </div>

                                <div class="mt-4 text-muted">
                                    <h5 class="fs-14"><?php echo app('translator')->get('translation.product_desc'); ?> <?php echo app('translator')->get('translation.arabic'); ?> :</h5>
                                    <?php echo $row->getTranslation('desc', 'ar'); ?>

                                </div>

                                <div class="product-content mt-5">
                                    <nav>
                                        <ul class="nav nav-tabs nav-tabs-custom nav-primary" id="nav-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="nav-speci-tab" data-bs-toggle="tab"
                                                   href="#nav-speci" role="tab" aria-controls="nav-speci"
                                                   aria-selected="true"><?php echo app('translator')->get('translation.product_details'); ?> :</a>
                                            </li>
                                            <!-- <li class="nav-item">
                                                <a class="nav-link" id="nav-detail-tab" data-bs-toggle="tab"
                                                    href="#nav-detail" role="tab" aria-controls="nav-detail"
                                                    aria-selected="false"><?php echo app('translator')->get('translation.sizes'); ?></a>
                                            </li> -->
                                        </ul>
                                    </nav>
                                    <div class="tab-content border border-top-0 p-4" id="nav-tabContent" style="height:328px">
                                        <div class="tab-pane fade show active" id="nav-speci" role="tabpanel"
                                             aria-labelledby="nav-speci-tab">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                            <tbody>
                                                            <tr>
                                                                <th scope="row" style="width: 200px;">
                                                                    <?php echo app('translator')->get('translation.categroy'); ?></th>
                                                                <td><?php echo e($row->category?->name); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row" style="width: 200px;">
                                                                    <?php echo app('translator')->get('translation.final_category'); ?></th>
                                                                <td><?php echo e($row->finalSubCategory?->name); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row"><?php echo app('translator')->get('translation.quantity'); ?></th>
                                                                <td><?php echo e($row->quantity_type?->name); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row"><?php echo app('translator')->get('translation.type'); ?></th>
                                                                <td><?php echo e($row->type?->name); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row"><?php echo app('translator')->get('translation.quantity_bill_count'); ?></th>
                                                                <td><?php echo e($row->quantity_bill_count); ?> <?php echo e($row->quantity_type?->name); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row"><?php echo app('translator')->get('translation.bill_weight'); ?></th>
                                                                <td><?php echo e($row->bill_weight); ?>  <?php echo e($row->quantity_type?->name); ?></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                            <tbody>
                                                            <tr>
                                                                <th scope="row" style="width: 200px;">
                                                                    <?php echo app('translator')->get('translation.sub_category'); ?></th>
                                                                <td><?php echo e($row->subCategory?->name); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row" style="width: 200px;">
                                                                    <?php echo app('translator')->get('translation.total_weight'); ?></th>
                                                                <td><?php echo e($row->total_weight); ?> <?php echo app('translator')->get('translation.gram'); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row"><?php echo app('translator')->get('translation.net_weight'); ?></th>
                                                                <td><?php echo e($row->net_weight); ?> <?php echo app('translator')->get('translation.gram'); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row"><?php echo app('translator')->get('translation.length'); ?> </th>
                                                                <td><?php echo e($row->length); ?> <?php echo app('translator')->get('translation.cm'); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row"><?php echo app('translator')->get('translation.width'); ?></th>
                                                                <td><?php echo e($row->width); ?> <?php echo app('translator')->get('translation.cm'); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row"><?php echo app('translator')->get('translation.height'); ?></th>
                                                                <td><?php echo e($row->height); ?> <?php echo app('translator')->get('translation.cm'); ?></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="nav-detail" role="tabpanel"
                                                 aria-labelledby="nav-detail-tab">
                                                <div class="table-responsive">
                                                    <table class="table mb-0">
                                                        <tbody>
                                                        <tr>
                                                            <th scope="row" style="width: 200px;">
                                                                <?php echo app('translator')->get('translation.total_weight'); ?></th>
                                                            <td><?php echo e($row->total_weight); ?> <?php echo app('translator')->get('translation.gram'); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row"><?php echo app('translator')->get('translation.net_weight'); ?></th>
                                                            <td><?php echo e($row->net_weight); ?> <?php echo app('translator')->get('translation.gram'); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row"><?php echo app('translator')->get('translation.length'); ?> </th>
                                                            <td><?php echo e($row->length); ?> <?php echo app('translator')->get('translation.cm'); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row"><?php echo app('translator')->get('translation.width'); ?></th>
                                                            <td><?php echo e($row->width); ?> <?php echo app('translator')->get('translation.cm'); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row"><?php echo app('translator')->get('translation.height'); ?></th>
                                                            <td><?php echo e($row->height); ?> <?php echo app('translator')->get('translation.cm'); ?></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- product-content -->

                                    <div class="mt-5">
                                        <div>
                                            <h5 class="fs-14 mb-3"><?php echo app('translator')->get('translation.ratings_and_Reviews'); ?></h5>
                                        </div>
                                        <div class="row gy-4 gx-0">
                                            <div class="col-lg-4">
                                                <div>
                                                    <div class="pb-3">
                                                        <div class="bg-light px-3 py-2 rounded-2 mb-2">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-grow-1">
                                                                    <div class="fs-16 align-middle text-warning">
                                                                        <?php for($i=0 ;$i < $row->reviews()->avg('rate') ; $i++): ?>
                                                                            <i class="ri-star-fill"></i>
                                                                        <?php endfor; ?>

                                                                    </div>
                                                                </div>
                                                                <div class="flex-shrink-0">
                                                                    <h6 class="mb-0"><?php echo e(round( $row->reviews()->avg('rate'),1 )); ?> <?php echo app('translator')->get('translation.out_of'); ?> 5</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-center">
                                                            <div class="text-muted"><?php echo app('translator')->get('translation.total'); ?> <span
                                                                    class="fw-medium"><?php echo e($reviews_count=$row->reviews()->count()); ?></span><?php echo app('translator')->get('translation.reviews'); ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mt-3">
                                                        <div class="row align-items-center g-2">
                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0">5 <?php echo app('translator')->get('translation.stars'); ?></h6>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="p-2">
                                                                    <div class="progress animated-progress progress-sm">
                                                                        <div class="progress-bar bg-primary" role="progressbar"
                                                                             style="width: <?php echo e($row->reviews()->where('rate',5)->count()/$row->reviews_count*100); ?>%" aria-valuenow="50.16"
                                                                             aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0 text-muted"><?php echo e($row->reviews()->where('rate',5)->count()); ?></h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end row -->

                                                        <div class="row align-items-center g-2">
                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0">4 <?php echo app('translator')->get('translation.stars'); ?></h6>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="p-2">
                                                                    <div class="progress animated-progress progress-sm">
                                                                        <div class="progress-bar bg-success" role="progressbar"
                                                                             style="width: <?php echo e($row->reviews()->where('rate',4)->count()/$row->reviews_count*100); ?>%" aria-valuenow="19.32"
                                                                             aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0 text-muted"><?php echo e($row->reviews()->where('rate',4)->count()); ?></h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end row -->

                                                        <div class="row align-items-center g-2">
                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0">3 <?php echo app('translator')->get('translation.stars'); ?></h6>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="p-2">
                                                                    <div class="progress animated-progress progress-sm">
                                                                        <div class="progress-bar bg-secondary"
                                                                             role="progressbar" style="width: <?php echo e($row->reviews()->where('rate',3)->count()/$row->reviews_count*100); ?>%"
                                                                             aria-valuenow="18.12" aria-valuemin="0"
                                                                             aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0 text-muted"><?php echo e($row->reviews()->where('rate',3)->count()); ?></h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end row -->

                                                        <div class="row align-items-center g-2">
                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0">2 <?php echo app('translator')->get('translation.stars'); ?></h6>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="p-2">
                                                                    <div class="progress animated-progress progress-sm">
                                                                        <div class="progress-bar bg-warning" role="progressbar"
                                                                             style="width: <?php echo e($row->reviews()->where('rate',2)->count()/$row->reviews_count*100); ?>%" aria-valuenow="7.42"
                                                                             aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0 text-muted"><?php echo e($row->reviews()->where('rate',2)->count()); ?></h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end row -->

                                                        <div class="row align-items-center g-2">
                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0">1 <?php echo app('translator')->get('translation.star'); ?></h6>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="p-2">
                                                                    <div class="progress animated-progress progress-sm">
                                                                        <div class="progress-bar bg-danger" role="progressbar"
                                                                             style="width: <?php echo e($row->reviews()->where('rate',1)->count()/$row->reviews_count*100); ?>%" aria-valuenow="4.98"
                                                                             aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0 text-muted"><?php echo e($row->reviews()->where('rate',1)->count()); ?></h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end row -->
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end col -->

                                            <div class="col-lg-8">
                                                <div class="ps-lg-4">
                                                    <div class="d-flex flex-wrap align-items-start gap-3">
                                                        <h5 class="fs-14"><?php echo app('translator')->get('translation.reviews'); ?>: </h5>
                                                    </div>

                                                    <div class="me-lg-n3 pe-lg-4" data-simplebar style="max-height: 225px;">
                                                        <ul class="list-unstyled mb-0">
                                                            <?php $__currentLoopData = $row->reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <li class="py-2">
                                                                    <div class="border border-dashed rounded p-3">
                                                                        <div class="d-flex align-items-start mb-3">
                                                                            <div class="hstack gap-3">
                                                                                <div class="badge rounded-pill bg-primary mb-0">
                                                                                    <i class="mdi mdi-star"></i>
                                                                                    <?php echo e($review->rate); ?>

                                                                                </div>
                                                                                <div class="vr"></div>
                                                                                <div class="flex-grow-1">
                                                                                    <p class="text-muted mb-0">
                                                                                        <?php echo e($review->comment); ?>

                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="d-flex flex-grow-1 gap-2 mb-3">
                                                                            <a href="#" class="d-block">
                                                                                <img src="<?php echo e(URL::asset($review->user->image)); ?>" alt=""
                                                                                     class="avatar-sm rounded object-cover">
                                                                            </a>
                                                                            <!-- <a href="#" class="d-block">
                                                                        <img src="<?php echo e(URL::asset('assets/images/small/img-11.jpg')); ?>" alt=""
                                                                            class="avatar-sm rounded object-cover">
                                                                    </a>
                                                                    <a href="#" class="d-block">
                                                                        <img src="<?php echo e(URL::asset('assets/images/small/img-10.jpg')); ?>" alt=""
                                                                            class="avatar-sm rounded object-cover">
                                                                    </a> -->
                                                                        </div>

                                                                        <div class="d-flex align-items-end">
                                                                            <div class="flex-grow-1">
                                                                                <h5 class="fs-14 mb-0"><?php echo e($review->user->name); ?>

                                                                                </h5>
                                                                            </div>

                                                                            <div class="flex-shrink-0">
                                                                                <p class="text-muted fs-13 mb-0">
                                                                                    <?php echo e($review->created_at->toFormattedDateString()); ?></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end col -->
                                        </div>
                                        <!-- end Ratings & Reviews -->
                                    </div>
                                    <!-- end card body -->
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
        </div>
    </div>
    <!-- Varying modal content -->
    <div class="modal fade" id="varyingcontentModal" tabindex="-1" aria-labelledby="varyingcontentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="varyingcontentModalLabel"><?php echo app('translator')->get('admin.products.reject_reason'); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(route('admin.products.refuse-update', ['product' => $row])); ?>" method="POST">
                    <div class="modal-body">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('put'); ?>
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label"><?php echo app('translator')->get('admin.products.write_your_reject_reason'); ?>: <span style="color:red" >*</span></label>
                                <textarea class="form-control" id="message-text" rows="4" name="note"></textarea>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger"><?php echo app('translator')->get('admin.products.reject_confirm'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="<?php echo e(URL::asset('assets/libs/swiper/swiper.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/js/pages/ecommerce-product-details.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

    <script>
        function showRejectNote(ele)
        {
            $('#exampleModalScrollable').modal('toggle');
            $('#varyingcontentModal').modal('toggle');
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/abdo/Sites/localhost/saudi-dates/resources/views/admin/products/show.blade.php ENDPATH**/ ?>