@extends('backend.layouts.app')
@section('title', 'SEO Management')
@section('main')
<div class="main-content"><section class="section">
    <div class="section-header"><h1>SEO Management</h1><div class="section-header-breadcrumb"><div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div><div class="breadcrumb-item active">SEO</div></div></div>
    <div class="section-body">
        <div class="alert alert-light"><i class="fas fa-info-circle text-primary mr-1"></i> Set page titles, search snippets, canonical URLs, robots directives and social previews. Blog posts use their own per-post SEO fields. Public sitemap: <a href="{{ route('sitemap') }}" target="_blank" rel="noopener">{{ route('sitemap') }}</a></div>
        <div class="card"><div class="card-body table-responsive"><table class="table table-striped table-hover"><thead><tr><th>Page</th><th>URL</th><th>SEO status</th><th>Indexing</th><th class="text-right">Action</th></tr></thead><tbody>
        @foreach($pages as $key => $pageInfo)
            @php $record = $records->get($key); @endphp
            <tr><td><strong>{{ $pageInfo['label'] }}</strong></td><td><code>{{ $pageInfo['path'] }}</code></td><td>@if($record && ($record->seo_title || $record->meta_description))<span class="badge badge-success">Customized</span>@else<span class="badge badge-secondary">Using page defaults</span>@endif</td><td>@if(!$record || $record->robots_index)<span class="badge badge-success">Index</span>@else<span class="badge badge-warning">Noindex</span>@endif</td><td class="text-right"><a href="{{ route('admin.seo.edit', $key) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit mr-1"></i> Edit SEO</a></td></tr>
        @endforeach
        </tbody></table></div></div>
        <p class="text-muted small">A saved configuration does not guarantee that Google will display an exact title or description. Review the generated page source after saving.</p>
    </div>
</section></div>
@endsection
