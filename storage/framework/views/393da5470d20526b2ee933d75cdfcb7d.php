<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Employee Salary')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Employee Salary')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-action'); ?>
    <div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table mb-0 pc-dt-simple" id="assets">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Employee Id')); ?></th>
                                    <th><?php echo e(__('Name')); ?></th>
                                    <th><?php echo e(__('Payroll Type')); ?></th>
                                    <th><?php echo e(__('Salary')); ?></th>
                                    <th><?php echo e(__('Net Salary')); ?></th>
                                    <?php if(Laratrust::hasPermission('setsalary edit')): ?>
                                        <th width="200px"><?php echo e(__('Action')); ?></th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <?php if(Laratrust::hasPermission('setsalary show')): ?>
                                                <a
                                                    href="<?php echo e(route('setsalary.show', $employee->id)); ?>"class="btn btn-outline-primary"><?php echo e(Modules\Hrm\Entities\Employee::employeeIdFormat($employee->employee_id)); ?>

                                                </a>
                                            <?php else: ?>
                                                <a class="btn btn-outline-primary"><?php echo e(Modules\Hrm\Entities\Employee::employeeIdFormat($employee->employee_id)); ?>

                                                </a>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($employee->name); ?></td>
                                        <td><?php echo e(!empty($employee->salary_type) ? $employee->salaryType->name ?? '--' : '--'); ?>

                                        </td>
                                        <td><?php echo e(currency_format($employee->salary)); ?></td>
                                        <td><?php echo e(!empty($employee->get_net_salary()) ? currency_format($employee->get_net_salary()) : '--'); ?>

                                            <?php if(Laratrust::hasPermission('setsalary edit')): ?>
                                        <td class="Action">
                                            <span>
                                                <?php if (app('laratrust')->hasPermission('setsalary edit')) : ?>
                                                    <div class="action-btn bg-warning ms-2">
                                                        <a href="<?php echo e(route('setsalary.show', $employee->id)); ?>"
                                                            class="mx-3 btn btn-sm  align-items-center" data-bs-toggle="tooltip"
                                                            title="" data-bs-original-title="<?php echo e(__('View')); ?>">
                                                            <i class="ti ti-eye text-white"></i>
                                                        </a>
                                                    </div>
                                                <?php endif; // app('laratrust')->permission ?>
                                            </span>
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

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/logistics/Modules/Hrm/Resources/views/setsalary/index.blade.php ENDPATH**/ ?>