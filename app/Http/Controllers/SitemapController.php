<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\PageSeo;
use App\Support\PublicSitePages;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Schema;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $seoRecords = collect();
        if (Schema::hasTable('page_seo')) {
            $seoRecords = PageSeo::query()->get()->keyBy('page_key');
        }

        $pages = [];
        foreach (PublicSitePages::all() as $key => $page) {
            $seo = $seoRecords->get($key);
            if (($seo && (!$seo->sitemap_include || !$seo->robots_index))) {
                continue;
            }
            $pageUrl = $seo?->canonical_url ?: url($page['path']);
            $pageHost = parse_url($pageUrl, PHP_URL_HOST);
            $siteHost = parse_url((string) config('app.url'), PHP_URL_HOST);
            if ($pageHost && $siteHost && strcasecmp($pageHost, $siteHost) !== 0) {
                continue;
            }
            $pages[] = [
                'url' => $pageUrl,
                'lastmod' => $seo?->updated_at,
            ];
        }

        $blogs = collect();
        if (Schema::hasTable('blogs')) {
            $blogs = Blog::query()->where('is_published', true)
                ->orderByDesc('updated_at')->get(['slug', 'canonical_url', 'updated_at'])
                ->map(function (Blog $blog) {
                    $url = $blog->canonical_url ?: route('blog.view', $blog);
                    $canonicalHost = parse_url($url, PHP_URL_HOST);
                    $siteHost = parse_url((string) config('app.url'), PHP_URL_HOST);
                    // Sitemap only includes same-site canonical URLs.
                    if ($canonicalHost && $siteHost && strcasecmp($canonicalHost, $siteHost) !== 0) {
                        return null;
                    }
                    return ['url' => $url, 'lastmod' => $blog->updated_at];
                })->filter()->values();
        }

        return response()->view('frontend.sitemap', [
            'pages' => $pages,
            'blogs' => $blogs,
        ], 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}
