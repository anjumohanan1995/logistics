<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Employee')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Employee')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-action'); ?>
    <div>
        <?php echo $__env->yieldPushContent('addButtonHook'); ?>
        <?php if (app('laratrust')->hasPermission('employee import')) : ?>
            <a href="#" class="btn btn-sm btn-primary" data-ajax-popup="true" data-title="<?php echo e(__('Employee Import')); ?>"
                data-url="<?php echo e(route('employee.file.import')); ?>" data-toggle="tooltip" title="<?php echo e(__('Import')); ?>"><i
                    class="ti ti-file-import"></i>
            </a>
        <?php endif; // app('laratrust')->permission ?>
        <a href="<?php echo e(route('employee.grid')); ?>" class="btn btn-sm btn-primary btn-icon"
            data-bs-toggle="tooltip"title="<?php echo e(__('Grid View')); ?>">
            <i class="ti ti-layout-grid text-white"></i>
        </a>
        <?php if (app('laratrust')->hasPermission('employee create')) : ?>
            <a href="<?php echo e(route('employee.create')); ?>" data-title="<?php echo e(__('Create New Employee')); ?>" data-bs-toggle="tooltip"
                title="" class="btn btn-sm btn-primary" data-bs-original-title="<?php echo e(__('Create')); ?>">
                <i class="ti ti-plus"></i>
            </a>
        <?php endif; // app('laratrust')->permission ?>
    </div>
<?php $__env->stopSection(); ?>
<?php
    $company_settings = getCompanyAllSetting();
?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table mb-0 pc-dt-simple" id="assets">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Employee ID')); ?></th>
                                    <th><?php echo e(__('Name')); ?></th>
                                    <th><?php echo e(__('Email')); ?></th>
                                    <th><?php echo e(!empty($company_settings['hrm_branch_name']) ? $company_settings['hrm_branch_name'] : __('Branch')); ?>

                                    </th>
                                    <th><?php echo e(!empty($company_settings['hrm_department_name']) ? $company_settings['hrm_department_name'] : __('Department')); ?>

                                    </th>
                                    <th><?php echo e(!empty($company_settings['hrm_designation_name']) ? $company_settings['hrm_designation_name'] : __('Designation')); ?>

                                    </th>
                                    <th><?php echo e(__('Date Of Joining')); ?></th>
                                    <?php if(Laratrust::hasPermission('employee edit') || Laratrust::hasPermission('employee delete')): ?>
                                        <th width="200px"><?php echo e(__('Action')); ?></th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <?php if(!empty($employee->employee_id)): ?>
                                            <td>
                                                <?php if (app('laratrust')->hasPermission('employee show')) : ?>
                                                    <a class="btn btn-outline-primary"
                                                        href="<?php echo e(route('employee.show', \Illuminate\Support\Facades\Crypt::encrypt($employee->id))); ?>"><?php echo e(Modules\Hrm\Entities\Employee::employeeIdFormat($employee->employee_id)); ?></a>
                                                <?php else: ?>
                                                    <a
                                                        class="btn btn-outline-primary"><?php echo e(Modules\Hrm\Entities\Employee::employeeIdFormat($employee->employee_id)); ?></a>
                                                <?php endif; // app('laratrust')->permission ?>
                                            </td>
                                        <?php else: ?>
                                            <td>--</td>
                                        <?php endif; ?>
                                        <td><?php echo e($employee->name); ?></td>
                                        <td><?php echo e($employee->email); ?></td>
                                        <td>
                                            <?php echo e(!empty($employee->branch_id) ? $employee->branches_name : '--'); ?>

                                        </td>
                                        <td>
                                            <?php echo e(!empty($employee->department_id) ? $employee->departments_name : '--'); ?>

                                        </td>
                                        <td>
                                            <?php echo e(!empty($employee->designation_id) ? $employee->designations_name : '--'); ?>

                                        </td>
                                        <td>
                                            <?php echo e(!empty($employee->company_doj) ? company_date_formate($employee->company_doj) : '--'); ?>

                                        </td>
                                        <?php if(Laratrust::hasPermission('employee edit') || Laratrust::hasPermission('employee delete')): ?>
                                            <td class="Action">
                                                <?php if($employee->is_disable == 1): ?>
                                                    <span>
                                                        <?php if (app('laratrust')->hasPermission('employee edit')) : ?>
                                                            <div class="action-btn bg-info ms-2">
                                                                <a href="<?php echo e(route('employee.edit', \Illuminate\Support\Facades\Crypt::encrypt($employee->ID))); ?>"
                                                                    class="mx-3 btn btn-sm  align-items-center"
                                                                    data-bs-toggle="tooltip" title=""
                                                                    data-bs-original-title="<?php echo e(__('Edit')); ?>">
                                                                    <i class="ti ti-pencil text-white"></i>
                                                                </a>
                                                            </div>
                                                        <?php endif; // app('laratrust')->permission ?>
                                                        <?php if(!empty($employee->employee_id)): ?>
                                                            <?php if (app('laratrust')->hasPermission('employee show')) : ?>
                                                                <div class="action-btn bg-warning ms-2">
                                                                    <a href="<?php echo e(route('employee.show', \Illuminate\Support\Facades\Crypt::encrypt($employee->id))); ?>"
                                                                        class="mx-3 btn btn-sm  align-items-center"
                                                                        data-bs-toggle="tooltip" title=""
                                                                        data-bs-original-title="<?php echo e(__('Show')); ?>">
                                                                        <i class="ti ti-eye text-white"></i>
                                                                    </a>
                                                                </div>
                                                            <?php endif; // app('laratrust')->permission ?>
                                                            <?php if (app('laratrust')->hasPermission('employee delete')) : ?>
                                                                <div class="action-btn bg-danger ms-2">
                                                                    <?php echo e(Form::open(['route' => ['employee.destroy', $employee->id], 'class' => 'm-0'])); ?>

                                                                    <?php echo method_field('DELETE'); ?>
                                                                    <a class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm"
                                                                        data-bs-toggle="tooltip" title=""
                                                                        data-bs-original-title="Delete" aria-label="Delete"
                                                                        data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                                        data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                                        data-confirm-yes="delete-form-<?php echo e($employee->id); ?>"><i
                                                                            class="ti ti-trash text-white text-white"></i></a>
                                                                    <?php echo e(Form::close()); ?>

                                                                </div>
                                                            <?php endif; // app('laratrust')->permission ?>
                                                        <?php endif; ?>
                                                    </span>
                                                <?php else: ?>
                                                    <div class="text-center">
                                                        <i class="ti ti-lock"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/logistics/Modules/Hrm/Resources/views/employee/index.blade.php ENDPATH**/ ?>