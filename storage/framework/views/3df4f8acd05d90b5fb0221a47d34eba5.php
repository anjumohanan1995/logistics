<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Manage Items')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
<?php echo e(__('Items')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-action'); ?>
<?php if (app('laratrust')->hasPermission('product&service create')) : ?>
<div>
        <?php echo $__env->yieldPushContent('addButtonHook'); ?>
        <?php if (app('laratrust')->hasPermission('product&service import')) : ?>
            <a href="#"  class="btn btn-sm btn-primary" data-ajax-popup="true" data-title="<?php echo e(__('Product & Service Import')); ?>" data-url="<?php echo e(route('product-service.file.import')); ?>"  data-toggle="tooltip" title="<?php echo e(__('Import')); ?>"><i class="ti ti-file-import"></i>
            </a>
        <?php endif; // app('laratrust')->permission ?>
        <a href="<?php echo e(route('product-service.grid')); ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-title="<?php echo e(__('Grid View')); ?>" title="<?php echo e(__('Grid View')); ?>"><i class="ti ti-layout-grid text-white"></i></a>

        <a href="<?php echo e(route('category.index')); ?>"data-size="md"  class="btn btn-sm btn-primary" data-bs-toggle="tooltip"data-title="<?php echo e(__('Setup')); ?>" title="<?php echo e(__('Setup')); ?>"><i class="ti ti-settings"></i></a>

        <a href="<?php echo e(route('productstock.index')); ?>"data-size="md"  class="btn btn-sm btn-primary" data-bs-toggle="tooltip"data-title="<?php echo e(__(' Product Stock')); ?>" title="<?php echo e(__('Product Stock')); ?>"><i class="ti ti-shopping-cart"></i></a>

        <a href="<?php echo e(route('product-service.create')); ?>" class="btn btn-sm btn-primary btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" data-title="<?php echo e(__('Create New Product')); ?>" title="<?php echo e(__('Create')); ?>"><i class="ti ti-plus text-white"></i></a>


    </div>
<?php endif; // app('laratrust')->permission ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class=" multi-collapse mt-2" id="multiCollapseExample1">
            <div class="card">
                <div class="card-body">
                    <?php echo e(Form::open(['route' => ['product-service.index'], 'method' => 'GET', 'id' => 'product_service'])); ?>

                    <div class="row align-items-center justify-content-end">
                        <div class="col-xl-6">
                            <div class="row">

                                    <div class="col-xl-6 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            <?php echo e(Form::label('item_type', __('Item'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::select('item_type', $product_type, isset($_GET['item_type']) ? $_GET['item_type'] : '', ['class' => 'form-control ', 'placeholder' => 'Select Item Type'])); ?>

                                        </div>
                                    </div>

                                <div class="col-xl-6 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="btn-box">
                                        <?php echo e(Form::label('category', __('Category'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::select('category', $category, isset($_GET['category']) ? $_GET['category'] : '', ['class' => 'form-control ', 'placeholder' => 'Select Category'])); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto mt-4">
                            <div class="row">
                                <div class="col-auto">
                                    <a  class="btn btn-sm btn-primary"
                                        onclick="document.getElementById('product_service').submit(); return false;"
                                        data-bs-toggle="tooltip" title="<?php echo e(__('Apply')); ?>"
                                        data-original-title="<?php echo e(__('apply')); ?>">
                                        <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                    </a>
                                    <a href="<?php echo e(route('product-service.index')); ?>" class="btn btn-sm btn-danger "
                                        data-bs-toggle="tooltip" title="<?php echo e(__('Reset')); ?>"
                                        data-original-title="<?php echo e(__('Reset')); ?>">
                                        <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off "></i></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body table-border-style">
                <h5></h5>
                <div class="table-responsive">
                    <table class="table mb-0 pc-dt-simple" id="products">
                        <thead>
                        <tr>
                            <th ><?php echo e(__('Image')); ?></th>
                            <th ><?php echo e(__('Name')); ?></th>
                            <th ><?php echo e(__('Sku')); ?></th>
                            <th><?php echo e(__('Sale Price')); ?></th>
                            <th><?php echo e(__('Purchase Price')); ?></th>
                            <th><?php echo e(__('Tax')); ?></th>
                            <th><?php echo e(__('Category')); ?></th>
                            <th><?php echo e(__('Unit')); ?></th>
                            <th><?php echo e(__('Quantity')); ?></th>
                            <th><?php echo e(__('Type')); ?></th>
                            <?php if(Laratrust::hasPermission('product&service delete') || Laratrust::hasPermission('product&service edit')): ?>
                                <th><?php echo e(__('Action')); ?></th>
                            <?php endif; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $productServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productService): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                if(check_file($productService->image) == false){
                                    $path = asset('Modules/ProductService/Resources/assets/image/img01.jpg');
                                }else{
                                    $path = get_file($productService->image);
                                }
                            ?>
                            <tr class="font-style">
                                <td>
                                    <a href="<?php echo e($path); ?>" target="_blank">
                                        <img src=" <?php echo e($path); ?> " class="wid-75 rounded me-3">
                                    </a>
                                </td>
                                <td class="text-center"><?php echo e($productService->name); ?></td>
                                <td class="text-center"><?php echo e($productService->sku); ?></td>
                                <td><?php echo e(currency_format_with_sym($productService->sale_price)); ?></td>
                                <td><?php echo e(currency_format_with_sym($productService->purchase_price )); ?></td>
                                <td>
                                    <?php echo str_replace(',', ',<br>', $productService->tax_names); ?>

                                </td>
                                <td><?php echo e(optional($productService->categorys)->name?? ''); ?></td>
                                <td><?php echo e(optional($productService->units)->name ??''); ?></td>
                                <?php if($productService->type == 'product' || $productService->type == 'parts'): ?>
                                    <td><?php echo e($productService->quantity); ?></td>
                                <?php else: ?>
                                    <td>-</td>
                                <?php endif; ?>
                                <td><?php echo e($productService->type); ?></td>
                                <?php if(Laratrust::hasPermission('product&service delete') || Laratrust::hasPermission('product&service edit')): ?>
                                   <td class="Action">
                                      <?php if (app('laratrust')->hasPermission('product&service edit')) : ?>
                                        <div class="action-btn bg-warning ms-2">
                                            <a class="mx-3 btn btn-sm  align-items-center"
                                                href="<?php echo e(route('product-service.show', $productService->id)); ?>" data-size="md"
                                                data-bs-toggle="tooltip"
                                                title="<?php echo e(__('View')); ?>">
                                                <i class="ti ti-eye text-white"></i>
                                            </a>
                                        </div>
                                        <?php endif; // app('laratrust')->permission ?>
                                        <?php if (app('laratrust')->hasPermission('product&service edit')) : ?>

                                            <div class="action-btn bg-info ms-2">
                                                <a href="<?php echo e(route('product-service.edit', $productService->id)); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>"> <span class="text-white"> <i class="ti ti-pencil"></i></span></a>
                                            </div>

                                        <?php endif; // app('laratrust')->permission ?>
                                        <?php if (app('laratrust')->hasPermission('product&service delete')) : ?>
                                            <div class="action-btn bg-danger ms-2">
                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['product-service.destroy', $productService->id],'id'=>'delete-form-'.$productService->id]); ?>

                                                <a  class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm" data-bs-toggle="tooltip" title="<?php echo e(__('Delete')); ?>" data-text="<?php echo e(__('Are you sure you want to proceed? This action cannot be undone, and it will delete all associated data.')); ?>"><i class="ti ti-trash text-white text-white"></i></a>
                                                <?php echo Form::close(); ?>

                                            </div>
                                        <?php endif; // app('laratrust')->permission ?>
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

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/logistics/Modules/ProductService/Resources/views/index.blade.php ENDPATH**/ ?>