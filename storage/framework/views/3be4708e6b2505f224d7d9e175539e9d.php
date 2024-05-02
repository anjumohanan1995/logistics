<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Award')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
<?php echo e(__('Award')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-action'); ?>
<div>
    <?php if (app('laratrust')->hasPermission('award create')) : ?>
        <a  class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="md" data-title="<?php echo e(__('Create New Award')); ?>" data-url="<?php echo e(route('award.create')); ?>" data-toggle="tooltip" title="<?php echo e(__('Create')); ?>">
            <i class="ti ti-plus text-white"></i>
        </a>
    <?php endif; // app('laratrust')->permission ?>
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
                                <?php if(in_array(\Auth::user()->type, \Auth::user()->not_emp_type)): ?>
                                    <th><?php echo e(__('Employee')); ?></th>
                                <?php endif; ?>
                                <th><?php echo e(__('Award Type')); ?></th>
                                <th><?php echo e(__('Date')); ?></th>
                                <th><?php echo e(__('Gift')); ?></th>
                                <th><?php echo e(__('Description')); ?></th>
                                <?php if(Laratrust::hasPermission('award edit') || Laratrust::hasPermission('award delete')): ?>
                                    <th width="200px"><?php echo e(__('Action')); ?></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $awards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $award): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <?php if(in_array(\Auth::user()->type, \Auth::user()->not_emp_type)): ?>
                                    <td><?php echo e(!empty( $award->user_id) ? $award->users->name : '--'); ?></td>
                                <?php endif; ?>
                                <td><?php echo e(!empty($award->awardType) ?  ($award->awardType->name ) ?? '' : ''); ?></td>
                                <td><?php echo e(company_date_formate($award->date)); ?></td>
                                <td><?php echo e($award->gift); ?></td>
                                <td>
                                    <p style="white-space: nowrap;
                                        width: 200px;
                                        overflow: hidden;
                                        text-overflow: ellipsis;"><?php echo e(!empty($award->description) ? $award->description : ''); ?>

                                    </p>
                                </td>
                                <?php if(Laratrust::hasPermission('award edit') || Laratrust::hasPermission('award delete')): ?>
                                    <td class="Action">
                                        <span>
                                            <?php if (app('laratrust')->hasPermission('award edit')) : ?>
                                            <div class="action-btn bg-info ms-2">
                                                <a  class="mx-3 btn btn-sm  align-items-center"
                                                    data-url="<?php echo e(route('award.edit', $award->id)); ?>"
                                                    data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip" title=""
                                                    data-title="<?php echo e(__('Edit Award')); ?>"
                                                    data-bs-original-title="<?php echo e(__('Edit')); ?>">
                                                    <i class="ti ti-pencil text-white"></i>
                                                </a>
                                            </div>
                                            <?php endif; // app('laratrust')->permission ?>
                                            <?php if (app('laratrust')->hasPermission('award delete')) : ?>
                                            <div class="action-btn bg-danger ms-2">
                                                <?php echo e(Form::open(array('route'=>array('award.destroy', $award->id),'class' => 'm-0'))); ?>

                                                <?php echo method_field('DELETE'); ?>
                                                    <a
                                                        class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm"
                                                        data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                                                        aria-label="Delete" data-confirm="<?php echo e(__('Are You Sure?')); ?>" data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"  data-confirm-yes="delete-form-<?php echo e($award->id); ?>"><i
                                                            class="ti ti-trash text-white text-white"></i></a>
                                                <?php echo e(Form::close()); ?>

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

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/logistics/Modules/Hrm/Resources/views/award/index.blade.php ENDPATH**/ ?>