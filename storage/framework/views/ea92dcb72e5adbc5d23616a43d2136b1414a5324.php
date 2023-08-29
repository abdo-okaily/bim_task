
<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('admin.customers_list'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body border-bottom-dashed border-bottom">
                    <form method="get" action="<?php echo e(URL::asset('/admin')); ?>/customers/">
                        <div class="row g-3">
                            <div class="col-xl-3">
                                <div class="search-box">
                                    <input value="<?php echo e(request('name')); ?>" type="text" name="name" class="form-control search" placeholder="<?php echo app('translator')->get('admin.customer_name'); ?>">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="search-box">
                                    <input value="<?php echo e(request('email')); ?>" type="text" name="email" class="form-control search" placeholder="<?php echo app('translator')->get('admin.customer_email'); ?>">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="search-box">
                                    <input value="<?php echo e(request('phone')); ?>" type="text" name="phone" class="form-control search" placeholder="<?php echo app('translator')->get('admin.customer_phone'); ?>">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xl-3">
                                <div>
                                    <button type="submit" class="btn btn-secondary w-100">
                                        <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                
                                <th scope="col"><?php echo app('translator')->get('admin.customer_name'); ?></th>
                                <th scope="col"><?php echo app('translator')->get('admin.customer_email'); ?></th>
                                <th scope="col"><?php echo app('translator')->get('admin.customer_phone'); ?></th>
                                <th scope="col"><?php echo app('translator')->get('admin.customer_addresses_count'); ?></th>
                                <th scope="col"><?php echo app('translator')->get('admin.customer_transactions_count'); ?></th>
                                <th scope="col"><?php echo app('translator')->get('admin.customer_priority'); ?></th>
                                <th scope="col"><?php echo app('translator')->get('admin.customer_banned'); ?></th>
                                <th scope="col"><?php echo app('translator')->get('admin.actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($customer->id); ?></td>
                                    
                                    <td><?php echo e($customer->name); ?></td>
                                    <td><?php echo e($customer->email); ?></td>
                                    <td><?php echo e($customer->phone); ?></td>
                                    <td><?php echo e((int)$customer->addresses->count()); ?></td>
                                    <td><?php echo e((int)$customer->transactions->count()); ?></td>
                                    <td>
                                        <select onchange="customerChangePriority('<?php echo e($customer->id); ?>',this)" data-priority="<?php echo e($customer->priority); ?>" class="form-select mb-3">
                                            <?php $__currentLoopData = $customer->customer_priorities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $priority): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option <?php if($customer->priority == $priority): ?> selected <?php endif; ?> value="<?php echo e($priority); ?>"><?php echo app('translator')->get('admin.customer_' . $priority); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </td>
                                    <td id="customerBanned_<?php echo e($customer->id); ?>">
                                        <?php if($customer->is_banned == 1): ?>
                                            <?php echo app('translator')->get('admin.yes'); ?>
                                        <?php else: ?>
                                            <?php echo app('translator')->get('admin.no'); ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="hstack gap-3 flex-wrap">
                                            <a href="javascript:void(0);" onclick="customerApprove('<?php echo e($customer->id); ?>',this);">
                                                <?php if($customer->is_banned == 1): ?>
                                                    <i id="customer_approve_icon" class="ri-check-fill"></i>
                                                <?php else: ?>
                                                    <i id="customer_approve_icon" class="link-danger ri-indeterminate-circle-fill"></i>
                                                <?php endif; ?>
                                            </a>
                                            <a href="<?php echo e(route('admin.customers.show', ['user' => $customer])); ?>" class="fs-15">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.customers.edit', ['user' => $customer])); ?>" class="fs-15">
                                                <i class="ri-edit-2-line"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <?php echo e($customers->links()); ?>

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
        function customerChangePriority(customerId, item)
        {
            let priority = $(item).val();
            $.post("<?php echo e(URL::asset('/admin')); ?>/customers/priority/" + customerId, {
                id: customerId,
                priority: priority,
                "_token": "<?php echo e(csrf_token()); ?>"
            }, function (data)
            {
                if (data.status == 'success')
                {
                    Swal.fire({
                        html: '<div class="mt-3">' +
                            '<div class="mt-4 pt-2 fs-15">' +
                            '<h4><?php echo app('translator')->get('admin.customer_change_priority_message'); ?></h4>' +
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
        function customerApprove(customerId, item)
        {
            let iconSpan = $(item).find('#customer_approve_icon');
            let customerBanned = $('#customerBanned_'+customerId);
            $.post("<?php echo e(URL::asset('/admin')); ?>/customers/block/" + customerId, {
                id: customerId,
                "_token": "<?php echo e(csrf_token()); ?>"
            }, function (data) {
                if (data.status == 'success')
                {
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
                    if (data.data == 1)
                    {
                        iconSpan.removeClass('link-danger ri-indeterminate-circle-fill').addClass('ri-check-fill');
                        customerBanned.text('<?php echo app('translator')->get('admin.yes'); ?>');
                    }
                    else
                    {
                        iconSpan.removeClass('ri-check-fill').addClass('link-danger ri-indeterminate-circle-fill');
                        customerBanned.text('<?php echo app('translator')->get('admin.no'); ?>');
                    }
                }
            }, "json");
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/abdo/Sites/localhost/saudi-dates/resources/views/admin/customer/index.blade.php ENDPATH**/ ?>