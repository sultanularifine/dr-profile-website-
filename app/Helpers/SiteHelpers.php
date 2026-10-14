<?php

use App\Models\PageContent;
use Illuminate\Support\Facades\Cache;

if (! function_exists('site_content')) {
    /**
     * Return an admin override for a frontend text key, or its original fallback.
     * The fallback keeps the frontend working before migrations or DB setup finish.
     */
    function site_content(string $key, ?string $fallback = null): string
    {
        try {
            $overrides = Cache::remember('page_content_overrides', 300, static function () {
                return PageContent::query()->pluck('value', 'content_key')->all();
            });

            if (array_key_exists($key, $overrides) && $overrides[$key] !== null && $overrides[$key] !== '') {
                return (string) $overrides[$key];
            }
        } catch (\Throwable $e) {
            // Database may not be configured yet; retain the original page text.
        }

        if ($fallback !== null) {
            return $fallback;
        }

        return (string) data_get(config('page_content_defaults', []), $key . '.default', $key);
    }
}
