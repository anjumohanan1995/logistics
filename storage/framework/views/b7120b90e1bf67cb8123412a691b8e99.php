<?php
    if(Auth::user()->type=='super admin')
    {
        $plural_name = __('Customers');
        $singular_name = __('Customer');
    }
    else{

        $plural_name =__('Users');
        $singular_name =__('User');
    }
?>
<?php $__env->startSection('page-title'); ?>
<?php echo e($plural_name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
<?php echo e($plural_name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-action'); ?>
<div>
    <?php if (app('laratrust')->hasPermission('user logs history')) : ?>
        <a href="<?php echo e(route('users.userlog.history')); ?>" class="btn btn-sm btn-primary"
                data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('User Logs History')); ?>"><i class="ti ti-user-check"></i>
        </a>
    <?php endif; // app('laratrust')->permission ?>

    <?php if (app('laratrust')->hasPermission('user import')) : ?>
        <a href="#" class="btn btn-sm btn-primary" data-ajax-popup="true" data-title="<?php echo e(__('Import')); ?>"
            data-url="<?php echo e(route('users.file.import')); ?>" data-toggle="tooltip" title="<?php echo e(__('Import')); ?>"><i
                class="ti ti-file-import"></i>
        </a>
    <?php endif; // app('laratrust')->permission ?>
    <?php if (app('laratrust')->hasPermission('user manage')) : ?>
        <a href="<?php echo e(route('users.index')); ?>" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Grid View')); ?>"
            class="btn btn-sm btn-primary btn-icon">
            <i class="ti ti-layout-grid"></i>
        </a>
    <?php endif; // app('laratrust')->permission ?>
    <?php if (app('laratrust')->hasPermission('user create')) : ?>
        <a href="#" class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="md" data-title="<?php echo e(__('Create New '.($singular_name))); ?>"  data-url="<?php echo e(route('users.create')); ?>" data-bs-toggle="tooltip"  data-bs-original-title="<?php echo e(__('Create')); ?>">
            <i class="ti ti-plus"></i>
        </a>
    <?php endif; // app('laratrust')->permission ?>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table mb-0 pc-dt-simple" id="users">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col"><?php echo e(__('Picture')); ?></th>
                                        <th scope="col"><?php echo e(__('Name')); ?></th>
                                        <th scope="col"><?php echo e(__('Email')); ?></th>
                                        <th scope="col"><?php echo e(__('Role')); ?></th>
                                        <?php if(Laratrust::hasPermission('user edit') || Laratrust::hasPermission('user delete')): ?>
                                            <th width="10%"> <?php echo e(__('Action')); ?></th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <th scope="row"><?php echo e(++$index); ?></th>
                                            <td>
                                                <a>
                                                    <img src="<?php echo e(check_file($user->avatar) ? get_file($user->avatar) :get_file('uploads/users-avatar/avatar.png')); ?>" class="img-fluid rounded-circle card-avatar" width="35" id="blah3">
                                                </a>
                                            </td>
                                            <td><?php echo e($user->name); ?></td>
                                            <td><?php echo e($user->email); ?></td>
                                            <td>
                                                <span class="badge bg-primary p-2 px-3 rounded rounded">
                                                    <?php echo e($user->type); ?>

                                                </span>
                                            </td>
                                            <td class="text-end me-3">
                                                <?php if($user->is_disable == 1 || Auth::user()->type == 'super admin'): ?>
                                                    <?php if(Auth::user()->type == "super admin"): ?>
                                                        <div class="action-btn bg-primary ms-2">
                                                            <a data-url="<?php echo e(route('company.info',$user->id)); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center"  data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Admin Hub')); ?>" data-title="<?php echo e(__('Company Info')); ?>"> <span class="text-white"><i class="ti ti-atom"></i></a>
                                                        </div>
                                                        <div class="action-btn bg-secondary ms-2">
                                                            <a href="<?php echo e(route('login.with.company',$user->id)); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center"   data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Login As Company')); ?>"> <span class="text-white"><i class="ti ti-replace"></i></a>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if (app('laratrust')->hasPermission('user reset password')) : ?>
                                                        <div class="action-btn bg-warning  ms-2">
                                                            <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-url="<?php echo e(route('users.reset', \Crypt::encrypt($user->id))); ?>" data-ajax-popup="true"  data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Reset Password')); ?>"> <span class="text-white"><i class="ti ti-adjustments"></i></a>
                                                        </div>
                                                    <?php endif; // app('laratrust')->permission ?>
                                                    <?php if (app('laratrust')->hasPermission('user login manage')) : ?>
                                                        <?php if($user->is_enable_login == 1): ?>
                                                            <div class="action-btn bg-danger ms-2">
                                                                <a href="<?php echo e(route('users.login', \Crypt::encrypt($user->id))); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center"   data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Login Disable')); ?>"> <span class="text-white"><i class="ti ti-road-sign"></i></a>
                                                            </div>
                                                        <?php elseif($user->is_enable_login == 0 && $user->password == null): ?>
                                                            <div class="action-btn bg-secondary ms-2">
                                                                <a href="#" data-url="<?php echo e(route('users.reset', \Crypt::encrypt($user->id))); ?>"
                                                                    data-ajax-popup="true" data-size="md" class="mx-3 btn btn-sm d-inline-flex align-items-center login_enable" data-title="<?php echo e(__('New Password')); ?>" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('New Password')); ?>"> <span class="text-white"><i class="ti ti-road-sign"></i></a>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="action-btn bg-success ms-2">
                                                                <a href="<?php echo e(route('users.login', \Crypt::encrypt($user->id))); ?>"
                                                                    class="mx-3 btn btn-sm d-inline-flex align-items-center login_enable"  data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Login Enable')); ?>"> <span class="text-white">                                                            <i class="ti ti-road-sign"></i>
                                                                </a>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endif; // app('laratrust')->permission ?>
                                                    <?php if (app('laratrust')->hasPermission('user edit')) : ?>
                                                        <div class="action-btn bg-info ms-2">
                                                            <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-url="<?php echo e(route('users.edit', $user->id)); ?>" class="dropdown-item" data-ajax-popup="true" data-title="<?php echo e(__('Update '.($singular_name))); ?>" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Edit')); ?>"> <span class="text-white"> <i class="ti ti-edit"></i></span></a>
                                                        </div>
                                                    <?php endif; // app('laratrust')->permission ?>
                                                    <?php if (app('laratrust')->hasPermission('user delete')) : ?>
                                                    <div class="action-btn bg-danger ms-2">
                                                        <?php echo e(Form::open(['route' => ['users.destroy', $user->id], 'class' => 'm-0'])); ?>

                                                        <?php echo method_field('DELETE'); ?>
                                                        <a href="#"
                                                            class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm"
                                                            data-bs-toggle="tooltip" title=""
                                                            data-bs-original-title="Delete" aria-label="Delete"
                                                            data-confirm-yes="delete-form-<?php echo e($user->id); ?>"><i
                                                                class="ti ti-trash text-white text-white"></i></a>
                                                        <?php echo e(Form::close()); ?>

                                                    </div>
                                                    <?php endif; // app('laratrust')->permission ?>
                                                <?php else: ?>
                                                    <div class="text-center">
                                                        <i class="ti ti-lock"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- [ Main Content ] end -->
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>

<script>
    $(document).on('change', '#password_switch', function() {
        if($(this).is(':checked'))
        {
            $('.ps_div').removeClass('d-none');
            $('#password').attr("required",true);

        } else {
            $('.ps_div').addClass('d-none');
            $('#password').val(null);
            $('#password').removeAttr("required");
        }
    });
    $(document).on('click', '.login_enable', function() {
        setTimeout(function() {
             $('.modal-body').append($('<input>', {type: 'hidden',val: 'true',name: 'login_enable' }));
        }, 1000);
    });
</script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/logistics/resources/views/users/list.blade.php ENDPATH**/ ?>