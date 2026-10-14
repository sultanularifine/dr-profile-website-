@extends('backend.layouts.app')

@section('title', 'Website Settings')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Website Settings</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active">Website Settings</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-9">
                    @if(session('success'))<div class="alert alert-success alert-dismissible show fade"><div class="alert-body"><button class="close" data-dismiss="alert"><span>&times;</span></button>{{ session('success') }}</div></div>@endif
                    @if($errors->any())<div class="alert alert-danger"><strong>Please review the highlighted settings.</strong><ul class="mb-0 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                    <form method="POST" action="{{ route('admin.site-settings.update') }}" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        @foreach($groups as $groupKey => $group)
                            <div class="card">
                                <div class="card-header"><h4>{{ $group['title'] }}</h4></div>
                                <div class="card-body">
                                    @if(!empty($group['description']))<p class="text-muted">{{ $group['description'] }}</p>@endif
                                    @foreach($group['fields'] as $field)
                                        @php
                                            $key = $field['key'];
                                            $type = $field['type'] ?? 'text';
                                            $value = old('settings.' . $key, $values[$key] ?? ($field['default'] ?? ''));
                                            $fieldId = 'setting-' . str_replace('_', '-', $key);
                                        @endphp
                                        <div class="form-group">
                                            <label for="{{ $fieldId }}">{{ $field['label'] }}</label>
                                            @if($type === 'toggle')
                                                <input type="hidden" name="settings[{{ $key }}]" value="0">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="{{ $fieldId }}" name="settings[{{ $key }}]" value="1" @checked((string)$value === '1')>
                                                    <label class="custom-control-label" for="{{ $fieldId }}">Enable</label>
                                                </div>
                                                @if($key === 'gtm_enabled' || $key === 'ga4_enabled' || $key === 'meta_pixel_enabled' || $key === 'google_ads_enabled')
                                                    <small class="form-text text-muted">The tag is only loaded when the visitor has granted the relevant consent and a valid ID is configured.</small>
                                                @endif
                                            @elseif($type === 'image')
                                                @if(!empty($values[$key]))
                                                    <div class="mb-2"><img src="{{ asset('storage/' . $values[$key]) }}" alt="Current {{ $field['label'] }} preview" class="img-thumbnail" style="max-width:260px;max-height:160px;object-fit:contain"></div>
                                                @endif
                                                <input type="file" class="form-control-file" id="{{ $fieldId }}" name="images[{{ $key }}]" accept="image/jpeg,image/png,image/webp">
                                                <small class="form-text text-muted">JPG, PNG or WebP; maximum 5 MB.</small>
                                                @if(!empty($values[$key]))<div class="custom-control custom-checkbox mt-2"><input class="custom-control-input" type="checkbox" id="remove-{{ $fieldId }}" name="remove_image[{{ $key }}]" value="1"><label class="custom-control-label" for="remove-{{ $fieldId }}">Remove current image</label></div>@endif
                                            @elseif($type === 'secret')
                                                <div class="input-group">
                                                    <input type="password" autocomplete="new-password" class="form-control" id="{{ $fieldId }}" name="secrets[{{ $key }}]" placeholder="{{ !empty($configuredSecrets[$key]) ? 'Saved securely — leave blank to keep current value' : 'Enter credential (optional)' }}">
                                                    <div class="input-group-append"><span class="input-group-text"> <i class="fas fa-lock"></i> </span></div>
                                                </div>
                                                <small class="form-text {{ !empty($configuredSecrets[$key]) ? 'text-success' : 'text-muted' }}">{{ !empty($configuredSecrets[$key]) ? 'Credential configured and encrypted.' : 'No credential saved yet.' }}</small>
                                                @if(!empty($configuredSecrets[$key]))<div class="custom-control custom-checkbox mt-2"><input class="custom-control-input" type="checkbox" id="clear-{{ $fieldId }}" name="clear_secret[{{ $key }}]" value="1"><label class="custom-control-label" for="clear-{{ $fieldId }}">Remove saved credential</label></div>@endif
                                            @elseif($type === 'textarea')
                                                <textarea class="form-control" rows="3" id="{{ $fieldId }}" name="settings[{{ $key }}]" maxlength="{{ $field['max'] ?? 320 }}">{{ $value }}</textarea>
                                            @else
                                                <input type="{{ $type === 'email' ? 'email' : 'text' }}" class="form-control" id="{{ $fieldId }}" name="settings[{{ $key }}]" value="{{ $value }}" maxlength="{{ $field['max'] ?? 255 }}" autocomplete="off">
                                            @endif
                                            @error('settings.' . $key)<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        <div class="card"><div class="card-footer text-right"><button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save mr-1"></i> Save Settings</button></div></div>
                    </form>
                </div>
                <div class="col-lg-3">
                    <div class="card card-info"><div class="card-header"><h4>Integration checklist</h4></div><div class="card-body">
                        @foreach([
                            ['label'=>'Google Tag Manager','enabled'=>'gtm_enabled','id'=>'gtm_container_id'],
                            ['label'=>'Google Analytics 4','enabled'=>'ga4_enabled','id'=>'ga4_measurement_id'],
                            ['label'=>'Meta Pixel','enabled'=>'meta_pixel_enabled','id'=>'meta_pixel_id'],
                            ['label'=>'Google Ads','enabled'=>'google_ads_enabled','id'=>'google_ads_conversion_id'],
                        ] as $integration)
                            @php $active = (string)($values[$integration['enabled']] ?? '0') === '1'; $ready = trim((string)($values[$integration['id']] ?? '')) !== ''; @endphp
                            <div class="mb-3"><div class="font-weight-bold">{{ $integration['label'] }}</div><span class="badge {{ $active && $ready ? 'badge-success' : ($active ? 'badge-warning' : 'badge-secondary') }}">{{ $active && $ready ? 'Enabled & configured' : ($active ? 'Missing ID' : 'Disabled') }}</span></div>
                        @endforeach
                        <hr><p class="small text-muted mb-0">These status labels check saved settings only. They do not prove that third-party tracking is receiving data or that conversion events have been verified.</p>
                    </div></div>
                    <div class="card"><div class="card-header"><h4>Useful links</h4></div><div class="card-body"><a class="btn btn-outline-primary btn-block mb-2" href="{{ route('admin.seo.index') }}"><i class="fas fa-search mr-1"></i> SEO Management</a><a class="btn btn-outline-secondary btn-block" href="{{ route('home') }}" target="_blank" rel="noopener"><i class="fas fa-external-link-alt mr-1"></i> View Website</a></div></div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
