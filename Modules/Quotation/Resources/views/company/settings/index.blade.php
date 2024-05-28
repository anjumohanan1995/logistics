
<div id="quotation-sidenav" class="card">
    <div class="card-header">
        <h5>{{ __('Quotation Print Settings') }}</h5>
        <small class="text-muted">{{ __('Edit your Company Quotation details') }}</small>
    </div>
    <div class="bg-none">
        <div class="row company-setting">
            <form id="setting-form" method="post" action="{{ route('quotation.template.setting') }}"
                enctype ="multipart/form-data">
                @csrf
                <div class="card-header card-body ">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                {{ Form::label('quotation_prefix', __('Prefix'), ['class' => 'form-label']) }}
                                {{ Form::text('quotation_prefix', !empty($settings['quotation_prefix']) ? $settings['quotation_prefix'] : '#QUO', ['class' => 'form-control', 'placeholder' => 'Enter Quotation Prefix']) }}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                {{ Form::label('quotation_starting_number', __('Starting Number'), ['class' => 'form-label']) }}
                                {{ Form::number('quotation_starting_number', !empty($settings['quotation_starting_number']) ? $settings['quotation_starting_number'] : 1, ['class' => 'form-control', 'placeholder' => 'Enter Bill Starting Number']) }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ Form::label('quotation_footer_title', __('Footer Title'), ['class' => 'form-label']) }}
                                {{ Form::text('quotation_footer_title', !empty($settings['quotation_footer_title']) ? $settings['quotation_footer_title'] : '', ['class' => 'form-control', 'placeholder' => 'Enter Footer Title']) }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ Form::label('quotation_footer_notes', __('Footer Notes'), ['class' => 'form-label']) }}
                                {{ Form::textarea('quotation_footer_notes', !empty($settings['quotation_footer_notes']) ? $settings['quotation_footer_notes'] : '', ['class' => 'form-control', 'rows' => '1', 'placeholder' => 'Enter Bill Footer Notes']) }}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group mt-2">
                                {{ Form::label('quotation_shipping_display', __('Shipping Display?'), ['class' => 'form-label']) }}
                                <div class=" form-switch form-switch-left">
                                    <input type="checkbox" class="form-check-input" name="quotation_shipping_display"
                                        id="quotation_shipping_display"
                                        {{ isset($settings['quotation_shipping_display']) && $settings['quotation_shipping_display'] == 'on' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="quotation_shipping_display"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card-header card-body">
                            <div class="form-group">
                                {{ Form::label('quotation_template', __('Quotation Template'), ['class' => 'form-label']) }}
                                {{ Form::select('quotation_template', Modules\Quotation\Entities\Quotation::templateData()['templates'], !empty($settings['quotation_template']) ? $settings['quotation_template'] : null, ['class' => 'form-control', 'required' => 'required']) }}
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">{{ __('Color Input') }}</label>
                                <div class="row gutters-xs">
                                    @foreach (Modules\Quotation\Entities\Quotation::templateData()['colors'] as $key => $color)
                                        <div class="col-auto">
                                            <label class="colorinput">
                                                <input name="quotation_color" type="radio" value="{{ $color }}"
                                                    class="colorinput-input"
                                                    {{ !empty($settings['quotation_color']) && $settings['quotation_color'] == $color ? 'checked' : '' }}>
                                                <span class="colorinput-color"
                                                    style="background: #{{ $color }}"></span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">{{ __('Quotation Logo') }}</label>
                                <div class="choose-files mt-5 ">
                                    <label for="quotation_logo">
                                        <div class=" bg-primary "> <i
                                                class="ti ti-upload px-1"></i>{{ __('Choose file here') }}</div>
                                        <img id="blah7" class="mt-3" src="" width="70%" />
                                        <input type="file" class="form-control file" name="quotation_logo" id="quotation_logo"
                                            data-filename="quotation_logo_update"
                                            onchange="document.getElementById('blah7').src = window.URL.createObjectURL(this.files[0])">
                                    </label>
                                </div>
                            </div>
                            <div class="form-group mt-2 text-end">
                                <input type="submit" value="{{ __('Save Changes') }}"
                                    class="btn btn-print-invoice  btn-primary m-r-10">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        @if (!empty($settings['quotation_template']) && !empty($settings['quotation_color']))
                            <iframe id="quotation_frame" class="w-100 h-100" frameborder="0"
                                src="{{ route('quotation.preview', [$settings['quotation_template'], $settings['quotation_color']]) }}"></iframe>
                        @else
                            <iframe id="quotation_frame" class="w-100 h-100" frameborder="0"
                                src="{{ route('quotation.preview', ['template1', 'fffff']) }}"></iframe>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).on("change", "select[name='quotation_template'], input[name='quotation_color']", function() {
        var template = $("select[name='quotation_template']").val();
        var color = $("input[name='quotation_color']:checked").val();
        $('#quotation_frame').attr('src', '{{ url('/quotation/preview') }}/' + template + '/' + color);
    });
</script>
