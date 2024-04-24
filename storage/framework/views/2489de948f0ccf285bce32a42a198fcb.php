

<footer class="dash-footer mt-5">
    <div class="footer-wrapper">
        <div class="py-1">
            <span class="text-muted">
                <?php if(isset($company_settings['footer_text'])): ?>
                    <?php echo e($company_settings['footer_text']); ?>

                <?php elseif(isset($admin_settings['footer_text'])): ?>
                    <?php echo e($admin_settings['footer_text']); ?>

                <?php else: ?>
                    <?php echo e(__('Copyright')); ?> &copy; <?php echo e(config('app.name', 'WorkDo')); ?>

                <?php endif; ?>
                <?php echo e(date('Y')); ?>

            </span>
        </div>
    </div>
</footer>



<?php if(Route::currentRouteName() !== 'chatify'): ?>
<div id="commonModal" class="modal" tabindex="-1" aria-labelledby="exampleModalLongTitle"
    aria-modal="true" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="body">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="commonModalOver" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="body">
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<div class="loader-wrapper d-none">
<span class="site-loader"> </span>
</div>
<div class="position-fixed top-0 end-0 p-3" style="z-index: 99999">
<div id="liveToast" class="toast text-white  fade" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
        <div class="toast-body"> </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
            aria-label="Close"></button>
    </div>
</div>
</div>
<!-- Required Js -->


<script src="<?php echo e(asset('assets/js/plugins/popper.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/perfect-scrollbar.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/feather.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/simplebar.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/dash.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/simple-datatables.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/bootstrap-switch-button.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/sweetalert2.all.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/datepicker-full.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/flatpickr.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/choices.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/jquery.form.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/layout-tab.js')); ?>"></script>



<script src="<?php echo e(asset('js/custom.js')); ?>"></script>
<?php if($message = Session::get('success')): ?>
<script>
    toastrs('Success', '<?php echo $message; ?>', 'success');
</script>
<?php endif; ?>
<?php if($message = Session::get('error')): ?>
<script>
    toastrs('Error', '<?php echo $message; ?>', 'error');
</script>
<?php endif; ?>
<?php echo $__env->yieldPushContent('scripts'); ?>
<?php echo $__env->make('Chatify::layouts.footerLinks', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php if(isset($admin_settings['enable_cookie']) && $admin_settings['enable_cookie'] == 'on'): ?>
<?php echo $__env->make('layouts.cookie_consent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
</body>

</html>
<?php /**PATH /opt/lampp/htdocs/logistics/resources/views/partials/footer.blade.php ENDPATH**/ ?>