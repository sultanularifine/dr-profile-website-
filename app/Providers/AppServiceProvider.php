<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use App\Models\PageContent;
use App\Models\PageSeo;
use App\Models\SiteSetting;
use App\Support\PublicSitePages;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Apply a valid admin-configured timezone globally; APP_TIMEZONE remains the fallback.
        if (Schema::hasTable('site_settings')) {
            $configuredTimezone = SiteSetting::valueFor('timezone');
            if (is_string($configuredTimezone) && in_array($configuredTimezone, timezone_identifiers_list(), true)) {
                config(['app.timezone' => $configuredTimezone]);
                date_default_timezone_set($configuredTimezone);
            }
        }

        // Share only public, non-secret settings with the public Blade layout.
        // Schema guards let legacy installations continue during migrations.
        View::composer('frontend.layouts.app', function ($view): void {
            $settingDefaults = [];
            foreach (config('site_settings_fields', []) as $group) {
                foreach ($group['fields'] ?? [] as $field) {
                    if (($field['type'] ?? 'text') !== 'secret') {
                        $settingDefaults[$field['key']] = $field['default'] ?? '';
                    }
                }
            }

            if (Schema::hasTable('site_settings')) {
                $stored = Cache::remember('admin_public_site_settings', 300, function () {
                    return SiteSetting::query()->where('is_secret', false)->pluck('value', 'key')->all();
                });
                foreach ($stored as $key => $value) {
                    // Empty overrides should not hide a safe template/config fallback.
                    if ($value !== null && $value !== '') {
                        $settingDefaults[$key] = $value;
                    } elseif (in_array($key, ['gtm_enabled', 'ga4_enabled', 'meta_pixel_enabled', 'google_ads_enabled'], true) && $value === '0') {
                        $settingDefaults[$key] = '0';
                    }
                }
            }

            $pageKey = PublicSitePages::keyForRoute(Route::currentRouteName());
            $seoPage = null;
            if ($pageKey && Schema::hasTable('page_seo')) {
                $seoPage = Cache::remember('admin_page_seo_' . $pageKey, 300, fn () => PageSeo::query()->where('page_key', $pageKey)->first());
            }

            $view->with('adminPublicSettings', $settingDefaults)
                ->with('adminSeoPage', $seoPage)
                ->with('adminIsBlogDetail', Route::currentRouteName() === 'blog.view');
        });
    }
}

if (!function_exists('site_content')) {
    function site_content(string $key, string $fallback = ''): string
    {
        $overrides = Cache::remember('page_content_overrides', 300, function () {
            return PageContent::pluck('value', 'content_key')->all();
        });
        $value = $overrides[$key] ?? null;
        return html_entity_decode(($value !== null && $value !== '') ? $value : $fallback, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}
