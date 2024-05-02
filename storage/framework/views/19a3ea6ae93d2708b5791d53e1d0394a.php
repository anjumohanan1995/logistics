<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Tickets')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
<?php echo e(__('Tickets')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-action'); ?>

    <div class="col-auto pe-0">
        <select class="form-select" id="projects" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);" style="width: 121px;">
            <option value="<?php echo e(route('helpdesk-tickets.search')); ?>"><?php echo e(__('All Tickets')); ?></option>
            <option value="<?php echo e(route('helpdesk-tickets.search', 'in-progress')); ?>" <?php if($status == 'in-progress'): ?> selected <?php endif; ?>><?php echo e(__('In Progress')); ?></option>
            <option value="<?php echo e(route('helpdesk-tickets.search', 'on-hold')); ?>" <?php if($status == 'on-hold'): ?> selected <?php endif; ?>><?php echo e(__('On Hold')); ?></option>
            <option value="<?php echo e(route('helpdesk-tickets.search', 'closed')); ?>" <?php if($status == 'closed'): ?> selected <?php endif; ?>><?php echo e(__('Closed')); ?></option>
        </select>
    </div>
    <div class="col-auto ps-3 mt-1">
        <?php if (app('laratrust')->hasPermission('helpdesk ticket create')) : ?>
                <a href="<?php echo e(route('helpdesk.create')); ?>" class="btn btn-sm btn-primary btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('Create')); ?>"><i class="ti ti-plus text-white"></i></a>
        <?php endif; // app('laratrust')->permission ?>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <?php if(session()->has('ticket_id') || session()->has('smtp_error')): ?>
                <div class="alert alert-info bg-pr">
                    <?php if(session()->has('ticket_id')): ?>
                        <?php echo Session::get('ticket_id'); ?>

                        <?php echo e(Session::forget('ticket_id')); ?>

                    <?php endif; ?>
                    <?php if(session()->has('smtp_error')): ?>
                        <?php echo Session::get('smtp_error'); ?>

                        <?php echo e(Session::forget('smtp_error')); ?>

                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table mb-0 pc-dt-simple" id="pc-dt-simple">
                            <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th><?php echo e(__('Ticket ID')); ?></th>
                                <th class="w-10"><?php echo e(__('Assigned To')); ?></th>
                                <th><?php echo e(__('Email')); ?></th>
                                <th><?php echo e(__('Created By')); ?></th>
                                <th><?php echo e(__('Subject')); ?></th>
                                <th><?php echo e(__('Category')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th><?php echo e(__('Created')); ?></th>
                                <th class="text-end me-3"><?php echo e(__('Action')); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <th scope="row"><?php echo e(++$index); ?></th>
                                    <td class="Id sorting_1">
                                        <a class="btn btn-outline-primary" <?php if (app('laratrust')->hasPermission('helpdesk ticket show')) : ?>href="<?php echo e(route('helpdesk.edit',$ticket->id)); ?>" <?php else: ?> href="#" <?php endif; // app('laratrust')->permission ?>>
                                            <?php echo e($ticket->ticket_id); ?>

                                        </a>
                                    </td>
                                    <td><span class="white-space"><?php echo e($ticket->name); ?></span></td>
                                    <td><?php echo e($ticket->email); ?></td>
                                    <td class="text-primary"><?php echo e($ticket->createdBy->name); ?></td>
                                    <td><span class="white-space"><?php echo e($ticket->subject); ?></span></td>

                                    <td><span class="badge badge-white p-2 px-3 rounded fix_badge" style="background: <?php echo e($ticket->color); ?>;"><?php echo e($ticket->category_name); ?></span></td>

                                    <td><span class="badge fix_badge <?php if($ticket->status == 'In Progress'): ?>bg-warning <?php elseif($ticket->status == 'On Hold'): ?> bg-danger <?php else: ?> bg-success <?php endif; ?>  p-2 px-3 rounded"><?php echo e(__($ticket->status)); ?></span></td>

                                    <td><?php echo e($ticket->created_at->diffForHumans()); ?></td>

                                    <td class="text-end">
                                        <?php if (app('laratrust')->hasPermission('helpdesk ticket show')) : ?>
                                            <div class="action-btn bg-info ms-2">
                                                <a href="<?php echo e(route('helpdesk.edit', $ticket->id)); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" title="<?php echo e(__('Edit & Reply')); ?>"> <span class="text-white"> <i class="ti ti-corner-up-left"></i></span></a>
                                            </div>

                                            <div class="action-btn bg-warning ms-2">
                                                <a href="<?php echo e(route('helpdesk.view', [\Illuminate\Support\Facades\Crypt::encrypt($ticket->ticket_id)])); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" title="<?php echo e(__('Details')); ?>"> <span class="text-white"> <i class="ti ti-eye"></i></span></a>
                                            </div>

                                        <?php endif; // app('laratrust')->permission ?>
                                        <?php if (app('laratrust')->hasPermission('helpdesk ticket delete')) : ?>
                                            <?php if(Auth::user()->id == $ticket->created_by || Auth::user()->type == 'super admin'): ?>
                                                <div class="action-btn bg-danger ms-2">
                                                    <form method="POST" action="<?php echo e(route('helpdesk.destroy',$ticket->id)); ?>" id="user-form-<?php echo e($ticket->id); ?>">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button type="button" class="mx-3 btn btn-sm d-inline-flex align-items-center show_confirm" data-bs-toggle="tooltip"
                                                        title='Delete'>
                                                            <span class="text-white"> <i class="ti ti-trash"></i></span>
                                                        </button>
                                                    </form>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; // app('laratrust')->permission ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/logistics/resources/views/helpdesk_ticket/index.blade.php ENDPATH**/ ?>