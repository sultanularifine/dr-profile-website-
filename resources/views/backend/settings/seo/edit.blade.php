@extends('backend.layouts.app')
@section('title', 'Edit SEO — ' . $pageInfo['label'])
@push('style')
<style>.seo-preview{border:1px solid #e6e9f0;border-radius:6px;padding:16px;background:#fff}.seo-preview-title{color:#1a0dab;font-size:20px;line-height:1.3}.seo-preview-url{color:#188038;font-size:13px}.seo-preview-description{color:#4d5156;font-size:14px;line-height:1.45}.seo-counter{font-size:12px;color:#98a6ad;text-align:right}</style>
@endpush
@section('main')
<div class="main-content"><section class="section">
    <div class="section-header"><h1>Edit SEO: {{ $pageInfo['label'] }}</h1><div class="section-header-breadcrumb"><div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div><div class="breadcrumb-item"><a href="{{ route('admin.seo.index') }}">SEO Management</a></div><div class="breadcrumb-item active">{{ $pageInfo['label'] }}</div></div></div>
    <div class="section-body">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if($errors->any())<div class="alert alert-danger"><strong>Please correct the following:</strong><ul class="mb-0 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <div class="row"><div class="col-lg-8">
            <form method="POST" enctype="multipart/form-data" action="{{ route('admin.seo.update', $page) }}">@csrf @method('PUT')
                <div class="card"><div class="card-header"><h4>Search result metadata</h4></div><div class="card-body">
                    <div class="form-group"><label for="seo_title">SEO title</label><input class="form-control" id="seo_title" name="seo_title" maxlength="255" value="{{ old('seo_title', $record->seo_title) }}" placeholder="Leave blank to use the existing page title"><div class="seo-counter"><span id="title-count">{{ mb_strlen((string)old('seo_title', $record->seo_title)) }}</span> characters</div></div>
                    <div class="form-group"><label for="meta_description">Meta description</label><textarea class="form-control" rows="3" id="meta_description" name="meta_description" maxlength="320" placeholder="Describe the page clearly in a natural sentence">{{ old('meta_description', $record->meta_description) }}</textarea><div class="seo-counter"><span id="description-count">{{ mb_strlen((string)old('meta_description', $record->meta_description)) }}</span> / 320 characters</div></div>
                    <div class="form-group"><label for="canonical_url">Canonical URL</label><input type="url" class="form-control" id="canonical_url" name="canonical_url" maxlength="2000" value="{{ old('canonical_url', $record->canonical_url) }}" placeholder="https://example.com/page (optional)"></div>
                </div></div>
                <div class="card"><div class="card-header"><h4>Social sharing preview</h4></div><div class="card-body">
                    <div class="form-group"><label for="og_title">Open Graph title</label><input class="form-control" id="og_title" name="og_title" maxlength="255" value="{{ old('og_title', $record->og_title) }}" placeholder="Use SEO title if blank"></div>
                    <div class="form-group"><label for="og_description">Open Graph description</label><textarea class="form-control" rows="2" id="og_description" name="og_description" maxlength="320" placeholder="Use meta description if blank">{{ old('og_description', $record->og_description) }}</textarea></div>
                    <div class="form-group"><label for="og_image">Social sharing image</label>@if($record->og_image)<div class="mb-2"><img src="{{ asset('storage/' . $record->og_image) }}" alt="Current social share image" class="img-thumbnail" style="max-width:280px;max-height:170px"></div>@endif<input class="form-control-file" type="file" id="og_image" name="og_image" accept="image/jpeg,image/png,image/webp"><small class="form-text text-muted">JPG, PNG or WebP; maximum 5 MB.</small>@if($record->og_image)<div class="custom-control custom-checkbox mt-2"><input class="custom-control-input" type="checkbox" id="remove-og-image" name="remove_og_image" value="1"><label class="custom-control-label" for="remove-og-image">Remove current image</label></div>@endif</div>
                    <div class="form-group"><label for="twitter_card">X / Twitter card</label><select class="form-control" id="twitter_card" name="twitter_card"><option value="summary_large_image" @selected(old('twitter_card', $record->twitter_card ?: 'summary_large_image') === 'summary_large_image')>Large image</option><option value="summary" @selected(old('twitter_card', $record->twitter_card) === 'summary')>Summary</option></select></div>
                </div></div>
                <div class="card"><div class="card-header"><h4>Robots and sitemap</h4></div><div class="card-body">
                    @foreach([['robots_index','Allow search engines to index this page',true],['robots_follow','Allow search engines to follow links',true],['sitemap_include','Include this page in the XML sitemap',true]] as [$key,$label,$default])
                        <input type="hidden" name="{{ $key }}" value="0"><div class="custom-control custom-switch mb-3"><input type="checkbox" class="custom-control-input" id="{{ $key }}" name="{{ $key }}" value="1" @checked((bool)old($key, $record->{$key} ?? $default))><label class="custom-control-label" for="{{ $key }}">{{ $label }}</label></div>
                    @endforeach
                    <div class="alert alert-warning small mb-0">Do not disable indexing for the whole site. Private patient pages are not part of this public-page SEO editor.</div>
                </div><div class="card-footer d-flex justify-content-between"><a href="{{ route('admin.seo.index') }}" class="btn btn-light">Back</a><button class="btn btn-primary"><i class="fas fa-save mr-1"></i> Save SEO Settings</button></div></div>
            </form>
        </div><div class="col-lg-4">
            <div class="card"><div class="card-header"><h4>Search result preview</h4></div><div class="card-body"><div class="seo-preview"><div class="seo-preview-title" id="preview-title">{{ old('seo_title', $record->seo_title ?: $pageInfo['label']) }}</div><div class="seo-preview-url">{{ rtrim(config('app.url'), '/') . $pageInfo['path'] }}</div><div class="seo-preview-description" id="preview-description">{{ old('meta_description', $record->meta_description ?: 'A preview of the page description will appear here.') }}</div></div><p class="text-muted small mt-3 mb-0">This is a guide only. Search engines may rewrite titles and snippets.</p></div></div>
        </div></div>
    </div>
</section></div>
@endsection
@push('scripts')
<script>
(function(){
 const title=document.getElementById('seo_title'), desc=document.getElementById('meta_description');
 const titleCount=document.getElementById('title-count'), descCount=document.getElementById('description-count');
 const previewTitle=document.getElementById('preview-title'), previewDesc=document.getElementById('preview-description');
 function update(){titleCount.textContent=title.value.length;descCount.textContent=desc.value.length;previewTitle.textContent=title.value||@json($pageInfo['label']);previewDesc.textContent=desc.value||'A preview of the page description will appear here.';}
 title.addEventListener('input',update);desc.addEventListener('input',update);update();
})();
</script>
@endpush
