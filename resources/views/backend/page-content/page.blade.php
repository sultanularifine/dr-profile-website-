@extends('backend.layouts.app')

@section('title', 'Edit Website Page')

@push('style')
<style>
    .cms-help { border-left: 3px solid #6777ef; background: #f6f7ff; padding: 14px 16px; border-radius: 4px; }
    .cms-field { padding: 1.25rem 0; border-bottom: 1px solid #f0f1f5; }
    .cms-field:last-child { border-bottom: 0; }
    .cms-field-title { font-weight: 600; color: #34395e; margin-bottom: .4rem; }
    .cms-field-reference { color: #98a6ad; font-size: 12px; }
    .cms-preview { color: #6c757d; font-size: 12px; line-height: 1.5; margin-top: .35rem; }
    .cms-image-preview { max-width: 240px; max-height: 180px; object-fit: contain; border: 1px solid #e4e6fc; border-radius: 6px; padding: 4px; background: #fff; }
    .cms-group-title { text-decoration: none !important; color: #34395e !important; font-weight: 700; width: 100%; text-align: left; white-space: normal; }
    .cms-empty { display: none; }
</style>
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $page === 'shared_header' ? 'Website Header' : ($page === 'shared_footer' ? 'Website Footer' : ucfirst(str_replace(['-', '_'], ' ', $page))) }} Editor</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Website Management</div>
                <div class="breadcrumb-item active">{{ ucfirst(str_replace(['-', '_'], ' ', $page)) }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="cms-help mb-4">
                <strong>How to edit this page</strong>
                <p class="mb-1 mt-1">Change the text in each field and select <strong>Save all changes</strong>. The public website's current layout, colors, fonts and responsive design are preserved.</p>
                <small>Fields are displayed in the same order as the page source. Use the search box to locate a text or field. Leave a text field blank to restore the original text. Only images detected by the CMS show an upload control.</small>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible show fade"><div class="alert-body"><button class="close" data-dismiss="alert"><span>&times;</span></button>{{ session('success') }}</div></div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger"><strong>Some fields need attention.</strong><ul class="mb-0 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif

            <form method="POST" enctype="multipart/form-data" action="{{ route('admin.pages.update', $page) }}" id="page-content-form">
                @csrf @method('PUT')

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="form-group mb-0">
                            <label for="cms-search">Find a field</label>
                            <div class="input-group">
                                <input type="search" id="cms-search" class="form-control" placeholder="Search by label or text..." autocomplete="off">
                                <div class="input-group-append"><button type="button" class="btn btn-light" id="cms-search-clear">Clear</button></div>
                            </div>
                            <small class="form-text text-muted"><span id="cms-visible-count">{{ $items->count() }}</span> fields on this page. Groups are collapsible to keep long pages easy to manage.</small>
                        </div>
                    </div>
                </div>

                @foreach($groups as $groupIndex => $group)
                    @php
                        $groupId = 'cms-group-' . $groupIndex . '-' . ($group['id'] ?? $groupIndex);
                        $groupLabel = $group['label'] ?? 'Content fields';
                        $groupItems = $group['items'] ?? collect();
                    @endphp
                    <div class="card cms-group" data-cms-group>
                        <div class="card-header">
                            <h4 class="mb-0 flex-grow-1">
                                <button class="btn btn-link cms-group-title {{ $groupIndex === 0 ? '' : 'collapsed' }}" type="button" data-toggle="collapse" data-target="#{{ $groupId }}" aria-expanded="{{ $groupIndex === 0 ? 'true' : 'false' }}" aria-controls="{{ $groupId }}">
                                    {{ $groupLabel }}
                                </button>
                            </h4>
                            <div class="card-header-action"><span class="badge badge-light">{{ $groupItems->count() }} fields</span></div>
                        </div>
                        <div id="{{ $groupId }}" class="collapse {{ $groupIndex === 0 ? 'show' : '' }}">
                            <div class="card-body px-4">
                                @foreach($groupItems as $item)
                                    @php
                                        $imageSlug = str_replace(['.', '-'], '_', $item['content_key']);
                                        $currentImage = $item['value'] ?: $item['default'];
                                        $defaultText = trim(strip_tags($item['default']));
                                        $isLong = mb_strlen($defaultText) > 100 || str_contains($defaultText, "\n");
                                        $searchText = \Illuminate\Support\Str::lower($item['content_key'] . ' ' . $item['label'] . ' ' . $item['default'] . ' ' . ($item['value'] ?? ''));
                                        $oldContent = old('content', []);
                                        $fieldValue = is_array($oldContent) && array_key_exists($item['content_key'], $oldContent)
                                            ? $oldContent[$item['content_key']]
                                            : ($item['value'] ?? '');
                                    @endphp
                                    <div class="cms-field" data-cms-field data-search-text="{{ $searchText }}">
                                        <div class="d-flex flex-wrap align-items-start justify-content-between mb-2">
                                            <div class="cms-field-title">{{ $item['label'] }}</div>
                                            <span class="badge {{ $item['is_custom'] ? 'badge-success' : 'badge-secondary' }}">{{ $item['is_custom'] ? 'Customized' : 'Original text' }}</span>
                                        </div>
                                        @if($item['is_image'])
                                            <div class="form-group mb-0">
                                                <label for="image-{{ $imageSlug }}">Replace image</label>
                                                @if($currentImage)
                                                    <div class="mb-3"><img class="cms-image-preview" id="current-image-{{ $imageSlug }}" src="{{ asset($currentImage) }}" alt="Current image preview"></div>
                                                @else
                                                    <img class="cms-image-preview mb-3" id="current-image-{{ $imageSlug }}" src="" alt="New image preview" style="display:none">
                                                @endif
                                                <input id="image-{{ $imageSlug }}" data-cms-image-input="{{ $imageSlug }}" class="form-control-file" type="file" name="images[{{ $imageSlug }}]" accept="image/jpeg,image/png,image/webp,image/gif">
                                                <small class="form-text text-muted">JPG, PNG, WebP or GIF · maximum 5 MB.</small>
                                                <div class="custom-control custom-checkbox mt-2">
                                                    <input class="custom-control-input" type="checkbox" id="reset-{{ $imageSlug }}" name="reset_image[{{ $imageSlug }}]" value="1">
                                                    <label class="custom-control-label" for="reset-{{ $imageSlug }}">Restore original image</label>
                                                </div>
                                            </div>
                                        @else
                                            <div class="form-group mb-0">
                                                @if($isLong)
                                                    <textarea class="form-control" name="content[{{ $item['content_key'] }}]" rows="4" maxlength="50000" placeholder="Leave blank to restore original text">{{ $fieldValue }}</textarea>
                                                @else
                                                    <input class="form-control" type="text" name="content[{{ $item['content_key'] }}]" maxlength="50000" value="{{ $fieldValue }}" placeholder="Leave blank to restore original text">
                                                @endif
                                                @if($defaultText !== '')<div class="cms-preview">Original text: {{ \Illuminate\Support\Str::limit(preg_replace('/\s+/u', ' ', $defaultText) ?? $defaultText, 220) }}</div>@endif
                                            </div>
                                        @endif
                                        <details class="mt-2"><summary class="cms-field-reference">Technical field reference</summary><code>{{ $item['content_key'] }}</code></details>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="card cms-empty" id="cms-no-results"><div class="card-body text-center text-muted">No matching fields. Try another search term.</div></div>
                <div class="d-flex flex-wrap align-items-center mb-4 mt-3">
                    <button type="submit" class="btn btn-primary mr-2"><i class="fas fa-save mr-1"></i> Save All Changes</button>
                    <a class="btn btn-light" href="{{ route('admin.page-content.index', ['page_name' => $page]) }}">Open all content fields</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
(function () {
    const search = document.getElementById('cms-search');
    const clear = document.getElementById('cms-search-clear');
    const counter = document.getElementById('cms-visible-count');
    const noResults = document.getElementById('cms-no-results');
    const fields = Array.from(document.querySelectorAll('[data-cms-field]'));
    const groups = Array.from(document.querySelectorAll('[data-cms-group]'));

    function filterFields() {
        const term = (search.value || '').trim().toLocaleLowerCase();
        let visibleCount = 0;
        fields.forEach(function (field) {
            const matches = !term || (field.dataset.searchText || '').includes(term);
            field.style.display = matches ? '' : 'none';
            if (matches) visibleCount++;
        });
        groups.forEach(function (group) {
            const hasVisible = group.querySelector('[data-cms-field]:not([style*="display: none"])');
            group.style.display = hasVisible ? '' : 'none';
            if (term && hasVisible) {
                const collapse = group.querySelector('.collapse');
                if (collapse && window.jQuery) window.jQuery(collapse).collapse('show');
            }
        });
        counter.textContent = visibleCount;
        noResults.style.display = visibleCount ? 'none' : 'block';
    }

    search.addEventListener('input', filterFields);
    clear.addEventListener('click', function () { search.value = ''; filterFields(); search.focus(); });
    document.querySelectorAll('[data-cms-image-input]').forEach(function (input) {
        input.addEventListener('change', function () {
            const file = input.files && input.files[0];
            const preview = document.getElementById('current-image-' + input.dataset.cmsImageInput);
            if (!preview) return;
            if (!file) {
                preview.style.display = preview.getAttribute('src') ? '' : 'none';
                return;
            }
            preview.src = URL.createObjectURL(file);
            preview.style.display = '';
        });
    });
})();
</script>
@endpush
