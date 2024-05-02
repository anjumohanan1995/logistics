<!--Brand Settings-->
<div id="site-settings" class="">
    <?php echo e(Form::open(['route' => ['company.settings.save'], 'enctype' => 'multipart/form-data', 'id' => 'setting-form'])); ?>

    <?php echo method_field('post'); ?>
    <div class="card">
        <div class="card-header">
            <h5><?php echo e(__('Brand Settings')); ?></h5>
        </div>
        <div class="card-body pb-0">
            <div class="row">
                <div class="col-lg-4 col-12 d-flex">
                    <div class="card w-100">
                        <div class="card-header">
                            <h5 class="small-title"><?php echo e(__('Logo Dark')); ?></h5>
                        </div>
                        <div class="card-body setting-card setting-logo-box p-3">
                            <div class="d-flex flex-column justify-content-between align-items-center h-100">
                                <div class="logo-content img-fluid logo-set-bg  text-center py-2">
                                    <?php
                                        $logo_dark = isset($settings['logo_dark']) ? (check_file($settings['logo_dark']) ? $settings['logo_dark'] : 'uploads/logo/logo_dark.png') : 'uploads/logo/logo_dark.png';
                                    ?>
                                    <img alt="image" src="<?php echo e(get_file($logo_dark)); ?><?php echo e('?' . time()); ?>"
                                        class="small-logo" id="pre_default_logo">
                                </div>
                                <div class="choose-files mt-3">
                                    <label for="logo_dark">
                                        <div class=" bg-primary "> <i
                                                class="ti ti-upload px-1"></i><?php echo e(__('Choose file here')); ?></div>
                                        <input type="file" class="form-control file" name="logo_dark" id="logo_dark"
                                            data-filename="logo_dark"
                                            onchange="document.getElementById('pre_default_logo').src = window.URL.createObjectURL(this.files[0])">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12 d-flex">
                    <div class="card w-100">
                        <div class="card-header">
                            <h5 class="small-title"><?php echo e(__('Logo Light')); ?></h5>
                        </div>
                        <div class="card-body setting-card setting-logo-box p-3">
                            <div class="d-flex flex-column justify-content-between align-items-center h-100">
                                <div class="logo-content img-fluid logo-set-bg text-center py-2">
                                    <?php
                                        $logo_light = isset($settings['logo_light']) ? (check_file($settings['logo_light']) ? $settings['logo_light'] : 'uploads/logo/logo_light.png') : 'uploads/logo/logo_light.png';
                                    ?>
                                    <img alt="image" src="<?php echo e(get_file($logo_light)); ?><?php echo e('?' . time()); ?>"
                                        class="img_setting small-logo" id="landing_page_logo">
                                </div>
                                <div class="choose-files mt-3">
                                    <label for="logo_light">
                                        <div class=" bg-primary "> <i
                                                class="ti ti-upload px-1"></i><?php echo e(__('Choose file here')); ?></div>
                                        <input type="file" class="form-control file" name="logo_light"
                                            id="logo_light" data-filename="logo_light"
                                            onchange="document.getElementById('landing_page_logo').src = window.URL.createObjectURL(this.files[0])">

                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12 d-flex">
                    <div class="card w-100">
                        <div class="card-header">
                            <h5 class="small-title"><?php echo e(__('Favicon')); ?></h5>
                        </div>
                        <div class="card-body setting-card setting-logo-box p-3">
                            <div class="d-flex flex-column justify-content-between align-items-center h-100">
                                <div class="logo-content img-fluid logo-set-bg text-center py-2">
                                    <?php
                                        $favicon = isset($settings['favicon']) ? (check_file($settings['favicon']) ? $settings['favicon'] : 'uploads/logo/favicon.png') : 'uploads/logo/favicon.png';
                                    ?>
                                    <img src="<?php echo e(get_file($favicon)); ?><?php echo e('?' . time()); ?>" class="setting-img"
                                        width="40px" id="img_favicon" />
                                </div>
                                <div class="choose-files mt-3">
                                    <label for="favicon">
                                        <div class=" bg-primary "> <i
                                                class="ti ti-upload px-1"></i><?php echo e(__('Choose file here')); ?></div>
                                        <input type="file" class="form-control file" name="favicon" id="favicon"
                                            data-filename="favicon"
                                            onchange="document.getElementById('img_favicon').src = window.URL.createObjectURL(this.files[0])">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-12">
                    <div class="form-group">
                        <label for="title_text" class="form-label"><?php echo e(__('Title Text')); ?></label>
                        <?php echo e(Form::text('title_text', !empty($settings['title_text']) ? $settings['title_text'] : null, ['class' => 'form-control', 'placeholder' => __('Enter Title Text')])); ?>

                    </div>
                </div>
                <div class="col-sm-6 col-12">
                    <div class="form-group">
                        <label for="footer_text" class="form-label"><?php echo e(__('Footer Text')); ?></label>
                        <?php echo e(Form::text('footer_text', !empty($settings['footer_text']) ? $settings['footer_text'] : null, ['class' => 'form-control', 'placeholder' => __('Enter Footer Text')])); ?>

                    </div>
                </div>
                <div class="row mt-2">
                    <h4 class="small-title"><?php echo e(__('Theme Customizer')); ?></h4>
                    <div class="setting-card setting-logo-box p-3">
                        <div class="row">
                            <div class="col-lg-4 col-xl-4 col-md-4">
                                <h6 class="">
                                    <i class="ti ti-credit-card me-2 h5"></i><?php echo e(__('Primary color settings')); ?>

                                </h6>

                                <hr class="my-2" />
                                <div class="color-wrp">
                                    <div class="theme-color themes-color">
                                        <a href="#!"
                                            class="themes-color-change <?php echo e(isset($settings['color']) && $settings['color'] == 'theme-1' ? 'active_color' : ''); ?>"
                                            data-value="theme-1"></a>
                                        <input type="radio" class="theme_color d-none" name="color"
                                            value="theme-1"<?php echo e(isset($settings['color']) && $settings['color'] == 'theme-1' ? 'checked' : ''); ?>>
                                        <a href="#!"
                                            class="themes-color-change <?php echo e(isset($settings['color']) && $settings['color'] == 'theme-2' ? 'active_color' : ''); ?>"
                                            data-value="theme-2"></a>
                                        <input type="radio" class="theme_color d-none" name="color"
                                            value="theme-2"<?php echo e(isset($settings['color']) && $settings['color'] == 'theme-2' ? 'checked' : ''); ?>>
                                        <a href="#!"
                                            class="themes-color-change <?php echo e(isset($settings['color']) && $settings['color'] == 'theme-3' ? 'active_color' : ''); ?>"
                                            data-value="theme-3"></a>
                                        <input type="radio" class="theme_color d-none" name="color"
                                            value="theme-3"<?php echo e(isset($settings['color']) && $settings['color'] == 'theme-3' ? 'checked' : ''); ?>>
                                        <a href="#!"
                                            class="themes-color-change <?php echo e(isset($settings['color']) && $settings['color'] == 'theme-4' ? 'active_color' : ''); ?>"
                                            data-value="theme-4"></a>
                                        <input type="radio" class="theme_color d-none" name="color"
                                            value="theme-4"<?php echo e(isset($settings['color']) && $settings['color'] == 'theme-4' ? 'checked' : ''); ?>>
                                        <a href="#!"
                                            class="themes-color-change <?php echo e(isset($settings['color']) && $settings['color'] == 'theme-5' ? 'active_color' : ''); ?>"
                                            data-value="theme-5"></a>
                                        <input type="radio" class="theme_color d-none" name="color"
                                            value="theme-5"<?php echo e(isset($settings['color']) && $settings['color'] == 'theme-5' ? 'checked' : ''); ?>>
                                        <br>
                                        <a href="#!"
                                            class="themes-color-change <?php echo e(isset($settings['color']) && $settings['color'] == 'theme-6' ? 'active_color' : ''); ?>"
                                            data-value="theme-6"></a>
                                        <input type="radio" class="theme_color d-none" name="color"
                                            value="theme-6"<?php echo e(isset($settings['color']) && $settings['color'] == 'theme-6' ? 'checked' : ''); ?>>
                                        <a href="#!"
                                            class="themes-color-change <?php echo e(isset($settings['color']) && $settings['color'] == 'theme-7' ? 'active_color' : ''); ?>"
                                            data-value="theme-7"></a>
                                        <input type="radio" class="theme_color d-none" name="color"
                                            value="theme-7"<?php echo e(isset($settings['color']) && $settings['color'] == 'theme-7' ? 'checked' : ''); ?>>
                                        <a href="#!"
                                            class="themes-color-change <?php echo e(isset($settings['color']) && $settings['color'] == 'theme-8' ? 'active_color' : ''); ?>"
                                            data-value="theme-8"></a>
                                        <input type="radio" class="theme_color d-none" name="color"
                                            value="theme-8"<?php echo e(isset($settings['color']) && $settings['color'] == 'theme-8' ? 'checked' : ''); ?>>
                                        <a href="#!"
                                            class="themes-color-change <?php echo e(isset($settings['color']) && $settings['color'] == 'theme-9' ? 'active_color' : ''); ?>"
                                            data-value="theme-9"></a>
                                        <input type="radio" class="theme_color d-none" name="color"
                                            value="theme-9"<?php echo e(isset($settings['color']) && $settings['color'] == 'theme-9' ? 'checked' : ''); ?>>
                                        <a href="#!"
                                            class="themes-color-change <?php echo e(isset($settings['color']) && $settings['color'] == 'theme-10' ? 'active_color' : ''); ?>"
                                            data-value="theme-10"></a>
                                        <input type="radio" class="theme_color d-none" name="color"
                                            value="theme-10"<?php echo e(isset($settings['color']) && $settings['color'] == 'theme-10' ? 'checked' : ''); ?>>
                                    </div>
                                    <div class="color-picker-wrp ">
                                        <input type="color"
                                            value="<?php echo e(isset($settings['color']) ? $settings['color'] : ''); ?>"
                                            class="colorPicker <?php echo e(isset($settings['color_flag']) && $settings['color_flag'] == 'true' ? 'active_color' : ''); ?>"
                                            name="custom_color" id="color-picker">
                                        <input type='hidden' name="color_flag"
                                            value=<?php echo e(isset($settings['color_flag']) && $settings['color_flag'] == 'true' ? 'true' : 'false'); ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-12">
                                <h6>
                                    <i class="ti ti-layout-sidebar me-2 h5"></i> <?php echo e(__('Sidebar settings')); ?>

                                </h6>
                                <hr class="my-2" />
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" id="site_transparent"
                                        name="site_transparent"
                                        <?php echo e(isset($settings['site_transparent']) && $settings['site_transparent'] == 'on' ? 'checked' : ''); ?> />

                                    <label class="form-check-label f-w-600 pl-1"
                                        for="site_transparent"><?php echo e(__('Transparent layout')); ?></label>
                                </div>
                            </div>
                            <div class="col-sm-3 col-12">
                                <h6 class="">
                                    <i class="ti ti-sun me-2 h5"></i><?php echo e(__('Layout settings')); ?>

                                </h6>
                                <hr class=" my-2 " />
                                <div class="form-check form-switch mt-2">

                                    <input type="checkbox" class="form-check-input" id="cust-darklayout"
                                        name="cust_darklayout"
                                        <?php echo e(isset($settings['cust_darklayout']) && $settings['cust_darklayout'] == 'on' ? 'checked' : ''); ?> />
                                    <label class="form-check-label f-w-600 pl-1"
                                        for="cust-darklayout"><?php echo e(__('Dark Layout')); ?></label>

                                </div>
                            </div>
                            <div class="col-sm-2 col-12">
                                <h6 class="">
                                    <i class="ti ti-align-right me-2 h5"></i><?php echo e(__('Enable RTL')); ?>

                                </h6>
                                <hr class=" my-2 " />
                                <div class="form-check form-switch mt-2">

                                    <input type="checkbox" class="form-check-input" id="site_rtl" name="site_rtl"
                                        <?php echo e(isset($settings['site_rtl']) && $settings['site_rtl'] == 'on' ? 'checked' : ''); ?> />
                                    <label class="form-check-label f-w-600 pl-1"
                                        for="site_rtl"><?php echo e(__('RTL Layout')); ?></label>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-footer text-end">
            <input class="btn btn-print-invoice  btn-primary " type="submit" value="<?php echo e(__('Save Changes')); ?>">
        </div>
        <?php echo e(Form::close()); ?>

    </div>
</div>

<!--system settings-->
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="card" id="system-settings">
            <div class="card-header">
                <h5 class="small-title"><?php echo e(__('System Settings')); ?></h5>
            </div>
            <?php echo e(Form::open(['route' => ['company.system.setting.store'], 'id' => 'setting-system-form'])); ?>

            <?php echo method_field('post'); ?>
            <div class="card-body pb-0">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group col switch-width">
                            <?php echo e(Form::label('defult_language', __('Default Language'), ['class' => ' col-form-label'])); ?>

                            <select class="form-control" data-trigger name="defult_language" id="defult_language"
                                placeholder="This is a search placeholder">
                                <?php $__currentLoopData = languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>"
                                        <?php echo e(isset($settings['defult_language']) && $settings['defult_language'] == $key ? 'selected' : ''); ?>>
                                        <?php echo e(Str::ucfirst($language)); ?> </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 col-6">
                        <div class="form-group col switch-width">
                            <?php echo e(Form::label('defult_timezone', __('Default Timezone'), ['class' => ' col-form-label'])); ?>

                            <?php echo e(Form::select('defult_timezone', $timezones, isset($settings['defult_timezone']) ? $settings['defult_timezone'] : null, ['id' => 'timezone', 'class' => 'form-control choices', 'searchEnabled' => 'true'])); ?>

                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="site_date_format" class="form-label"><?php echo e(__('Date Format')); ?></label>
                            <select type="text" name="site_date_format" class="form-control selectric"
                                id="site_date_format">
                                <option value="d-m-Y" <?php if(isset($settings['site_date_format']) && $settings['site_date_format'] == 'd-m-Y'): ?> selected="selected" <?php endif; ?>>
                                    DD-MM-YYYY</option>
                                <option value="m-d-Y" <?php if(isset($settings['site_date_format']) && $settings['site_date_format'] == 'm-d-Y'): ?> selected="selected" <?php endif; ?>>
                                    MM-DD-YYYY</option>
                                <option value="Y-m-d" <?php if(isset($settings['site_date_format']) && $settings['site_date_format'] == 'Y-m-d'): ?> selected="selected" <?php endif; ?>>
                                    YYYY-MM-DD</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="site_time_format" class="form-label"><?php echo e(__('Time Format')); ?></label>
                            <select type="text" name="site_time_format" class="form-control selectric"
                                id="site_time_format">
                                <option value="g:i A" <?php if(isset($settings['site_time_format']) && $settings['site_time_format'] == 'g:i A'): ?> selected="selected" <?php endif; ?>>
                                    10:30 PM</option>
                                <option value="H:i" <?php if(isset($settings['site_time_format']) && $settings['site_time_format'] == 'H:i'): ?> selected="selected" <?php endif; ?>>
                                    22:30</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <input class="btn btn-print-invoice  btn-primary " type="submit" value="<?php echo e(__('Save Changes')); ?>">
            </div>
            <?php echo e(Form::close()); ?>

        </div>
    </div>
</div>


<div class="card" id="company-setting-sidenav">
    <?php echo e(Form::open(['route' => 'company.setting.save'])); ?>

    <div class="card-header">
        <div class="row">
            <div class="col-lg-10 col-md-10 col-sm-10">
                <h5 class=""><?php echo e(__('Company Settings')); ?></h5>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row mt-2">
            <div class="col-md-4">
                <div class="form-group">
                    <?php echo e(Form::label('company_name', __('Company Name'), ['class' => 'form-label'])); ?>

                    <?php echo e(Form::text('company_name', !empty($settings['company_name']) ? $settings['company_name'] : null, ['class' => 'form-control ', 'placeholder' => 'Enter Company Name'])); ?>

                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <?php echo e(Form::label('company_address', __('Address'), ['class' => 'form-label'])); ?>

                    <?php echo e(Form::text('company_address', !empty($settings['company_address']) ? $settings['company_address'] : null, ['class' => 'form-control ', 'placeholder' => 'Enter Address'])); ?>

                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <?php echo e(Form::label('company_city', __('City'), ['class' => 'form-label'])); ?>

                    <?php echo e(Form::text('company_city', !empty($settings['company_city']) ? $settings['company_city'] : null, ['class' => 'form-control ', 'placeholder' => 'Enter City'])); ?>

                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <?php echo e(Form::label('company_state', __('State'), ['class' => 'form-label'])); ?>

                    <?php echo e(Form::text('company_state', !empty($settings['company_state']) ? $settings['company_state'] : null, ['class' => 'form-control ', 'placeholder' => 'Enter State'])); ?>

                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <?php echo e(Form::label('company_country', __('Country'), ['class' => 'form-label'])); ?>

                    <?php echo e(Form::text('company_country', !empty($settings['company_country']) ? $settings['company_country'] : null, ['class' => 'form-control ', 'placeholder' => 'Enter Country'])); ?>

                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <?php echo e(Form::label('company_zipcode', __('Zip/Post Code'), ['class' => 'form-label'])); ?>

                    <?php echo e(Form::text('company_zipcode', !empty($settings['company_zipcode']) ? $settings['company_zipcode'] : null, ['class' => 'form-control ', 'placeholder' => 'Enter Zip/Post Code'])); ?>

                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <?php echo e(Form::label('company_telephone', __('Telephone'), ['class' => 'form-label'])); ?>

                    <?php echo e(Form::text('company_telephone', !empty($settings['company_telephone']) ? $settings['company_telephone'] : null, ['class' => 'form-control ', 'placeholder' => 'Enter Telephone'])); ?>

                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <?php echo e(Form::label('company_email_from_name', __('Email (From Name)'), ['class' => 'form-label'])); ?>

                    <?php echo e(Form::text('company_email_from_name', !empty($settings['company_email_from_name']) ? $settings['company_email_from_name'] : null, ['class' => 'form-control ', 'placeholder' => 'Enter Email From Name'])); ?>

                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <?php echo e(Form::label('registration_number', __('Company Registration Number'), ['class' => 'form-label'])); ?>

                    <?php echo e(Form::text('registration_number', !empty($settings['registration_number']) ? $settings['registration_number'] : null, ['class' => 'form-control ', 'placeholder' => 'Enter Company Registration Number'])); ?>

                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <?php echo e(Form::label('company_email', __('System Email'), ['class' => 'form-label'])); ?>

                    <?php echo e(Form::text('company_email', !empty($settings['company_email']) ? $settings['company_email'] : null, ['class' => 'form-control ', 'placeholder' => 'Enter System Email'])); ?>

                </div>
            </div>
            <div class="col-md-4">
                <label for="vat_gst_number_switch"><?php echo e(__('Tax Number')); ?></label>
                <div class="form-check form-switch custom-switch-v1 float-end">
                    <input type="checkbox" name="vat_gst_number_switch"
                        class="form-check-input input-primary pointer" value="on" id="vat_gst_number_switch"
                        <?php echo e(isset($settings['vat_gst_number_switch']) && $settings['vat_gst_number_switch'] == 'on' ? ' checked ' : ''); ?>>
                    <label class="form-check-label" for="vat_gst_number_switch"></label>
                </div>
            </div>
            <div
                class=" col-md-6 tax_type_div <?php echo e(!isset($settings['vat_gst_number_switch']) || $settings['vat_gst_number_switch'] != 'on' ? 'd-none ' : ''); ?>">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check form-check-inline form-group mb-3">
                                <input type="radio" id="customRadio8" name="tax_type" value="VAT"
                                    class="form-check-input"
                                    <?php echo e(!isset($settings['tax_type']) || $settings['tax_type'] == 'VAT' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="customRadio8"><?php echo e(__('VAT Number')); ?></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-check-inline form-group mb-3">
                                <input type="radio" id="customRadio7" name="tax_type" value="GST"
                                    class="form-check-input"
                                    <?php echo e(isset($settings['tax_type']) && $settings['tax_type'] == 'GST' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="customRadio7"><?php echo e(__('GST Number')); ?></label>
                            </div>
                        </div>
                    </div>
                    <?php echo e(Form::text('vat_number', !empty($settings['vat_number']) ? $settings['vat_number'] : null, ['class' => 'form-control', 'placeholder' => __('Enter VAT / GST Number')])); ?>

                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-end">
        <input class="btn btn-print-invoice  btn-primary m-r-10" type="submit" value="<?php echo e(__('Save Changes')); ?>">
    </div>
    <?php echo e(Form::close()); ?>

</div>

<!--currency settings-->
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="card" id="currency-setting-sidenav">
            <div class="card-header">
                <h5 class="small-title"><?php echo e(__('Currency Settings')); ?></h5>
            </div>
            <?php echo e(Form::open(['route' => ['company.setting.currency.settings'], 'method' => 'post', 'id' => 'setting-currency-form'])); ?>

            <div class="card-body pb-0">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group col switch-width">
                            <?php echo e(Form::label('currency_format', __('Decimal Format'), ['class' => ' col-form-label'])); ?>

                            <select class="form-control currency_note" data-trigger name="currency_format"
                                id="currency_format" placeholder="This is a search placeholder">
                                <option value="0"
                                    <?php echo e(isset($settings['currency_format']) && $settings['currency_format'] == '0' ? 'selected' : ''); ?>>
                                    1</option>
                                <option value="1"
                                    <?php echo e(isset($settings['currency_format']) && $settings['currency_format'] == '1' ? 'selected' : ''); ?>>
                                    1.0</option>
                                <option value="2"
                                    <?php echo e(isset($settings['currency_format']) && $settings['currency_format'] == '2' ? 'selected' : ''); ?>>
                                    1.00</option>
                                <option value="3"
                                    <?php echo e(isset($settings['currency_format']) && $settings['currency_format'] == '3' ? 'selected' : ''); ?>>
                                    1.000</option>
                                <option value="4"
                                    <?php echo e(isset($settings['currency_format']) && $settings['currency_format'] == '4' ? 'selected' : ''); ?>>
                                    1.0000</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group col switch-width">
                            <?php echo e(Form::label('defult_currancy', __('Default Currancy'), ['class' => ' col-form-label'])); ?>

                            <select class="form-control currency_note" data-trigger name="defult_currancy"
                                id="defult_currancy" placeholder="This is a search placeholder">
                                <?php $__currentLoopData = currency(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($c->symbol); ?>-<?php echo e($c->code); ?>"
                                        data-symbol="<?php echo e($c->symbol); ?>"
                                        <?php echo e(isset($settings['defult_currancy']) && $settings['defult_currancy'] == $c->code ? 'selected' : ''); ?>>
                                        <?php echo e($c->symbol); ?> - <?php echo e($c->code); ?> </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <label for="decimal_separator" class="form-label"><?php echo e(__('Decimal Separator')); ?></label>
                        <select type="text" name="decimal_separator" class="form-control selectric currency_note"
                            id="decimal_separator">
                            <option value="dot" <?php if(@$settings['decimal_separator'] == 'dot'): ?> selected="selected" <?php endif; ?>>
                                <?php echo e(__('Dot')); ?></option>
                            <option value="comma" <?php if(@$settings['decimal_separator'] == 'comma'): ?> selected="selected" <?php endif; ?>>
                                <?php echo e(__('Comma')); ?></option>
                        </select>
                    </div>
                    <div class="form-group col-6">
                        <label for="thousand_separator" class="form-label"><?php echo e(__('Thousands Separator')); ?></label>
                        <select type="text" name="thousand_separator"
                            class="form-control selectric currency_note" id="thousand_separator">
                            <option value="dot" <?php if(@$settings['thousand_separator'] == 'dot'): ?> selected="selected" <?php endif; ?>>
                                <?php echo e(__('Dot')); ?></option>
                            <option value="comma" <?php if(@$settings['thousand_separator'] == 'comma'): ?> selected="selected" <?php endif; ?>>
                                <?php echo e(__('Comma')); ?></option>
                        </select>
                    </div>
                    <div class="form-group col-6">
                        <?php echo e(Form::label('currency_space', __('Currency Symbol Space'), ['class' => 'form-label'])); ?>

                        <div class="row ms-1">
                            <div class="form-check col-md-6">
                                <input class="form-check-input currency_note" type="radio"
                                    name="currency_space" value="withspace"
                                    <?php if(!isset($settings['currency_space']) || $settings['currency_space'] == 'withspace'): ?> checked <?php endif; ?> id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    <?php echo e(__('With space')); ?>

                                </label>
                            </div>
                            <div class="form-check col-6">
                                <input class="form-check-input currency_note" type="radio"
                                    name="currency_space" value="withoutspace"
                                    <?php if(!isset($settings['currency_space']) || $settings['currency_space'] == 'withoutspace'): ?> checked <?php endif; ?> id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    <?php echo e(__('Without space')); ?>

                                </label>
                            </div>
                        </div>
                        <?php $__errorArgs = ['currency_space'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-currency_space" role="alert">
                                <strong class="text-danger"><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label"
                                for="example3cols3Input"><?php echo e(__('Currency Symbol Position')); ?></label>
                            <div class="row ms-1">
                                <div class="form-check col-md-6">
                                    <input class="form-check-input currency_note" type="radio"
                                        name="site_currency_symbol_position" value="pre"
                                        <?php if(!isset($settings['site_currency_symbol_position']) || $settings['site_currency_symbol_position'] == 'pre'): ?> checked <?php endif; ?>
                                        id="currencySymbolPosition">
                                    <label class="form-check-label" for="currencySymbolPosition">
                                        <?php echo e(__('Pre')); ?>

                                    </label>
                                </div>
                                <div class="form-check col-md-6">
                                    <input class="form-check-input currency_note" type="radio"
                                        name="site_currency_symbol_position" value="post"
                                        <?php if(isset($settings['site_currency_symbol_position']) && $settings['site_currency_symbol_position'] == 'post'): ?> checked <?php endif; ?> id="currencySymbolPost">
                                    <label class="form-check-label" for="currencySymbolPost">
                                        <?php echo e(__('Post')); ?>

                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label"
                                for="example3cols3Input"><?php echo e(__('Currency Symbol & Name')); ?></label>
                            <div class="row ms-1">
                                <div class="form-check col-md-6">
                                    <input class="form-check-input currency_note" type="radio"
                                        name="site_currency_symbol_name" value="symbol"
                                        <?php if(!isset($settings['site_currency_symbol_name']) || $settings['site_currency_symbol_name'] == 'symbol'): ?> checked <?php endif; ?> id="currencySymbol">
                                    <label class="form-check-label" for="currencySymbol">
                                        <?php echo e(__('With Currency Symbol')); ?>

                                    </label>
                                </div>
                                <div class="form-check col-md-6">
                                    <input class="form-check-input currency_note" type="radio"
                                        name="site_currency_symbol_name" value="symbolname"
                                        <?php if(isset($settings['site_currency_symbol_name']) && $settings['site_currency_symbol_name'] == 'symbolname'): ?> checked <?php endif; ?> id="currencySymbolName">
                                    <label class="form-check-label" for="currencySymbolName">
                                        <?php echo e(__('With Currency Name')); ?>

                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label" for="new_note_value"><?php echo e(__('Preview :')); ?></label>
                            <span id="formatted_price_span"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <input class="btn btn-print-invoice  btn-primary " type="submit" value="<?php echo e(__('Save Changes')); ?>">
            </div>
            <?php echo e(Form::close()); ?>

        </div>
    </div>
</div>

<?php
    $active_module = ActivatedModule();
    $dependency = explode(',', 'Account,Taskly');
?>

<?php if(!empty(array_intersect($dependency, $active_module))): ?>
    <!--Proposal print Setting-->
    <?php
        $proposal_template = isset($settings['proposal_template']) ? $settings['proposal_template'] : '';
        $proposal_color = isset($settings['proposal_color']) ? $settings['proposal_color'] : '';
    ?>
    <div id="proposal-print-sidenav" class="card">
        <div class="card-header">
            <h5><?php echo e(__('Proposal Print Settings')); ?></h5>
            <small class="text-muted"><?php echo e(__('Edit your Company Proposal details')); ?></small>
        </div>
        <div class="bg-none">
            <div class="row company-setting">
                <div class="">
                    <form id="setting-form" method="post" action="<?php echo e(route('proposal.template.setting')); ?>"
                        enctype ="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="card-header card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <?php echo e(Form::label('proposal_prefix', __('Prefix'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::text('proposal_prefix', isset($settings['proposal_prefix']) ? $settings['proposal_prefix'] : '#PROP0', ['class' => 'form-control', 'placeholder' => 'Enter Prefix'])); ?>

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <?php echo e(Form::label('proposal_starting_number', __('Starting Number'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::number('proposal_starting_number', isset($settings['proposal_starting_number']) ? $settings['proposal_starting_number'] : 1, ['class' => 'form-control', 'placeholder' => 'Enter Starting Number'])); ?>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?php echo e(Form::label('proposal_footer_title', __('Footer Title'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::text('proposal_footer_title', isset($settings['proposal_footer_title']) ? $settings['proposal_footer_title'] : '', ['class' => 'form-control', 'placeholder' => 'Enter Footer Title'])); ?>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?php echo e(Form::label('proposal_footer_notes', __('Footer Notes'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::textarea('proposal_footer_notes', isset($settings['proposal_footer_notes']) ? $settings['proposal_footer_notes'] : '', ['class' => 'form-control', 'rows' => '1', 'placeholder' => 'Enter Footer Notes'])); ?>

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mt-2">
                                        <?php echo e(Form::label('proposal_shipping_display', __('Shipping Display?'), ['class' => 'form-label'])); ?>

                                        <div class=" form-switch form-switch-left">
                                            <input type="checkbox" class="form-check-input"
                                                name="proposal_shipping_display" id="proposal_shipping_display"
                                                <?php echo e((isset($settings['proposal_shipping_display']) ? $settings['proposal_shipping_display'] : 'off') == 'on' ? 'checked' : ''); ?>>
                                            <label class="form-check-label" for="proposal_shipping_display"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card-header card-body">
                                    <div class="form-group">
                                        <label for="proposal_template"
                                            class="col-form-label"><?php echo e(__('Template')); ?></label>
                                        <select class="form-control" name="proposal_template" id="proposal_template">
                                            <?php $__currentLoopData = templateData()['templates']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($key); ?>"
                                                    <?php echo e($proposal_template == $key ? 'selected' : ''); ?>>
                                                    <?php echo e($template); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label"><?php echo e(__('Color Input')); ?></label>
                                        <div class="row gutters-xs">
                                            <?php $__currentLoopData = templateData()['colors']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="col-auto">
                                                    <label class="colorinput">
                                                        <input name="proposal_color" type="radio"
                                                            value="<?php echo e($color); ?>" class="colorinput-input"
                                                            <?php echo e($proposal_color == $color ? 'checked' : ''); ?>>
                                                        <span class="colorinput-color"
                                                            style="background: #<?php echo e($color); ?>"></span>
                                                    </label>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label"><?php echo e(__('Logo')); ?></label>
                                        <div class="choose-files mt-3">
                                            <label for="proposal_logo">
                                                <div class=" bg-primary "> <i
                                                        class="ti ti-upload px-1"></i><?php echo e(__('Choose file here')); ?>

                                                </div>
                                                <img id="blah12" class="mt-3" src="" width="70%" />
                                                <input type="file" class="form-control file" name="proposal_logo"
                                                    id="proposal_logo" data-filename="proposal_logo_update"
                                                    onchange="document.getElementById('blah12').src = window.URL.createObjectURL(this.files[0])">
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
                                <?php if(!empty($proposal_template) && !empty($proposal_color)): ?>
                                    <iframe id="proposal_frame" class="w-100 h-100" frameborder="0"
                                        src="<?php echo e(route('proposal.preview', [$proposal_template, $proposal_color])); ?>"></iframe>
                                <?php else: ?>
                                    <iframe id="proposal_frame" class="w-100 h-100" frameborder="0"
                                        src="<?php echo e(route('proposal.preview', ['template1', 'fffff'])); ?>"></iframe>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Invoice print Setting-->
    <?php
        $invoice_template = isset($settings['invoice_template']) ? $settings['invoice_template'] : '';
        $invoice_color = isset($settings['invoice_color']) ? $settings['invoice_color'] : '';
    ?>
    <div id="invoice-print-sidenav" class="card">
        <div class="card-header">
            <h5><?php echo e(__('Invoice Print Settings')); ?></h5>
            <small class="text-muted"><?php echo e(__('Edit your Company invoice details')); ?></small>
        </div>
        <div class="bg-none">
            <div class="row company-setting">
                <form id="setting-form" method="post" action="<?php echo e(route('invoice.template.setting')); ?>"
                    enctype ="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card-header card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <?php echo e(Form::label('invoice_prefix', __('Prefix'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::text('invoice_prefix', isset($settings['invoice_prefix']) ? $settings['invoice_prefix'] : '#INV', ['class' => 'form-control', 'placeholder' => 'Enter Prefix'])); ?>

                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <?php echo e(Form::label('invoice_starting_number', __('Starting Number'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::number('invoice_starting_number', isset($settings['invoice_starting_number']) ? $settings['invoice_starting_number'] : 1, ['class' => 'form-control', 'placeholder' => 'Enter Invoice Starting Number'])); ?>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php echo e(Form::label('invoice_footer_title', __('Footer Title'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::text('invoice_footer_title', isset($settings['invoice_footer_title']) ? $settings['invoice_footer_title'] : '', ['class' => 'form-control', 'placeholder' => 'Enter Footer Title'])); ?>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php echo e(Form::label('invoice_footer_notes', __('Footer Notes'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::textarea('invoice_footer_notes', isset($settings['invoice_footer_notes']) ? $settings['invoice_footer_notes'] : '', ['class' => 'form-control', 'rows' => '1', 'placeholder' => 'Enter Footer Notes'])); ?>

                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mt-2">
                                    <?php echo e(Form::label('invoice_shipping_display', __('Shipping Display?'), ['class' => 'form-label'])); ?>

                                    <div class=" form-switch form-switch-left">
                                        <input type="checkbox" class="form-check-input"
                                            name="invoice_shipping_display" id="invoice_shipping_display"
                                            <?php echo e((isset($settings['invoice_shipping_display']) ? $settings['invoice_shipping_display'] : 'off') == 'on' ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="invoice_shipping_display"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card-header card-body">
                                <div class="form-group">
                                    <label for="invoice_template"
                                        class="col-form-label"><?php echo e(__('Template')); ?></label>
                                    <select class="form-control" name="invoice_template" id="invoice_template">
                                        <?php $__currentLoopData = templateData()['templates']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($key); ?>"
                                                <?php echo e($invoice_template == $key ? 'selected' : ''); ?>>
                                                <?php echo e($template); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label"><?php echo e(__('Color Input')); ?></label>
                                    <div class="row gutters-xs">
                                        <?php $__currentLoopData = templateData()['colors']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-auto">
                                                <label class="colorinput">
                                                    <input name="invoice_color" type="radio"
                                                        value="<?php echo e($color); ?>" class="colorinput-input"
                                                        <?php echo e($invoice_color == $color ? 'checked' : ''); ?>>
                                                    <span class="colorinput-color"
                                                        style="background: #<?php echo e($color); ?>"></span>
                                                </label>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label"><?php echo e(__('Logo')); ?></label>
                                    <div class="choose-files mt-3">
                                        <label for="invoice_logo">
                                            <div class=" bg-primary "> <i
                                                    class="ti ti-upload px-1"></i><?php echo e(__('Choose file here')); ?>

                                            </div>
                                            <img id="blah6" class="mt-3" src="" width="70%" />
                                            <input type="file" class="form-control file" name="invoice_logo"
                                                id="invoice_logo" data-filename="invoice_logo_update"
                                                onchange="document.getElementById('blah6').src = window.URL.createObjectURL(this.files[0])">
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
                            <?php if(!empty($invoice_template) && !empty($invoice_color)): ?>
                                <iframe id="invoice_frame" class="w-100 h-100" frameborder="0"
                                    src="<?php echo e(route('invoice.preview', [$invoice_template, $invoice_color])); ?>"></iframe>
                            <?php else: ?>
                                <iframe id="invoice_frame" class="w-100 h-100" frameborder="0"
                                    src="<?php echo e(route('invoice.preview', ['template1', 'fffff'])); ?>"></iframe>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Purchase Print Settings -->

    <?php
        $purchase_template = isset($settings['purchase_template']) ? $settings['purchase_template'] : '';
        $purchase_color = isset($settings['purchase_color']) ? $settings['purchase_color'] : '';
    ?>

    <div id="purchase-print-sidenav" class="card">
        <div class="card-header">
            <h5><?php echo e(__('Purchase Print Settings')); ?></h5>
            <small class="text-muted"><?php echo e(__('Edit details about your Company Bill')); ?></small>
        </div>
        <div class="bg-none">
            <div class="row company-setting">
                <form id="setting-form" method="post" action="<?php echo e(route('purchases.template.setting')); ?>"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card-header card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php echo e(Form::label('purchase_prefix', __('Prefix'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::text('purchase_prefix', isset($settings['purchase_prefix']) && !empty($settings['purchase_prefix']) ? $settings['purchase_prefix'] : '#PUR', ['class' => 'form-control', 'placeholder' => 'Enter Purchase Prefix'])); ?>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php echo e(Form::label('purchase_footer_title', __('Footer Title'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::text('purchase_footer_title', isset($settings['purchase_footer_title']) && !empty($settings['purchase_footer_title']) ? $settings['purchase_footer_title'] : '', ['class' => 'form-control', 'placeholder' => 'Enter Footer Title'])); ?>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php echo e(Form::label('purchase_footer_notes', __('Footer Notes'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::textarea('purchase_footer_notes', isset($settings['purchase_footer_notes']) && !empty($settings['purchase_footer_notes']) ? $settings['purchase_footer_notes'] : '', ['class' => 'form-control', 'rows' => '1', 'placeholder' => 'Enter Purchase Footer Notes'])); ?>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mt-2">
                                    <?php echo e(Form::label('purchase_shipping_display', __('Shipping Display?'), ['class' => 'form-label'])); ?>

                                    <div class=" form-switch form-switch-left">
                                        <input type="checkbox" class="form-check-input"
                                            name="purchase_shipping_display" id="purchase_shipping_display"
                                            <?php echo e(isset($settings['purchase_shipping_display']) && $settings['purchase_shipping_display'] == 'on' ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="purchase_shipping_display"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card-header card-body">

                                <div class="form-group">
                                    <label for="purchase_template"
                                        class="col-form-label"><?php echo e(__('Template')); ?></label>
                                    <select class="form-control" name="purchase_template" id="purchase_template">
                                        <?php $__currentLoopData = templateData()['templates']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($key); ?>"
                                                <?php echo e($purchase_template == $key ? 'selected' : ''); ?>>
                                                <?php echo e($template); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label class="form-label"><?php echo e(__('Color Input')); ?></label>
                                    <div class="row gutters-xs">
                                        <?php $__currentLoopData = templateData()['colors']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-auto">
                                                <label class="colorinput">
                                                    <input name="purchase_color" type="radio"
                                                        value="<?php echo e($color); ?>" class="colorinput-input"
                                                        <?php echo e($purchase_color == $color ? 'checked' : ''); ?>>
                                                    <span class="colorinput-color"
                                                        style="background: #<?php echo e($color); ?>"></span>
                                                </label>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label"><?php echo e(__('Logo')); ?></label>
                                    <div class="choose-files mt-3">
                                        <label for="purchase_logo">
                                            <div class=" bg-primary "> <i
                                                    class="ti ti-upload px-1"></i><?php echo e(__('Choose file here')); ?>

                                            </div>
                                            <img id="blah7" class="mt-3" src="" width="70%" />
                                            <input type="file" class="form-control file" name="purchase_logo"
                                                id="purchase_logo" data-filename="purchase_logo"
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
                            <?php if(!empty($purchase_template) && !empty($purchase_color)): ?>
                                <iframe id="purchase_frame" class="w-100 h-100" frameborder="0"
                                    src="<?php echo e(route('purchases.preview', [$purchase_template, $purchase_color])); ?>"></iframe>
                            <?php else: ?>
                                <iframe id="purchase_frame" class="w-100 h-100" frameborder="0"
                                    src="<?php echo e(route('purchases.preview', ['template1', 'fffff'])); ?>"></iframe>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>
<script>
    $(document).ready(function() {
        choices();
    });

    function check_theme(color_val) {
        $('input[value="' + color_val + '"]').prop('checked', true);
        $('a[data-value]').removeClass('active_color');
        $('a[data-value="' + color_val + '"]').addClass('active_color');
    }
    var themescolors = document.querySelectorAll(".themes-color > a");
    for (var h = 0; h < themescolors.length; h++) {
        var c = themescolors[h];

        c.addEventListener("click", function(event) {
            var targetElement = event.target;
            if (targetElement.tagName == "SPAN") {
                targetElement = targetElement.parentNode;
            }
            var temp = targetElement.getAttribute("data-value");
            removeClassByPrefix(document.querySelector("body"), "theme-");
            document.querySelector("body").classList.add(temp);
        });
    }

    function removeClassByPrefix(node, prefix) {
        for (let i = 0; i < node.classList.length; i++) {
            let value = node.classList[i];
            if (value.startsWith(prefix)) {
                node.classList.remove(value);
            }
        }
    }
    if ($('#useradd-sidenav').length > 0) {
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300,
        });
    }
    $(document).on('change', '#defult_currancy', function() {
        var sy = $('#defult_currancy option:selected').attr('data-symbol');
        $('#defult_currancy_symbol').val(sy);

    });
</script>

<script>
    var custdarklayout = document.querySelector("#cust-darklayout");
    custdarklayout.addEventListener("click", function() {
        if (custdarklayout.checked) {
            document.querySelector(".m-header > .b-brand > .logo-lg").setAttribute("src",
                "<?php echo e($logo_light); ?>");
            document.querySelector("#main-style-link").setAttribute("href",
                "<?php echo e(asset('assets/css/style-dark.css')); ?>");
        } else {
            document.querySelector(".m-header > .b-brand > .logo-lg").setAttribute("src",
                "<?php echo e($logo_dark); ?>");
            document.querySelector("#main-style-link").setAttribute("href",
                "<?php echo e(asset('assets/css/style.css')); ?>");
        }
    });

    function removeClassByPrefix(node, prefix) {
        for (let i = 0; i < node.classList.length; i++) {
            let value = node.classList[i];
            if (value.startsWith(prefix)) {
                node.classList.remove(value);
            }
        }
    }
</script>
<script>
    function cust_theme_bg(params) {
        var custthemebg = document.querySelector("#site_transparent");
        var val = "checked";
        if (val) {
            document.querySelector(".dash-sidebar").classList.add("transprent-bg");
            document
                .querySelector(".dash-header:not(.dash-mob-header)")
                .classList.add("transprent-bg");
        } else {
            document.querySelector(".dash-sidebar").classList.remove("transprent-bg");
            document
                .querySelector(".dash-header:not(.dash-mob-header)")
                .classList.remove("transprent-bg");
        }
    }
    if ($('#site_transparent').length > 0) {
        var custthemebg = document.querySelector("#site_transparent");
        custthemebg.addEventListener("click", function() {
            if (custthemebg.checked) {
                document.querySelector(".dash-sidebar").classList.add("transprent-bg");
                document
                    .querySelector(".dash-header:not(.dash-mob-header)")
                    .classList.add("transprent-bg");
            } else {
                document.querySelector(".dash-sidebar").classList.remove("transprent-bg");
                document
                    .querySelector(".dash-header:not(.dash-mob-header)")
                    .classList.remove("transprent-bg");
            }
        });
    }
</script>

<script>
    $(document).on('change', '#vat_gst_number_switch', function() {
        if ($(this).is(':checked')) {
            $('.tax_type_div').removeClass('d-none');

        } else {
            $('.tax_type_div').addClass('d-none');

        }
    });
</script>
<script>
    $(document).on("change", "select[name='proposal_template'], input[name='proposal_color']", function() {
        var template = $("select[name='proposal_template']").val();
        var color = $("input[name='proposal_color']:checked").val();
        $('#proposal_frame').attr('src', '<?php echo e(url('/proposal/preview')); ?>/' + template + '/' + color);
    });
</script>
<script>
    $(document).on("change", "select[name='invoice_template'], input[name='invoice_color']", function() {
        var template = $("select[name='invoice_template']").val();
        var color = $("input[name='invoice_color']:checked").val();
        $('#invoice_frame').attr('src', '<?php echo e(url('/invoices/preview')); ?>/' + template + '/' + color);
    });
</script>

<script>
    $(document).on("change", "select[name='purchase_template'], input[name='purchase_color']", function() {
        var template = $("select[name='purchase_template']").val();
        var color = $("input[name='purchase_color']:checked").val();
        $('#purchase_frame').attr('src', '<?php echo e(url('/purchases/preview')); ?>/' + template + '/' + color);
    });
</script>

<script>
    $('.colorPicker').on('click', function(e) {
        $('body').removeClass('custom-color');
        if (/^theme-\d+$/) {
            $('body').removeClassRegex(/^theme-\d+$/);
        }
        $('body').addClass('custom-color');
        $('.themes-color-change').removeClass('active_color');
        $(this).addClass('active_color');
        const input = document.getElementById("color-picker");
        setColor();
        input.addEventListener("input", setColor);

        function setColor() {
            document.documentElement.style.setProperty('--color-customColor', input.value);
        }

        $(`input[name='color_flag`).val('true');
    });

    $('.themes-color-change').on('click', function() {

        $(`input[name='color_flag`).val('false');

        var color_val = $(this).data('value');
        $('body').removeClass('custom-color');
        if (/^theme-\d+$/) {
            $('body').removeClassRegex(/^theme-\d+$/);
        }
        $('body').addClass(color_val);
        $('.theme-color').prop('checked', false);
        $('.themes-color-change').removeClass('active_color');
        $('.colorPicker').removeClass('active_color');
        $(this).addClass('active_color');
        $(`input[value=${color_val}]`).prop('checked', true);
    });

    $.fn.removeClassRegex = function(regex) {
        return $(this).removeClass(function(index, classes) {
            return classes.split(/\s+/).filter(function(c) {
                return regex.test(c);
            }).join(' ');
        });
    };
</script>
<script>
    $(document).ready(function() {
        sendData();
        $('.currency_note').on('change', function() {
            sendData();
        });

        function sendData(selectedValue, type) {
            var formData = $('#setting-currency-form').serialize();
            $.ajax({
                type: 'POST',
                url: '<?php echo e(route('company.update.note.value')); ?>',
                data: formData,
                success: function(response) {
                    var formattedPrice = response.formatted_price;
                    $('#formatted_price_span').text(formattedPrice);
                }
            });
        }
    });
</script>
<?php /**PATH /opt/lampp/htdocs/logistics/resources/views/company/settings/index.blade.php ENDPATH**/ ?>