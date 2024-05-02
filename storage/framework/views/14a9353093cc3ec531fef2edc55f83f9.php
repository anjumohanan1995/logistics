    
    <?php
    $get_setting = 'smtp';
    if(array_key_exists('email_setting', $settings))
        {
            $get_setting = $settings['email_setting'];
        }
    ?>

    <div class="card" id="email-sidenav">
        <div class="email-setting-wrap ">
            <?php echo e(Form::open(['route' => ['email.setting.store'], 'id' => 'mail-form'])); ?>

            <?php echo method_field('post'); ?>
            <?php echo csrf_field(); ?>
            <input type="hidden" class="email">
            <div class="card-header">
                <h3 class="h5"><?php echo e(__('Email Settings')); ?></h3>
            </div>
            <div class="card-body pb-0">
                <div class="d-flex">
                    <div class="col-sm-6 col-12">

                        <div class="form-group col switch-width">
                           <?php echo e(Form::label('email_setting',__('Email Setting'),array('class'=>' col-form-label'))); ?>


                           <?php echo e(Form::select('email_setting',$email_setting, isset($settings['email_setting']) ? $settings['email_setting'] : $get_setting, ['id' => 'email_setting','class'=>"form-control choices",'searchEnabled'=>'true'])); ?>

                        </div>
                     </div>
                </div>
                <div class="row">
                    <div class="col-12" id="getfields">
                    </div>
                </div>

            </div>

            <div class="card-footer d-flex justify-content-between flex-wrap "style="gap:10px">

                <input type="hidden" name="custom_email" id="custom_email" value="<?php echo e(isset($settings['email_setting']) ? $settings['email_setting'] : $get_setting); ?>">
                <button type="button" data-url="<?php echo e(route('test.mail')); ?>" data-title="<?php echo e(__('Send Test Mail')); ?>"
                    class="btn btn-print-invoice  btn-primary m-r-10 test-mail"><?php echo e(__('Send Test Mail')); ?></button>

                <input class="btn btn-print-invoice  btn-primary m-r-10" type="submit"
                    value="<?php echo e(__('Save Changes')); ?>">
            </div>
            <?php echo e(Form::close()); ?>

        </div>
    </div>

    <!--Email Notification Settings-->
    <div class="card" id="email-notification-sidenav">
        <div class="email-setting-wrap ">
            <?php echo e(Form::open(['route' => ['email.notification.setting.store'], 'id' => 'mail-notification-form'])); ?>

            <?php echo method_field('post'); ?>
            <div class="card-header">
                <h3 class="h5"><?php echo e(__('Email Notification Settings')); ?></h3>
            </div>
            <div class="card-body pb-0">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <?php
                        $active = 'active';
                    ?>
                    <?php $__currentLoopData = $email_notification_modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e_module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(Laratrust::hasPermission($e_module . ' manage') ||
                                Laratrust::hasPermission(strtolower($e_module) . ' manage') ||
                                $e_module == 'general'): ?>
                            <li class="nav-item">
                                <a class="nav-link text-capitalize <?php echo e($active); ?>"
                                    id="pills-<?php echo e(strtolower($e_module)); ?>-tab-email" data-bs-toggle="pill"
                                    href="#pills-<?php echo e(strtolower($e_module)); ?>-email" role="tab"
                                    aria-controls="pills-<?php echo e(strtolower($e_module)); ?>-email"
                                    aria-selected="true"><?php echo e(Module_Alias_Name($e_module)); ?></a>
                            </li>
                            <?php
                                $active = '';
                            ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <div class="tab-content mb-3" id="pills-tabContent">
                    <?php $__currentLoopData = $email_notification_modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e_module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="tab-pane fade <?php echo e($loop->index == 0 ? 'active' : ''); ?> show"
                            id="pills-<?php echo e(strtolower($e_module)); ?>-email" role="tabpanel"
                            aria-labelledby="pills-<?php echo e(strtolower($e_module)); ?>-tab-email">
                            <div class="row">
                                <?php $__currentLoopData = $email_notify; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e_action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($e_action->permissions == null || Laratrust::hasPermission($e_action->permissions)): ?>
                                        <?php if($e_action->module == $e_module): ?>
                                            <div class="col-lg-4 col-md-6 col-12">
                                                <div
                                                    class="d-flex align-items-center justify-content-between list_colume_notifi pb-2 mb-3">
                                                    <div class="mb-3 mb-sm-0">
                                                        <h6>
                                                            <label for="<?php echo e($e_action->action); ?>"
                                                                class="form-label"><?php echo e($e_action->action); ?></label>
                                                        </h6>
                                                    </div>
                                                    <div class="text-end">
                                                        <div class="form-check form-switch d-inline-block">
                                                            <input type="hidden"
                                                                name="mail_noti[<?php echo e($e_action->action); ?>]"
                                                                value="0" />
                                                            <input class="form-check-input"
                                                                <?php echo e(isset($settings[$e_action->action]) && $settings[$e_action->action] == true ? 'checked' : ''); ?>

                                                                id="mail_notificaation"
                                                                name="mail_noti[<?php echo e($e_action->action); ?>]"
                                                                type="checkbox" value="1">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <input class="btn btn-print-invoice  btn-primary m-r-10" type="submit"
                    value="<?php echo e(__('Save Changes')); ?>">
            </div>
            <?php echo e(Form::close()); ?>

        </div>
    </div>




    <script>
        /* Open Test Mail Modal */
        $(document).on('click', '.test-mail', function(e) {
            e.preventDefault();
            var title = $(this).attr('data-title');
            var size = 'md';
            var url = $(this).attr('data-url');
            if (typeof url != 'undefined') {
                $("#commonModal .modal-title").html(title);
                $("#commonModal .modal-dialog").addClass('modal-' + size);
                $("#commonModal").modal('show');

                $.post(url, {
                    custom_email: $("#custom_email").val(),
                    mail_driver: $("#mail_driver").val(),
                    mail_host: $("#mail_host").val(),
                    mail_port: $("#mail_port").val(),
                    mail_username: $("#mail_username").val(),
                    mail_password: $("#mail_password").val(),
                    mail_from_address: $("#mail_from_address").val(),
                    mail_encryption: $("#mail_encryption").val(),
                    mail_host: $("#mail_host").val(),

                    _token: "<?php echo e(csrf_token()); ?>",
                }, function(data) {
                    $('#commonModal .body').html(data);
                });
            }
        })
        /* End Test Mail Modal */

        /* Test Mail Send
          ----------------------------------------*/

        $(document).on('click', '#test-send-mail', function() {
            $('#test-mail-form').ajaxForm({
                beforeSend: function() {
                    $(".loader-wrapper").removeClass('d-none');
                },
                success: function(res) {
                    $(".loader-wrapper").addClass('d-none');
                    if (res.flag == 1) {
                        toastrs('Success', res.msg, 'success');
                        $('#commonModal').modal('hide');
                    } else {
                        toastrs('Error', res.msg, 'error');
                    }
                },
                error: function(xhr) {
                    $(".loader-wrapper").addClass('d-none');
                    toastrs('Error', xhr.responseJSON.error, 'error');
                }
            }).submit();
        });
    </script>

    <script>
        $(document).ready(function() {
        // Check if email_setting is already set
        var emailSetting = $('#email_setting').val();

        if (emailSetting) {
            $.ajax({
                url: '<?php echo e(route('get.emailfields')); ?>',
                type: 'POST',
                data: {
                    "_token": "<?php echo e(csrf_token()); ?>",
                    "emailsetting": emailSetting,
                },
                success: function(data) {
                    $('#getfields').empty();
                    $('#getfields').append(data.html)
                    $('.email').append(data.html)
                },
            });
        }

        // Initialize choices
        choices();
    });
    </script>
    <script>
        $(document).on('change', '#email_setting', function() {
            var emailsetting = $(this).val();
            $.ajax({
                url: '<?php echo e(route('get.emailfields')); ?>',
                type: 'POST',

                data: {
                    "_token": "<?php echo e(csrf_token()); ?>",
                    "emailsetting": emailsetting,
                },
                success: function(data) {
                    $('#getfields').empty();
                    $('#getfields').append(data.html)
                    $('.email').append(data.html)
                },

            });
        });
    </script>

<?php /**PATH /opt/lampp/htdocs/logistics/resources/views/email/index.blade.php ENDPATH**/ ?>