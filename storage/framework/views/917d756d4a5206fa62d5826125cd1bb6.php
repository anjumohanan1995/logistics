<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Settings')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Settings')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
<link href="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card sticky-top setting-sidebar" style="top:30px">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            <?php echo getSettingMenu(); ?>

                        </div>
                    </div>
                </div>
                <div class="col-xl-9 setting-menu-div">
                    <?php echo getSettings(); ?>

                </div>
            </div>
        </div>
    <?php $__env->stopSection(); ?>
    <?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.js')); ?>"></script>

        <script>
            $(document).ready(function() {
                getSettingSection('Base');
            });
            $(document).on("click", ".setting-menu-nav", function() {
                var module = $(this).attr('data-module');
                var method = $(this).attr('data-method');
                getSettingSection(module,method);
            });

            function getSettingSection(module,method = null) {
                $.ajax({
                    url: '<?php echo e(url("setting/section")); ?>' + '/' + module + '/' + method,
                    type: 'get',
                    beforeSend: function() {
                        $(".loader-wrapper").removeClass('d-none');
                    },
                    success: function(data) {
                        $(".loader-wrapper").addClass('d-none');

                        if (data.status == 200) {
                            $('.setting-menu-div').empty();
                            $('.setting-menu-div').append(data.html);
                        } else {
                            // error code
                        }
                    },
                    error: function(xhr) {
                        $(".loader-wrapper").addClass('d-none');
                        toastrs('Error', xhr.responseJSON.error, 'error');
                    }
                });
            }
        </script>
    <?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/logistics/resources/views/settings/index.blade.php ENDPATH**/ ?>