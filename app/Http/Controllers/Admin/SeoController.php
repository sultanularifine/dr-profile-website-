<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSeo;
use App\Support\PublicSitePages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SeoController extends Controller
{
    private function pages(): array
    {
        return PublicSitePages::all();
    }

    private function authorizeSeoManager(): void
    {
        abort_unless(auth()->user()?->hasRole('Super Admin'), 403);
    }

    public function index()
    {
        $this->authorizeSeoManager();
        $records = PageSeo::query()->get()->keyBy('page_key');
        $pages = $this->pages();
        return view('backend.settings.seo.index', compact('pages', 'records'));
    }

    public function edit(string $page)
    {
        $this->authorizeSeoManager();
        $pages = $this->pages();
        abort_unless(array_key_exists($page, $pages), 404);
        $record = PageSeo::query()->firstOrNew(['page_key' => $page]);
        $pageInfo = $pages[$page];
        return view('backend.settings.seo.edit', compact('page', 'record', 'pageInfo'));
    }

    public function update(Request $request, string $page)
    {
        $this->authorizeSeoManager();
        abort_unless(array_key_exists($page, $this->pages()), 404);

        $data = $request->validate([
            'seo_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:320'],
            'canonical_url' => ['nullable', 'url', 'max:2000'],
            'robots_index' => ['nullable', 'boolean'],
            'robots_follow' => ['nullable', 'boolean'],
            'og_title' => ['nullable', 'string', 'max:255'],
            'og_description' => ['nullable', 'string', 'max:320'],
            'og_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_og_image' => ['nullable', 'boolean'],
            'twitter_card' => ['required', 'in:summary,summary_large_image'],
            'sitemap_include' => ['nullable', 'boolean'],
        ]);

        $record = PageSeo::query()->firstOrNew(['page_key' => $page]);
        $record->fill([
            'seo_title' => $data['seo_title'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
            'canonical_url' => $data['canonical_url'] ?? null,
            'robots_index' => $request->boolean('robots_index'),
            'robots_follow' => $request->boolean('robots_follow'),
            'og_title' => $data['og_title'] ?? null,
            'og_description' => $data['og_description'] ?? null,
            'twitter_card' => $data['twitter_card'],
            'sitemap_include' => $request->boolean('sitemap_include'),
        ]);

        $oldImage = (string) ($record->og_image ?? '');
        if ($request->hasFile('og_image')) {
            $record->og_image = $request->file('og_image')->store('seo', 'public');
        } elseif ($request->boolean('remove_og_image')) {
            $record->og_image = null;
        }

        $record->save();
        if ($oldImage !== (string) $record->og_image && str_starts_with($oldImage, 'seo/')) {
            $oldFilename = basename($oldImage);
            if ($oldFilename !== '' && Storage::disk('public')->exists('seo/' . $oldFilename)) {
                Storage::disk('public')->delete('seo/' . $oldFilename);
            }
        }
        Cache::forget('admin_page_seo_' . $page);
        return redirect()->route('admin.seo.edit', $page)->with('success', 'SEO settings saved. Search engines determine the final title/snippet they display.');
    }
}
