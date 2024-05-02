<?php if (app('laratrust')->hasPermission('hrm manage')) : ?>
    <div class="card" id="hrm-sidenav">
        <?php echo e(Form::open(['route' => 'hrm.setting.store', 'id' => 'hrm_setting_store'])); ?>

        <div class="card-header">
            <div class="row">
                <div class="col-lg-10 col-md-10 col-sm-10">
                    <h5 class=""><?php echo e(__('HRM Settings')); ?></h5>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row mt-2">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="employee_prefix" class="form-label"><?php echo e(__('Employee Prefix')); ?></label>
                        <input type="text" name="employee_prefix" class="form-control"
                            placeholder="<?php echo e(__('Employee Prefix')); ?>"
                            value="<?php echo e(!empty($settings['employee_prefix']) ? $settings['employee_prefix'] : '#EMP000'); ?>"
                            id="employee_prefix">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="company_start_time" class="form-label"><?php echo e(__('Company Start Time')); ?></label>
                        <input type="time" name="company_start_time" class="form-control"
                            value="<?php echo e(!empty($settings['company_start_time']) ? $settings['company_start_time'] : '09:00'); ?>"
                            id="company_start_time">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="company_end_time" class="form-label"><?php echo e(__('Company End Time')); ?></label>
                        <input type="time" name="company_end_time" class="form-control"
                            value="<?php echo e(!empty($settings['company_end_time']) ? $settings['company_end_time'] : '18:00'); ?>"
                            id="company_end_time">
                    </div>
                </div>

                <?php if(Auth::user()->isAbleTo('ip restrict manage')): ?>
                    <div class="col-md-4">
                        <div class="form-group col">
                            <div class=" form-switch p-0">
                                <?php echo e(Form::label('ip_restrict', __('IP Restrict'), ['class' => ' col-form-label py-0'])); ?>

                                <div class=" float-end">
                                    <input type="checkbox" class="form-check-input" id="ip_restrict"
                                    name="ip_restrict"
                                    <?php echo e((isset($settings['ip_restrict']) && $settings['ip_restrict'] == 'on') ? 'checked' : ''); ?> />
                                    <label class="form-check-label form-label" for="ip_restrict"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php echo e(Form::close()); ?>


            </div>
        </div>
        <div class="card-footer text-end">
            <input class="btn btn-print-invoice  btn-primary m-r-10 hrm_setting_btn" type="button"
                value="<?php echo e(__('Save Changes')); ?>">
        </div>
    </div>

    <div class="ip_restrict_div <?php echo e(!empty($settings['ip_restrict']) && $settings['ip_restrict'] != 'on' ? ' d-none ' : ''); ?>" id="ip_restrict">
        <div class="card">
            <?php if(Auth::user()->isAbleTo('ip restrict create')): ?>
                <div class="card-header d-flex justify-content-between">
                    <h5><?php echo e(__('IP Restriction Settings')); ?></h5>
                    <a data-url="<?php echo e(route('iprestrict.create')); ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                        data-bs-original-title="<?php echo e(__('Create New IP')); ?>" data-bs-placement="top" data-size="md"
                        data-ajax-popup="true" data-title="<?php echo e(__('Create New IP')); ?>">
                        <i class="ti ti-plus"></i>
                    </a>
                </div>
            <?php endif; ?>
            <div class="table-border-style">
                <div class="card-body" style="max-height: 290px; overflow:auto">
                    <div class="table-responsive">
                        <table class="table" id="pc-dt-simple">
                            <thead>
                                <tr>
                                    <th class="w-75"> <?php echo e(__('IP')); ?></th>
                                    <th width="200px"> <?php echo e('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $ips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="Action">
                                        <td class="sorting_1"><?php echo e($ip->ip); ?></td>
                                        <td class="">
                                            <?php if (app('laratrust')->hasPermission('ip restrict edit')) : ?>
                                                <div class="action-btn bg-info ms-2">
                                                    <a class="mx-3 btn btn-sm  align-items-center"
                                                        data-url="<?php echo e(route('iprestrict.edit', $ip->id)); ?>" data-size="md"
                                                        data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Edit')); ?>"
                                                        data-bs-placement="top" data-ajax-popup="true"
                                                        data-title="<?php echo e(__('Edit IP')); ?>" class="edit-icon"
                                                        data-original-title="<?php echo e(__('Edit')); ?>"><i
                                                            class="ti ti-pencil text-white"></i></a>
                                                </div>
                                            <?php endif; // app('laratrust')->permission ?>
                                            <?php if (app('laratrust')->hasPermission('ip restrict delete')) : ?>
                                                <div class="action-btn bg-danger ms-2">
                                                    <?php echo e(Form::open(['method' => 'DELETE', 'route' => ['iprestrict.destroy', $ip->id], 'class' => 'm-0'])); ?>


                                                    <a class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm"
                                                        data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                                                        aria-label="Delete" data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                        data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                        data-confirm-yes="delete-form-<?php echo e($ip->id); ?>"><i
                                                            class="ti ti-trash text-white text-white"></i></a>
                                                    <?php echo e(Form::close()); ?>

                                                </div>
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

<?php endif; // app('laratrust')->permission ?>
<?php if(module_is_active('Recruitment')): ?>
    <?php if (app('laratrust')->hasPermission('letter offer manage')) : ?>
        <div class="" id="offer-letter-settings">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5><?php echo e(__('Offer Letter Settings')); ?></h5>
                    <div class="d-flex justify-content-end drp-languages">
                        <?php if(module_is_active('AIAssistant')): ?>
                            <?php echo $__env->make('aiassistant::ai.generate_ai_btn', [
                                'template_module' => 'offer letter settings',
                                'module' => 'Recruitment',
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endif; ?>
                        <ul class="list-unstyled mb-0 m-2">
                            <li class="dropdown dash-h-item drp-language" style="margin-top: -19px;">
                                <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                                    role="button" aria-haspopup="false" aria-expanded="false" id="dropdownLanguage">
                                    <span class="drp-text hide-mob text-primary">
                                        <?php echo e(Str::upper($offerlang)); ?>

                                    </span>
                                    <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                                </a>
                                <div class="dropdown-menu dash-h-dropdown dropdown-menu-end"
                                    aria-labelledby="dropdownLanguage">
                                    <?php $__currentLoopData = languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $offerlangs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="<?php echo e(route('settings.index', ['noclangs' => $noclang, 'explangs' => $explang, 'joininglangs' => $joininglang, 'offerlangs' => $key])); ?>"
                                            class="dropdown-item ms-1 <?php echo e($key == $offerlang ? 'text-primary' : ''); ?>"><?php echo e(Str::ucfirst($offerlangs)); ?></a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body ">
                    <h5 class="font-weight-bold pb-3"><?php echo e(__('Placeholders')); ?></h5>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header card-body">
                                <div class="row text-xs">
                                    <div class="row">
                                        <p class="col-4"><?php echo e(__('Applicant Name')); ?> : <span
                                                class="pull-end text-primary">{applicant_name}</span></p>
                                        <p class="col-4"><?php echo e(__('Company Name')); ?> : <span
                                                class="pull-right text-primary">{app_name}</span></p>
                                        <p class="col-4"><?php echo e(__('Job title')); ?> : <span
                                                class="pull-right text-primary">{job_title}</span></p>
                                        <p class="col-4"><?php echo e(__('Job type')); ?> : <span
                                                class="pull-right text-primary">{job_type}</span></p>
                                        <p class="col-4"><?php echo e(__('Proposed Start Date')); ?> : <span
                                                class="pull-right text-primary">{start_date}</span></p>
                                        <p class="col-4"><?php echo e(__('Working Location')); ?> : <span
                                                class="pull-right text-primary">{workplace_location}</span></p>
                                        <p class="col-4"><?php echo e(__('Days Of Week')); ?> : <span
                                                class="pull-right text-primary">{days_of_week}</span></p>
                                        <p class="col-4"><?php echo e(__('Salary')); ?> : <span
                                                class="pull-right text-primary">{salary}</span></p>
                                        <p class="col-4"><?php echo e(__('Salary Type')); ?> : <span
                                                class="pull-right text-primary">{salary_type}</span></p>
                                        <p class="col-4"><?php echo e(__('Salary Duration')); ?> : <span
                                                class="pull-end text-primary">{salary_duration}</span></p>
                                        <p class="col-4"><?php echo e(__('Offer Expiration Date')); ?> : <span
                                                class="pull-right text-primary">{offer_expiration_date}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-border-style ">

                    <?php echo e(Form::open(['route' => ['offerlatter.update', $offerlang], 'method' => 'post'])); ?>

                    <div class="form-group col-12">
                        <?php echo e(Form::label('offer_content', __(' Format'), ['class' => 'form-label text-dark'])); ?>

                        <textarea name="offer_content"
                            class="form-control summernote  <?php echo e(!empty($errors->first('offer_content')) ? 'is-invalid' : ''); ?>" required
                            id="offer_content"><?php echo isset($currOfferletterLang->content) ? $currOfferletterLang->content : ''; ?></textarea>
                    </div>
                    <div class="card-footer text-end">

                        <?php echo e(Form::submit(__('Save Changes'), ['class' => 'btn  btn-primary'])); ?>

                    </div>

                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
        <div id="recruitment-print-settings" class="card">
            <div class="card-header">
                <h5><?php echo e(__('Recruitment Print Settings')); ?></h5>
                <small class="text-muted"><?php echo e(__('Edit your Company Job details')); ?></small>
            </div>
            <div class="bg-none">
                <div class="row company-setting">
                    <form id="setting-form" method="post" action="<?php echo e(route('job.template.setting')); ?>"
                        enctype ="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card-header card-body">
                                    <div class="form-group">
                                        <?php echo e(Form::label('job_template', __('Job Template'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::select('job_template', Modules\Recruitment\Entities\JobCandidate::templateData()['templates'], !empty($settings['job_template']) ? $settings['job_template'] : null, ['class' => 'form-control', 'required' => 'required'])); ?>

                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label"><?php echo e(__('Color Input')); ?></label>
                                        <div class="row gutters-xs">
                                            <?php $__currentLoopData = Modules\Recruitment\Entities\JobCandidate::templateData()['colors']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="col-auto">
                                                    <label class="colorinput">
                                                        <input name="job_color" type="radio" value="<?php echo e($color); ?>"
                                                            class="colorinput-input"
                                                            <?php echo e(!empty($settings['job_color']) && $settings['job_color'] == $color ? 'checked' : ''); ?>>
                                                        <span class="colorinput-color"
                                                            style="background: #<?php echo e($color); ?>"></span>
                                                    </label>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label"><?php echo e(__('Job Image')); ?></label>
                                        <div class="choose-files mt-5 ">
                                            <label for="job_logo">
                                                <div class=" bg-primary "> <i
                                                        class="ti ti-upload px-1"></i><?php echo e(__('Choose file here')); ?></div>
                                                <img id="blah7" class="mt-3" src="" width="70%" />
                                                <input type="file" class="form-control file" name="job_logo" id="job_logo"
                                                    data-filename="job_logo_update"
                                                    onchange="document.getElementById('blah7').src = window.URL.createObjectURL(this.files[0])">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group mt-2 text-end">
                                        <input type="submit" value="<?php echo e(__('Save Changes')); ?>"
                                            class="btn btn-print-invoice  btn-primary m-r-10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <?php if(!empty($settings['job_template']) && !empty($settings['job_color'])): ?>
                                    <iframe id="job_frame" class="w-100 h-100" frameborder="0"
                                        src="<?php echo e(route('job.preview', [$settings['job_template'], $settings['job_color']])); ?>"></iframe>
                                <?php else: ?>
                                    <iframe id="job_frame" class="w-100 h-100" frameborder="0"
                                        src="<?php echo e(route('job.preview', ['template1', 'fffff'])); ?>"></iframe>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; // app('laratrust')->permission ?>
<?php endif; ?>
<?php if (app('laratrust')->hasPermission('letter joining manage')) : ?>
    <div class="" id="joining-letter-settings">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5><?php echo e(__('Joining Letter Settings')); ?></h5>
                <div class="d-flex justify-content-end drp-languages">
                    <?php if(module_is_active('AIAssistant')): ?>
                        <?php echo $__env->make('aiassistant::ai.generate_ai_btn', [
                            'template_module' => 'joining letter settings',
                            'module' => 'Hrm',
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                    <ul class="list-unstyled mb-0 m-2">
                        <li class="dropdown dash-h-item drp-language" style="margin-top: -19px;">
                            <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                                role="button" aria-haspopup="false" aria-expanded="false" id="dropdownLanguage1">
                                <span class="drp-text hide-mob text-primary">

                                    <?php echo e(Str::upper($joininglang)); ?>

                                </span>
                                <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                            </a>
                            <div class="dropdown-menu dash-h-dropdown dropdown-menu-end"
                                aria-labelledby="dropdownLanguage1">
                                <?php $__currentLoopData = languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $joininglangs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e(route('settings.index', ['noclangs' => $noclang, 'explangs' => $explang, 'joininglangs' => $key, 'offerlangs' => $offerlang])); ?>"
                                        class="dropdown-item <?php echo e($key == $joininglang ? 'text-primary' : ''); ?>"><?php echo e(Str::ucfirst($joininglangs)); ?></a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </li>

                    </ul>
                </div>

            </div>
            <div class="card-body ">
                <h5 class="font-weight-bold pb-3"><?php echo e(__('Placeholders')); ?></h5>

                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header card-body">
                            <div class="row text-xs">
                                <div class="row">
                                    <p class="col-4"><?php echo e(__('Applicant Name')); ?> : <span
                                            class="pull-end text-primary">{date}</span></p>
                                    <p class="col-4"><?php echo e(__('Company Name')); ?> : <span
                                            class="pull-right text-primary">{app_name}</span></p>
                                    <p class="col-4"><?php echo e(__('Employee Name')); ?> : <span
                                            class="pull-right text-primary">{employee_name}</span></p>
                                    <p class="col-4"><?php echo e(__('Address')); ?> : <span
                                            class="pull-right text-primary">{address}</span></p>
                                    <p class="col-4"><?php echo e(__('Designation')); ?> : <span
                                            class="pull-right text-primary">{designation}</span></p>
                                    <p class="col-4"><?php echo e(__('Start Date')); ?> : <span
                                            class="pull-right text-primary">{start_date}</span></p>
                                    <p class="col-4"><?php echo e(__('Branch')); ?> : <span
                                            class="pull-right text-primary">{branch}</span></p>
                                    <p class="col-4"><?php echo e(__('Start Time')); ?> : <span
                                            class="pull-end text-primary">{start_time}</span></p>
                                    <p class="col-4"><?php echo e(__('End Time')); ?> : <span
                                            class="pull-right text-primary">{end_time}</span></p>
                                    <p class="col-4"><?php echo e(__('Number of Hours')); ?> : <span
                                            class="pull-right text-primary">{total_hours}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body table-border-style ">
                <?php echo e(Form::open(['route' => ['joiningletter.update', $joininglang], 'method' => 'post'])); ?>

                <div class="form-group col-12">
                    <?php echo e(Form::label('joining_content', __(' Format'), ['class' => 'form-label text-dark'])); ?>

                    <textarea name="joining_content"
                        class="form-control summernote  <?php echo e(!empty($errors->first('joining_content')) ? 'is-invalid' : ''); ?>" required
                        id="joining_content"><?php echo isset($currjoiningletterLang->content) ? $currjoiningletterLang->content : ''; ?></textarea>
                </div>
                <div class="card-footer text-end">
                    <?php echo e(Form::submit(__('Save Changes'), ['class' => 'btn  btn-primary'])); ?>

                </div>
                <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>
<?php endif; // app('laratrust')->permission ?>
<?php if (app('laratrust')->hasPermission('letter certificate manage')) : ?>
    <div class="" id="experience-certificate-settings">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5><?php echo e(__('Certificate of Experience Settings')); ?></h5>
                <div class="d-flex justify-content-end drp-languages">
                    <?php if(module_is_active('AIAssistant')): ?>
                        <?php echo $__env->make('aiassistant::ai.generate_ai_btn', [
                            'template_module' => 'experience certificate settings',
                            'module' => 'Hrm',
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                    <ul class="list-unstyled mb-0 m-2">
                        <li class="dropdown dash-h-item drp-language" style="margin-top: -19px;">
                            <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                                role="button" aria-haspopup="false" aria-expanded="false" id="dropdownLanguage1">
                                <span class="drp-text hide-mob text-primary">

                                    <?php echo e(Str::upper($explang)); ?>

                                </span>
                                <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                            </a>
                            <div class="dropdown-menu dash-h-dropdown dropdown-menu-end"
                                aria-labelledby="dropdownLanguage1">
                                <?php $__currentLoopData = languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $explangs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e(route('settings.index', ['noclangs' => $noclang, 'explangs' => $key, 'joininglangs' => $joininglang, 'offerlangs' => $offerlang])); ?>"
                                        class="dropdown-item <?php echo e($key == $explang ? 'text-primary' : ''); ?>"><?php echo e(Str::ucfirst($explangs)); ?></a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </li>

                    </ul>
                </div>

            </div>
            <div class="card-body ">
                <h5 class="font-weight-bold pb-3"><?php echo e(__('Placeholders')); ?></h5>

                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header card-body">
                            <div class="row text-xs">
                                <div class="row">
                                    <p class="col-4"><?php echo e(__('Company Name')); ?> : <span
                                            class="pull-right text-primary">{app_name}</span></p>
                                    <p class="col-4"><?php echo e(__('Employee Name')); ?> : <span
                                            class="pull-right text-primary">{employee_name}</span></p>
                                    <p class="col-4"><?php echo e(__('Date of Issuance')); ?> : <span
                                            class="pull-right text-primary">{date}</span></p>
                                    <p class="col-4"><?php echo e(__('Designation')); ?> : <span
                                            class="pull-right text-primary">{designation}</span></p>
                                    <p class="col-4"><?php echo e(__('Start Date')); ?> : <span
                                            class="pull-right text-primary">{start_date}</span></p>
                                    <p class="col-4"><?php echo e(__('Branch')); ?> : <span
                                            class="pull-right text-primary">{branch}</span></p>
                                    <p class="col-4"><?php echo e(__('Start Time')); ?> : <span
                                            class="pull-end text-primary">{start_time}</span></p>
                                    <p class="col-4"><?php echo e(__('End Time')); ?> : <span
                                            class="pull-right text-primary">{end_time}</span></p>
                                    <p class="col-4"><?php echo e(__('Number of Hours')); ?> : <span
                                            class="pull-right text-primary">{total_hours}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body table-border-style ">

                <?php echo e(Form::open(['route' => ['experiencecertificate.update', $explang], 'method' => 'post'])); ?>

                <div class="form-group col-12">
                    <?php echo e(Form::label('experience_content', __(' Format'), ['class' => 'form-label text-dark'])); ?>

                    <textarea name="experience_content"
                        class="form-control summernote  <?php echo e(!empty($errors->first('experience_content')) ? 'is-invalid' : ''); ?>" required
                        id="experience_content"><?php echo isset($curr_exp_cetificate_Lang->content) ? $curr_exp_cetificate_Lang->content : ''; ?></textarea>
                </div>

                <div class="card-footer text-end">

                    <?php echo e(Form::submit(__('Save Changes'), ['class' => 'btn  btn-primary'])); ?>

                </div>

                <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>
<?php endif; // app('laratrust')->permission ?>
<?php if (app('laratrust')->hasPermission('letter noc manage')) : ?>
    <div class="" id="noc-settings">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5><?php echo e(__('No Objection Certificate Settings')); ?></h5>
                <div class="d-flex justify-content-end drp-languages">
                    <?php if(module_is_active('AIAssistant')): ?>
                        <?php echo $__env->make('aiassistant::ai.generate_ai_btn', [
                            'template_module' => 'noc settings',
                            'module' => 'Hrm',
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                    <ul class="list-unstyled mb-0 m-2">
                        <li class="dropdown dash-h-item drp-language" style="margin-top: -19px;">
                            <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                                role="button" aria-haspopup="false" aria-expanded="false" id="dropdownLanguage1">
                                <span class="drp-text hide-mob text-primary">

                                    <?php echo e(Str::upper($noclang)); ?>

                                </span>
                                <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                            </a>
                            <div class="dropdown-menu dash-h-dropdown dropdown-menu-end"
                                aria-labelledby="dropdownLanguage1">
                                <?php $__currentLoopData = languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $noclangs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e(route('settings.index', ['noclangs' => $key, 'explangs' => $explang, 'joininglangs' => $joininglang, 'offerlangs' => $offerlang])); ?>"
                                        class="dropdown-item <?php echo e($key == $noclang ? 'text-primary' : ''); ?>"><?php echo e(Str::ucfirst($noclangs)); ?></a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </li>

                    </ul>
                </div>

            </div>
            <div class="card-body ">
                <h5 class="font-weight-bold pb-3"><?php echo e(__('Placeholders')); ?></h5>

                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header card-body">
                            <div class="row text-xs">
                                <div class="row">
                                    <p class="col-4"><?php echo e(__('Date')); ?> : <span
                                            class="pull-end text-primary">{date}</span></p>
                                    <p class="col-4"><?php echo e(__('Company Name')); ?> : <span
                                            class="pull-right text-primary">{app_name}</span></p>
                                    <p class="col-4"><?php echo e(__('Employee Name')); ?> : <span
                                            class="pull-right text-primary">{employee_name}</span></p>
                                    <p class="col-4"><?php echo e(__('Designation')); ?> : <span
                                            class="pull-right text-primary">{designation}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body table-border-style ">
                <?php echo e(Form::open(['route' => ['noc.update', $noclang], 'method' => 'post'])); ?>

                <div class="form-group col-12">
                    <?php echo e(Form::label('noc_content', __(' Format'), ['class' => 'form-label text-dark'])); ?>

                    <textarea name="noc_content"
                        class="form-control summernote  <?php echo e(!empty($errors->first('noc_content')) ? 'is-invalid' : ''); ?>" required
                        id="noc_content"><?php echo isset($currnocLang->content) ? $currnocLang->content : ''; ?></textarea>
                </div>

                <div class="card-footer text-end">

                    <?php echo e(Form::submit(__('Save Changes'), ['class' => 'btn  btn-primary'])); ?>

                </div>

                <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>
<?php endif; // app('laratrust')->permission ?>
<link rel="stylesheet" href="<?php echo e(asset('Modules/Hrm/Resources/assets/css/custom.css')); ?>">
<script src="<?php echo e(asset('js/custom.js')); ?>"></script>

<script>
    $(".hrm_setting_btn").click(function() {
        $("#hrm_setting_store").submit();
    });
</script>
<script>
    $(document).on('change', '#ip_restrict', function() {
        if ($(this).is(':checked')) {
            $('.ip_restrict_div').removeClass('d-none');

        } else {
            $('.ip_restrict_div').addClass('d-none');

        }
    });
</script>
<script>
    $(document).on("change", "select[name='job_template'], input[name='job_color']", function() {
        var template = $("select[name='job_template']").val();
        var color = $("input[name='job_color']:checked").val();
        $('#job_frame').attr('src', '<?php echo e(url('/job/preview')); ?>/' + template + '/' + color);
    });
</script><?php /**PATH /opt/lampp/htdocs/logistics/Modules/Hrm/Resources/views/company/settings/index.blade.php ENDPATH**/ ?>