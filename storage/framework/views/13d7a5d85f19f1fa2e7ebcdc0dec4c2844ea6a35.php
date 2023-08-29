
<?php $__env->startSection('title'); ?>
<?php echo app('translator')->get('translation.signin'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="auth-page-wrapper pt-5">
    <!-- auth page bg -->
    <div class="auth-one-bg-position auth-one-bg"  id="auth-particles" style="background-image: url('/assets/images/dates_background5415.jpg');">
        <div class="bg-overlay" style="background: -webkit-gradient(linear,left top,right top,from(#11998e),to(#27aa9d));background: linear-gradient(to right,#11998e,#27aa9d);opacity: .9;"></div>

        <div class="shape">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
            </svg>
        </div>
    </div>
    <!-- auth page content -->
    <div class="auth-page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-sm-5 mb-4 text-white-50">
                        <div>
                            <a href="index" class="d-inline-block auth-logo">
                                <img src="<?php echo e(URL::asset('white_logo.svg')); ?>" alt="" height="80">
                            </a>
                        </div>
                        <p class="mt-3 fs-15 fw-medium"><?php echo app('translator')->get('translation.app_name'); ?></p>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4">
                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary"><?php echo app('translator')->get('translation.welcome_back'); ?></h5>
                                <p class="text-muted"><?php echo app('translator')->get('translation.Sign_in_to_continue_to_suadi_dates'); ?>.</p>
                            </div>
                            <?php if(session()->has('success')): ?>
                            <div class="text-center mt-2">
                                <div class="alert alert-success alert-borderless" role="alert">
                                    <?php echo e(session()->get('success')); ?>

                                </div>
                            </div>
                            <?php endif; ?>
                            <?php if(session()->has('inactive')): ?>
                                <div class="text-center mt-2">
                                    <div class="alert alert-danger alert-borderless" role="alert">
                                        <?php echo e(session()->get('inactive')); ?>

                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php $__errorArgs = ['warning'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-center mt-2">
                                    <div class="alert alert-danger alert-borderless" role="alert">
                                        <?php echo e($message); ?>

                                    </div>
                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <div class="p-2 mt-4">
                                <form action="<?php echo e(route('vendor.login')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="mb-3">
                                        <label for="username" class="form-label"><?php echo app('translator')->get('translation.phone'); ?></label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('phone')); ?>" id="username" name="phone" placeholder="<?php echo app('translator')->get('translation.phone_placeholder'); ?>">
                                        <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="mb-3">
                                        <div class="float-end">
                                            <a href="<?php echo e(route('vendor.password.request')); ?>" class="text-muted"><?php echo app('translator')->get('translation.forgot_password'); ?></a>
                                        </div>
                                        <label class="form-label" for="password-input"><?php echo app('translator')->get('translation.password'); ?></label>
                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                            <input type="password" class="form-control pe-5 password-input <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                placeholder="<?php echo app('translator')->get('translation.password_placeholder'); ?>" name="password" id="password-input">
                                            <button
                                                class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                type="button" id="password-addon"><i
                                                    class="ri-eye-fill align-middle"></i></button>
                                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember_me" value="" name="remember" id="auth-remember-check">
                                        <label class="form-check-label" for="auth-remember-check"><?php echo app('translator')->get('translation.remember_me'); ?></label>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-success w-100" type="submit"><?php echo app('translator')->get('translation.sign_in'); ?></button>
                                    </div>

                                    
                                </form>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->

                    <div class="mt-4 text-center">
                        <p class="mb-0"><?php echo app('translator')->get('translation.not_have_an_account'); ?> <a href="<?php echo e(route('vendor.register')); ?>" class="fw-semibold text-primary text-decoration-underline"> <?php echo app('translator')->get('translation.signup'); ?> </a> </p>
                    </div>

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">&copy; <script>document.write(new Date().getFullYear())</script> <?php echo app('translator')->get('translation.app_name'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('assets/libs/particles.js/particles.js.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/pages/particles.app.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/pages/password-addon.init.js')); ?>"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('vendor.layouts.master-without-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/abdo/Sites/localhost/saudi-dates/resources/views/vendor/auth/login.blade.php ENDPATH**/ ?>