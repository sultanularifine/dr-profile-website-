<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($pages as $page)
    <url>
        <loc>{{ $page['url'] }}</loc>
        @if($page['lastmod'])<lastmod>{{ $page['lastmod']->toAtomString() }}</lastmod>@endif
    </url>
@endforeach
@foreach($blogs as $blog)
    <url>
        <loc>{{ $blog['url'] }}</loc>
        @if($blog['lastmod'])<lastmod>{{ $blog['lastmod']->toAtomString() }}</lastmod>@endif
    </url>
@endforeach
</urlset>
