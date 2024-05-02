<div class="card sticky-top" style="top:30px">
    <div class="list-group list-group-flush" id="useradd-sidenav">
        <?php if (app('laratrust')->hasPermission('branch manage')) : ?>
            <a href="<?php echo e(route('branch.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((request()->is('branch*') ? 'active' : '')); ?>"><?php echo e(__('Branch')); ?> <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        <?php endif; // app('laratrust')->permission ?>

        <?php if (app('laratrust')->hasPermission('department manage')) : ?>
            <a href="<?php echo e(route('department.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((request()->is('department*') ? 'active' : '')); ?>"><?php echo e(__('Department')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        <?php endif; // app('laratrust')->permission ?>

        <?php if (app('laratrust')->hasPermission('designation manage')) : ?>
            <a href="<?php echo e(route('designation.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((request()->is('designation*') ? 'active' : '')); ?>"><?php echo e(__('Designation')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        <?php endif; // app('laratrust')->permission ?>

        <?php if (app('laratrust')->hasPermission('allowanceoption manage')) : ?>
            <a href="<?php echo e(route('allowanceoption.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((request()->is('allowanceoption*') ? 'active' : '')); ?>"><?php echo e(__('Allowance Option')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        <?php endif; // app('laratrust')->permission ?>

        <?php if (app('laratrust')->hasPermission('loanoption manage')) : ?>
            <a href="<?php echo e(route('loanoption.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((request()->is('loanoption*') ? 'active' : '')); ?>"><?php echo e(__('Loan Option')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        <?php endif; // app('laratrust')->permission ?>

        <?php if (app('laratrust')->hasPermission('deductionoption manage')) : ?>
            <a href="<?php echo e(route('deductionoption.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((request()->is('deductionoption*') ? 'active' : '')); ?>"><?php echo e(__('Deduction Option')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        <?php endif; // app('laratrust')->permission ?>

        <?php if (app('laratrust')->hasPermission('documenttype manage')) : ?>
            <a href="<?php echo e(route('document-type.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((Request::route()->getName() == 'document-type.index' ? 'active' : '')); ?>"><?php echo e(__('Document Type')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        <?php endif; // app('laratrust')->permission ?>

        <?php if (app('laratrust')->hasPermission('paysliptype manage')) : ?>
            <a href="<?php echo e(route('paysliptype.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((request()->is('paysliptype*') ? 'active' : '')); ?>"><?php echo e(__('Payslip Type')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        <?php endif; // app('laratrust')->permission ?>

        <?php if (app('laratrust')->hasPermission('leavetype manage')) : ?>
            <a href="<?php echo e(route('leavetype.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((Request::route()->getName() == 'leavetype.index' ? 'active' : '')); ?>"><?php echo e(__('Leave Type')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        <?php endif; // app('laratrust')->permission ?>

        <?php if (app('laratrust')->hasPermission('awardtype manage')) : ?>
            <a href="<?php echo e(route('awardtype.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((request()->is('awardtype*') ? 'active' : '')); ?>"><?php echo e(__('Award Type')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        <?php endif; // app('laratrust')->permission ?>

        <?php if (app('laratrust')->hasPermission('terminationtype manage')) : ?>
            <a href="<?php echo e(route('terminationtype.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((request()->is('terminationtype*') ? 'active' : '')); ?>"><?php echo e(__('Termination Type')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        <?php endif; // app('laratrust')->permission ?>

        <?php if(module_is_active('Performance')): ?>
            <?php if (app('laratrust')->hasPermission('performancetype manage')) : ?>
                    <a href="<?php echo e(route('performanceType.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e(request()->is('performanceType*') ? 'active' : ''); ?>"><?php echo e(__('Performance Type')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
            <?php endif; // app('laratrust')->permission ?>

            <?php if (app('laratrust')->hasPermission('goal type manage')) : ?>
                    <a href="<?php echo e(route('goaltype.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((request()->is('goaltype*') ? 'active' : '')); ?>"><?php echo e(__('Goal Type')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
            <?php endif; // app('laratrust')->permission ?>
        <?php endif; ?>

        <?php if(module_is_active('Training')): ?>
            <?php if (app('laratrust')->hasPermission('trainingtype manage')) : ?>
                <a href="<?php echo e(route('trainingtype.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((request()->is('trainingtype*') ? 'active' : '')); ?>"><?php echo e(__('Training Type')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
            <?php endif; // app('laratrust')->permission ?>
        <?php endif; ?>

        <?php if(module_is_active('Recruitment')): ?>
            <?php if (app('laratrust')->hasPermission('jobcategory manage')) : ?>
                <a href="<?php echo e(route('job-category.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((request()->is('job-category*') ? 'active' : '')); ?>"><?php echo e(__('Job Category')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
            <?php endif; // app('laratrust')->permission ?>

            <?php if (app('laratrust')->hasPermission('jobstage manage')) : ?>
                <a href="<?php echo e(route('job-stage.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((request()->is('job-stage*') ? 'active' : '')); ?>"><?php echo e(__('Job Stage')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
            <?php endif; // app('laratrust')->permission ?>
        <?php endif; ?>

        <?php if(module_is_active('Performance')): ?>
            <?php if (app('laratrust')->hasPermission('competencies manage')) : ?>
                <a href="<?php echo e(route('competencies.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e(request()->is('competencies*') ? 'active' : ''); ?>"><?php echo e(__('Competencies')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
            <?php endif; // app('laratrust')->permission ?>
        <?php endif; ?>
        
        <?php if (app('laratrust')->hasPermission('tax bracket manage')) : ?>
            <a href="<?php echo e(route('taxbracket.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((request()->is('taxbracket*') ? 'active' : '')); ?>"><?php echo e(__('Tax Brackets')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        <?php endif; // app('laratrust')->permission ?>
        
        <?php if (app('laratrust')->hasPermission('tax rebate manage')) : ?>
            <a href="<?php echo e(route('taxrebate.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((request()->is('taxrebate*') ? 'active' : '')); ?>"><?php echo e(__('Tax Rebates')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        <?php endif; // app('laratrust')->permission ?>
        
        <?php if (app('laratrust')->hasPermission('tax threshold manage')) : ?>
            <a href="<?php echo e(route('taxthreshold.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((request()->is('taxthreshold*') ? 'active' : '')); ?>"><?php echo e(__('Tax Thresholds')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        <?php endif; // app('laratrust')->permission ?>
        
        <?php if (app('laratrust')->hasPermission('allowance tax manage')) : ?>
            <a href="<?php echo e(route('allowancetax.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((request()->is('allowancetax*') ? 'active' : '')); ?>"><?php echo e(__('Allowance Tax')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        <?php endif; // app('laratrust')->permission ?>
    </div>
</div>
<?php /**PATH /opt/lampp/htdocs/logistics/Modules/Hrm/Resources/views/layouts/hrm_setup.blade.php ENDPATH**/ ?>