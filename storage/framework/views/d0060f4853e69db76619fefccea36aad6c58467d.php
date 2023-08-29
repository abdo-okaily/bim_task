
<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('admin.vendors_list'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1"><?php echo app('translator')->get('admin.vendors_list'); ?></h5>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form method="get" action="<?php echo e(URL::asset('/admin')); ?>/vendors/">
                        <!-- Col Form Label Default -->
                        <div class="row g-3">
                            <div class="col-xxl-3 col-sm-4">
                                <div class="search-box">
                                    <input value="<?php echo e(request('name')); ?>" name="name" type="text" class="form-control search" placeholder="<?php echo app('translator')->get('admin.vendor_name'); ?>">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <select name="approval" class="form-control" data-choices data-choices-search-false name="choices-single-default" id="idApproval">
                                    <option <?php if(request('approval') == ''): ?> SELECTED <?php endif; ?> value=""><?php echo app('translator')->get('admin.vendor_status'); ?></option>
                                    <option <?php if(request('approval') == 'pending'): ?> SELECTED <?php endif; ?> value="pending"><?php echo app('translator')->get('admin.vendor_pending'); ?></option>
                                    <option <?php if(request('approval') == 'approved'): ?> SELECTED <?php endif; ?> value="approved"><?php echo app('translator')->get('admin.vendor_approved'); ?></option>
                                    <option <?php if(request('approval') == 'not_approved'): ?> SELECTED <?php endif; ?> value="not_approved"><?php echo app('translator')->get('admin.vendor_not_approved'); ?></option>
                                </select>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <select name="rating" class="form-control" data-choices data-choices-search-false name="choices-single-default" id="idRating">
                                    <option <?php if(request('rating') == ''): ?> SELECTED <?php endif; ?> value=""><?php echo app('translator')->get('admin.vendor_rate'); ?></option>
                                    <option <?php if(request('rating') == '1'): ?> SELECTED <?php endif; ?> value="1"><i class="fas fa-star <?php echo e((request('rating') >= 1) ? 'clr_yellow' : ''); ?>"></i></option>
                                    <option <?php if(request('rating') == '1'): ?> SELECTED <?php endif; ?> value="1"><i class="fas fa-star <?php echo e((request('rating') >= 1) ? 'clr_yellow' : ''); ?>"></i></option>
                                    <option <?php if(request('rating') == '2'): ?> SELECTED <?php endif; ?> value="2"><i class="fas fa-star <?php echo e((request('rating') >= 2) ? 'clr_yellow' : ''); ?>"></i></option>
                                    <option <?php if(request('rating') == '3'): ?> SELECTED <?php endif; ?> value="3"><i class="fas fa-star <?php echo e((request('rating') >= 3) ? 'clr_yellow' : ''); ?>"></i></option>
                                    <option <?php if(request('rating') == '4'): ?> SELECTED <?php endif; ?> value="4"><i class="fas fa-star <?php echo e((request('rating') >= 4) ? 'clr_yellow' : ''); ?>"></i></option>
                                    <option <?php if(request('rating') == '5'): ?> SELECTED <?php endif; ?> value="5"><i class="fas fa-star <?php echo e((request('rating') >= 5) ? 'clr_yellow' : ''); ?>"></i></option>
                                </select>
                            </div>
                            <div class="col-xxl-4 col-sm-4">
                                <select name="commission_sort" class="form-control" data-choices data-choices-search-false name="choices-single-default" id="idCommission">
                                    <option <?php if(request('commission_sort') == ''): ?> SELECTED <?php endif; ?> value=""><?php echo app('translator')->get('admin.vendor_admin_percentage_order'); ?></option>
                                    <option <?php if(request('commission_sort') == 'desc'): ?> SELECTED <?php endif; ?> value="desc"><?php echo app('translator')->get('admin.desc_order'); ?></option>
                                    <option <?php if(request('commission_sort') == 'asc'): ?> SELECTED <?php endif; ?> value="asc"><?php echo app('translator')->get('admin.asc_order'); ?></option>
                                </select>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="submit" class="btn btn-secondary w-100">
                                        <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col"><?php echo app('translator')->get('admin.vendor_name'); ?></th>
                            <th scope="col"><?php echo app('translator')->get('admin.vendor_products'); ?></th>
                            <th scope="col"><?php echo app('translator')->get('admin.vendor_rate'); ?></th>
                            <th scope="col"><?php echo app('translator')->get('admin.vendor_sales'); ?></th>
                            
                            <th scope="col"><?php echo app('translator')->get('admin.vendor_registration_date'); ?></th>
                            <th scope="col"><?php echo app('translator')->get('admin.vendor_warnings'); ?></th>
                            <th scope="col"><?php echo app('translator')->get('admin.vendor_admin_percentage'); ?></th>
                            <th scope="col"><?php echo app('translator')->get('admin.vendor_status'); ?></th>
                            <th scope="col"><?php echo app('translator')->get('admin.actions'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($vendor->id); ?></td>
                                <td>
                                    <img class="img-thumbnail" src="<?php echo e(URL::asset($vendor->logo)); ?>"
                                         style="height:40px;"> <?php echo e($vendor->name); ?>

                                </td>
                                <td align="center">
                                    <span class="badge badge-info"> <?php echo e($vendor->products->count()); ?></span>
                                </td>
                                <td style="width: 114px; !important">
                                    <div class="stars">
                                        <i class="fas fa-star <?php echo e(($vendor->avg_rating >= 1) ? 'clr_yellow' : ''); ?>"></i>
                                        <i class="fas fa-star <?php echo e(($vendor->avg_rating >= 2) ? 'clr_yellow' : ''); ?>"></i>
                                        <i class="fas fa-star <?php echo e(($vendor->avg_rating >= 3) ? 'clr_yellow' : ''); ?>"></i>
                                        <i class="fas fa-star <?php echo e(($vendor->avg_rating >= 4) ? 'clr_yellow' : ''); ?>"></i>
                                        <i class="fas fa-star <?php echo e(($vendor->avg_rating >= 5) ? 'clr_yellow' : ''); ?>"></i>
                                        (<?php echo e($vendor->ratings_count); ?>)
                                    </div>
                                </td>
                                <td align="center">
                                    <span class="badge badge-info"> <?php echo e($vendor->orders->count()); ?></span>
                                </td>
                                
                                <td><?php echo e(date('d-m-Y h:i', strtotime($vendor->created_at))); ?></td>
                                <td>
                                    <a href="<?php echo e(route('admin.vendors.warnings.index', ['vendor' => $vendor])); ?>"
                                       class="full-width">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30"
                                             height="30">
                                            <path fill="none" d="M0 0h24v24H0z"/>
                                            <path
                                                d="M12.866 3l9.526 16.5a1 1 0 0 1-.866 1.5H2.474a1 1 0 0 1-.866-1.5L11.134 3a1 1 0 0 1 1.732 0zm-8.66 16h15.588L12 5.5 4.206 19zM11 16h2v2h-2v-2zm0-7h2v5h-2V9z"
                                                fill="rgba(190,154,17,1)"/>
                                        </svg>
                                        (<?php echo e($vendor->VendorWarnings->count()); ?>)
                                    </a>
                                </td>
                                <td class="commission">% <?php echo e((int)$vendor->commission); ?></td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input onclick="vendorChangeStatus('<?php echo e($vendor->id); ?>',this)"
                                               class="form-check-input" type="checkbox" role="switch" id="SwitchCheck4"
                                               <?php if($vendor->is_active == 1): ?> value="1" checked=""
                                               <?php else: ?> value="0" <?php endif; ?> />
                                    </div>
                                </td>
                                <td>
                                    <div class="hstack gap-3 flex-wrap">

                                            <?php if($vendor->approval != 'approved'): ?>
                                            <a href="javascript:void(0);" onclick="set_accept_to_vendor('<?php echo e($vendor->id); ?>',this);">
                                                <i id="vendor_approve_icon" class="ri-check-fill"></i>
                                            </a>
                                            <?php else: ?>
                                            <a href="javascript:void(0);" onclick="vendorApprove('<?php echo e($vendor->id); ?>',this);">
                                                <i id="vendor_approve_icon" class="link-danger ri-indeterminate-circle-fill"></i>
                                            </a>
                                            <?php endif; ?>

                                        <a href="<?php echo e(route('admin.vendors.show', ['vendor' => $vendor])); ?>" class="fs-15">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.vendors.edit', ['vendor' => $vendor])); ?>" class="fs-15">
                                            <i class="ri-edit-2-line"></i>
                                        </a>
                                        
                                        
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <?php echo e($vendors->links()); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script-bottom'); ?>
    <script>
        function vendorApprove(vendorId, item)
        {
            let iconSpan = $(item).find('#vendor_approve_icon');
            $.post("<?php echo e(URL::asset('/admin')); ?>/vendors/approve/" + vendorId, {
                id: vendorId,
                "_token": "<?php echo e(csrf_token()); ?>"
            }, function (data) {
                if (data.status == 'success') {
                    Swal.fire({
                        html: '<div class="mt-3">' +
                            '<div class="mt-4 pt-2 fs-15">' +
                            '<h4>' + data.message + '</h4>' +
                            '</div>' +
                            '</div>',
                        showCancelButton: false,
                        showConfirmButton: false,
                        timer: 1000
                    });
                    if (data.data != 'approved')
                    {
                        iconSpan.removeClass('link-danger ri-indeterminate-circle-fill').addClass('ri-check-fill');
                        $(item).attr('onclick',"set_accept_to_vendor('"+vendorId+"',this);")
                    }
                    else
                    {
                        iconSpan.removeClass('ri-check-fill').addClass('link-danger ri-indeterminate-circle-fill');
                        $(item).attr('onclick',"vendorApprove('"+vendorId+"',this);")
                    }
                }
            }, "json");
        }

        function set_accept_to_vendor(id,item)
        {
            Swal.fire({
                title: '<?php echo app('translator')->get('admin.vendor_admin_percentage_hint'); ?>',
                icon: 'question',
                input: 'range',
                inputLabel: '<?php echo app('translator')->get('admin.vendor_admin_percentage'); ?>',
                showCancelButton: false,
                confirmButtonText: '<?php echo app('translator')->get('admin.save'); ?>',
                /*cancelButtonText: '<?php echo app('translator')->get('admin.no'); ?>',*/
                reverseButtons: true,
                inputAttributes: {
                    min: 0,
                    max: 100,
                    step: 1
                },
                inputValue: 10,
            }).then((result) => {
                if (parseInt(result.value) != null && parseInt(result.value) >= 0) {
                    var data  = {
                        'id':id,
                        'ratio':parseInt(result.value),
                        "_token": "<?php echo e(csrf_token()); ?>",
                    };

                    $.ajax({
                        url: "<?php echo e(URL::asset('/admin')); ?>/vendors/accept-set-ratio",
                        type:'post',
                        data: data,
                        dataType:'json',
                        success: function(data) {
                            $(item).parents('tr').find(".commission").text("% "+parseInt(result.value));
                            vendorApprove(id,item);
                        }
                    });
                }
            });
        }

        function vendorChangeStatus(vendorId, item)
        {
            $.post("<?php echo e(URL::asset('/admin')); ?>/vendors/activation/" + vendorId, {
                id: vendorId,
                "_token": "<?php echo e(csrf_token()); ?>"
            }, function (data) {
                if (data.status == 'success' && data.data !=1)
                {
                    Swal.fire({
                        html: '<div class="mt-3">' +
                            '<div class="mt-4 pt-2 fs-15">' +
                            '<h4>' + data.message + '</h4>' +
                            '</div>' +
                            '</div>',
                        showCancelButton: true,
                        showConfirmButton: false,
                        cancelButtonClass: 'btn btn-primary w-xs mb-1',
                        cancelButtonText: '<?php echo app('translator')->get('admin.back'); ?>',
                        buttonsStyling: false,
                        showCloseButton: true
                    });
                }
            }, "json");
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/abdo/Sites/localhost/saudi-dates/resources/views/admin/vendor/index.blade.php ENDPATH**/ ?>