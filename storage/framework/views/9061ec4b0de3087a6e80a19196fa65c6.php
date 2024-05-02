<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Add-on Manager')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
<?php echo e(__('Add-on Manager')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
<style>
    .system-version h5{
        position: absolute;
        bottom: -44px;
        right: 27px;
    }
    .center-text{
        display: flex;
        flex-direction: column;
    }
    .center-text .text-primary{
        font-size: 14px;
        margin-top: 5px;
    }
    .theme-main{
        display: flex;
        align-items: center;
    }
    .theme-main .theme-avtar{
        margin-right: 15px;
    }
    @media only screen and (max-width: 575px) {
        .system-version h5{
            position: unset;
            margin-bottom: 0px;
        }
        .system-version{
            text-align: center;
            margin-bottom: -22px;
        }
    }
</style>

<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-action'); ?>
<div>
    <a href="<?php echo e(route('module.add')); ?>" class="btn btn-sm btn-primary"  data-bs-toggle="tooltip" title="" data-bs-original-title="<?php echo e(__('ModuleSetup')); ?>">
          <i class="ti ti-plus"></i>
    </a>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row justify-content-center px-0">
    <div class=" col-12">
        <div class="card">
            <div class="card-body package-card-inner  d-flex align-items-center">
                <div class="package-itm theme-avtar">
                    <a href="https://workdo.io/product-category/dash-saas-addon/?utm_source=dash-main-file&utm_medium=superadmin&utm_campaign=plan-btn-all" target="new">
                        <img src="https://workdo.io/wp-content/uploads/2023/03/favicon.jpg" alt="">
                    </a>
                </div>
                <div class="package-content flex-grow-1  px-3">
                    <h4><?php echo e(__('Buy More Add-on')); ?></h4>
                    <div class="text-muted"><?php echo e(__('+'.count($modules).' Premium Add-on')); ?></div>
                </div>
                <div class="price text-end">
                  <a class="btn btn-primary" href="https://workdo.io/product-category/dash-saas-addon/?utm_source=dash-main-file&utm_medium=superadmin&utm_campaign=plan-btn-all" target="new">
                    <?php echo e(__('Buy More Add-on')); ?>

                  </a>
                </div>
            </div>
        </div>
    </div>
    <!-- [ sample-page ] start -->
    <div class="event-cards row px-0">
        <h2><?php echo e(__('Installed Add-on')); ?></h2>
        <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $module_name = $module->getName();
                $id = strtolower(preg_replace('/\s+/', '_', $module_name));
                $path =$module->getPath().'/module.json';
                $json = json_decode(file_get_contents($path), true);
            ?>
            <?php if(!isset($json['display']) || $json['display'] == true || ($module_name == 'GoogleCaptcha')): ?>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 product-card ">
                <div class="card <?php echo e(($module->isEnabled()) ? 'enable_module' : 'disable_module'); ?>">
                    <div class="product-img">
                        <div class="theme-main">
                            <div class="theme-avtar">
                                <img src="<?php echo e(get_module_img($module->getName())); ?>"
                                    alt="<?php echo e($module->getName()); ?>" class="img-user"
                                    style="max-width: 100%">
                            </div>
                            <div class="center-text">
                                <small class="text-muted">
                                    <?php if($module->isEnabled()): ?>
                                    <span class="badge bg-success"><?php echo e(__('Enable')); ?></span>
                                    <?php else: ?>
                                    <span class="badge bg-danger"><?php echo e(__('Disable')); ?></span>
                                    <?php endif; ?>
                                </small>
                                <small class="text-primary"><?php echo e(__('V')); ?><?php echo e(sprintf("%.1f", $json['version'])); ?></small>
                            </div>
                        </div>
                        <div class="checkbox-custom">
                            <div class="btn-group card-option">
                                <button type="button" class="btn p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" style="">
                                    <?php if($module->isEnabled()): ?>
                                    <a href="#!" class="dropdown-item module_change" data-id="<?php echo e($id); ?>">
                                        <span><?php echo e(__('Disable')); ?></span>
                                    </a>
                                    <?php else: ?>
                                    <a href="#!" class="dropdown-item module_change" data-id="<?php echo e($id); ?>">
                                        <span><?php echo e(__('Enable')); ?></span>
                                    </a>
                                    <?php endif; ?>
                                    <form action="<?php echo e(route('module.enable')); ?>" method="POST" id="form_<?php echo e($id); ?>">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="name" value="<?php echo e($module->getName()); ?>">
                                    </form>
                                    <form action="<?php echo e(route('module.remove', $module->getName())); ?>" method="POST" id="form_<?php echo e($id); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button type="button" class="dropdown-item show_confirm" data-confirm="<?php echo e(__('Are You Sure?')); ?>" data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"  data-confirm-yes="delete-form-<?php echo e($id); ?>">
                                            <span class="text-danger"><?php echo e(__("Remove")); ?></span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product-content">
                        <h4 class="text-capitalize"> <?php echo e(Module_Alias_Name($module->getName())); ?></h4>
                        <p class="text-muted text-sm mb-0">
                            <?php echo e(isset($json['description']) ? $json['description'] : ''); ?>

                        </p>
                        <a href="<?php echo e(route('software.details',Module_Alias_Name($module->getName()))); ?>" target="_new" class="btn  btn-outline-secondary w-100 mt-2"><?php echo e(__('View Details')); ?></a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <h2><?php echo e(__('Explore Add-on')); ?></h2>

        <div class="col-xl-12">
            <?php $__currentLoopData = $category_wise_add_ons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category_wise_add_on): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div id="tab-<?php echo e($key); ?>" class="card add_on_manager">
                <div class="card-header " >
                    <h5><?php echo e($category_wise_add_on['name']); ?></h5>
                    <small class="text-muted"><?php echo e($category_wise_add_on['description']); ?></small>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php $__currentLoopData = $category_wise_add_on['add_ons']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $add_on): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <div class="col-xxl-3 col-lg-4 col-sm-6 product-card ">
                                <a href="<?php echo e($add_on['url']); ?>" target="_new">
                                <div class="card enable_module manager-card" >
                                    <div class="product-img">
                                        <div class="theme-main">
                                            <div class="theme-avtar">
                                                <img src="<?php echo e($add_on['image']); ?>"
                                                    alt="" class="img-user"
                                                    style="max-width: 100%">
                                            </div>
                                        </div>
                                        <h5 class="text-capitalize"> <?php echo e($add_on['name']); ?></h5>
                                    </div>
                                    <div class="product-content">
                                        <button class="btn btn-outline-secondary w-100 "><?php echo e(__('View Details')); ?></button>
                                    </div>
                                </div>
                            </a>
                            </div>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <!-- [ sample-page ] end -->
</div>
<div class="system-version">
    <?php
       $version = config('verification.system_version');
    ?>
    <h5 class="text-muted"><?php echo e((!empty($version) ? 'V'.$version : '')); ?></h5>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function () {
    setTimeout(function() {
        $('#dash-layout-tab .show .dash-item').removeClass('active').each(function(index) {
            var href = '#tab-' + index;
            $(this).find('a').prop('href', href);
        });
    }, 100);
});

$(document).on('click','.module_change',function(){
    var id = $(this).attr('data-id');
    $('#form_'+id).submit();
});
</script>
<script>
    if ($('#useradd-sidenav').length > 0) {
       var scrollSpy = new bootstrap.ScrollSpy(document.body, {
           target: '#useradd-sidenav',
           offset: 300
       })
   }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/logistics/resources/views/module/index.blade.php ENDPATH**/ ?>