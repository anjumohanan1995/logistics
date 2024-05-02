<?php
    $company_settings = getCompanyAllSetting();
?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__(!empty($company_settings['hrm_branch_name']) ? $company_settings['hrm_branch_name'] : 'Branch')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
<?php echo e(__('Branch')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-action'); ?>
<div>
    <?php if (app('laratrust')->hasPermission('branch create')) : ?>
        <a  class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="md" data-title="<?php echo e(__('Create New Branch')); ?>" data-url="<?php echo e(route('branch.create')); ?>" data-toggle="tooltip" title="<?php echo e(__('Create')); ?>">
            <i class="ti ti-plus"></i>
        </a>
    <?php endif; // app('laratrust')->permission ?>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-3">
        <?php echo $__env->make('hrm::layouts.hrm_setup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <?php if (app('laratrust')->hasPermission('branch name edit')) : ?>
    <div class="col-sm-9">
        <div class="card">
            <div class="d-flex justify-content-between">
                <div class="card-body table-border-style">
                    <h4><?php echo e(!empty($company_settings['hrm_branch_name']) ? $company_settings['hrm_branch_name'] : __('Branch')); ?></h4>
                </div>
                <div class="d-flex align-items-center px-4">
                    <div class="action-btn bg-info">
                        <a  class="mx-3 btn btn-sm  align-items-center"
                            data-url="<?php echo e(route('branchname.edit')); ?>"
                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip" title=""
                            data-title="<?php echo e(__('Edit '.(!empty($company_settings['hrm_branch_name']) ? $company_settings['hrm_branch_name'] : __('Branch')))); ?>"
                            data-bs-original-title="<?php echo e(__('Edit Name')); ?>">
                            <i class="ti ti-pencil text-white"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
     <?php endif; // app('laratrust')->permission ?>
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table mb-0 " >
                        <thead>
                            <tr>
                                <th><?php echo e(!empty($company_settings['hrm_branch_name']) ? $company_settings['hrm_branch_name'] : __('Branch')); ?></th>
                                <th width="200px"><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody >
                                <?php $__empty_1 = true; $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e(!empty($branch->name) ? $branch->name : ''); ?></td>
                                        <td class="Action">
                                            <span>
                                                <?php if (app('laratrust')->hasPermission('branch edit')) : ?>
                                                    <div class="action-btn bg-info ms-2">
                                                        <a  class="mx-3 btn btn-sm  align-items-center"
                                                            data-url="<?php echo e(URL::to('branch/' . $branch->id . '/edit')); ?>"
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip" title=""
                                                            data-title="<?php echo e(__('Edit Branch')); ?>"
                                                            data-bs-original-title="<?php echo e(__('Edit')); ?>">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                <?php endif; // app('laratrust')->permission ?>
                                                <?php if (app('laratrust')->hasPermission('branch delete')) : ?>
                                                <div class="action-btn bg-danger ms-2">
                                                    <?php echo e(Form::open(array('route'=>array('branch.destroy', $branch->id),'class' => 'm-0'))); ?>

                                                    <?php echo method_field('DELETE'); ?>
                                                        <a
                                                            class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm"
                                                            data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                                                            aria-label="Delete" data-confirm="<?php echo e(__('Are You Sure?')); ?>" data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"  data-confirm-yes="delete-form-<?php echo e($branch->id); ?>"><i
                                                                class="ti ti-trash text-white text-white"></i></a>
                                                    <?php echo e(Form::close()); ?>

                                                </div>
                                                <?php endif; // app('laratrust')->permission ?>
                                        </span>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                     <?php echo $__env->make('layouts.nodatafound', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php endif; ?>
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/logistics/Modules/Hrm/Resources/views/branch/index.blade.php ENDPATH**/ ?>