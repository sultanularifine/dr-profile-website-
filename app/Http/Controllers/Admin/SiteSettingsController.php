<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SiteSettingsController extends Controller
{
    private function authorizeSettingsManager(): void
    {
        abort_unless(auth()->user()?->hasRole('Super Admin'), 403);
    }

    public function edit()
    {
        $this->authorizeSettingsManager();
        $groups = config('site_settings_fields', []);
        $values = SiteSetting::publicValues();
        $defaults = [];
        $configuredSecrets = [];

        foreach ($groups as $group) {
            foreach ($group['fields'] ?? [] as $field) {
                $key = $field['key'];
                $defaults[$key] = $field['default'] ?? '';
                if (($field['type'] ?? '') === 'secret') {
                    $configuredSecrets[$key] = SiteSetting::isConfigured($key);
                }
            }
        }

        return view('backend.settings.site', compact('groups', 'values', 'defaults', 'configuredSecrets'));
    }

    public function update(Request $request)
    {
        $this->authorizeSettingsManager();
        $groups = config('site_settings_fields', []);
        $rules = [
            'settings' => ['nullable', 'array'],
            'secrets' => ['nullable', 'array'],
            'images' => ['nullable', 'array'],
            'remove_image' => ['nullable', 'array'],
            'clear_secret' => ['nullable', 'array'],
        ];

        foreach ($groups as $group) {
            foreach ($group['fields'] ?? [] as $field) {
                $key = $field['key'];
                switch ($field['type'] ?? 'text') {
                    case 'toggle':
                        $rules["settings.{$key}"] = ['nullable', 'boolean'];
                        break;
                    case 'image':
                        $rules["images.{$key}"] = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'];
                        $rules["remove_image.{$key}"] = ['nullable', 'boolean'];
                        break;
                    case 'secret':
                        $rules["secrets.{$key}"] = ['nullable', 'string', 'max:10000'];
                        $rules["clear_secret.{$key}"] = ['nullable', 'boolean'];
                        break;
                    default:
                        $max = (int) ($field['max'] ?? 255);
                        $rules["settings.{$key}"] = ['nullable', 'string', "max:{$max}"];
                        break;
                }
            }
        }

        $rules['settings.sslcommerz_environment'] = ['nullable', 'in:sandbox,live'];
        $rules['settings.public_email'][] = 'nullable';
        $rules['settings.public_email'][] = 'email';
        $rules['settings.timezone'][] = 'nullable';
        $rules['settings.timezone'][] = 'timezone';
        $rules['settings.gtm_container_id'][] = 'nullable';
        $rules['settings.gtm_container_id'][] = 'regex:/^GTM-[A-Z0-9]+$/i';
        $rules['settings.ga4_measurement_id'][] = 'nullable';
        $rules['settings.ga4_measurement_id'][] = 'regex:/^G-[A-Z0-9]+$/i';
        $rules['settings.google_ads_conversion_id'][] = 'nullable';
        $rules['settings.google_ads_conversion_id'][] = 'regex:/^AW-[0-9]+$/i';
        $validated = $request->validate($rules);

        foreach ($groups as $group) {
            foreach ($group['fields'] ?? [] as $field) {
                $key = $field['key'];
                $type = $field['type'] ?? 'text';

                if ($type === 'secret') {
                    if ($request->boolean("clear_secret.{$key}")) {
                        SiteSetting::storeValue($key, null, true);
                    } elseif ($request->filled("secrets.{$key}")) {
                        SiteSetting::storeValue($key, $validated['secrets'][$key], true);
                    }
                    continue;
                }

                if ($type === 'image') {
                    $upload = $request->file("images.{$key}");
                    $oldPath = (string) SiteSetting::valueFor($key, '');
                    if ($upload) {
                        $path = $upload->store('settings', 'public');
                        SiteSetting::storeValue($key, $path);
                        $this->deleteManagedPublicImage($oldPath, 'settings/');
                    } elseif ($request->boolean("remove_image.{$key}")) {
                        SiteSetting::storeValue($key, null);
                        $this->deleteManagedPublicImage($oldPath, 'settings/');
                    }
                    continue;
                }

                if ($type === 'toggle') {
                    SiteSetting::storeValue($key, $request->boolean("settings.{$key}") ? '1' : '0');
                    continue;
                }

                $value = $validated['settings'][$key] ?? null;
                SiteSetting::storeValue($key, is_string($value) && trim($value) === '' ? null : $value);
            }
        }

        Cache::forget('admin_public_site_settings');
        return redirect()->route('admin.site-settings.edit')->with('success', 'Website settings saved. Check the integration status notes before enabling third-party tags.');
    }

    private function deleteManagedPublicImage(string $path, string $managedPrefix): void
    {
        if ($path === '' || !str_starts_with($path, $managedPrefix)) {
            return;
        }

        $filename = basename($path);
        if ($filename === '' || in_array($filename, ['.', '..'], true)) {
            return;
        }

        $managedPath = $managedPrefix . $filename;
        if (Storage::disk('public')->exists($managedPath)) {
            Storage::disk('public')->delete($managedPath);
        }
    }
}
