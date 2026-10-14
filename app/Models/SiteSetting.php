<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Throwable;

/**
 * Small, allow-listed key/value settings store. Secret values are encrypted
 * before persistence and are never included in the public settings map.
 */
class SiteSetting extends Model
{
    protected $fillable = ['key', 'value', 'secret_value', 'is_secret'];

    protected $casts = ['is_secret' => 'boolean'];

    private const CACHE_KEY = 'admin_site_settings_map';

    public static function settingMap(): array
    {
        return Cache::remember(self::CACHE_KEY, 300, function () {
            return static::query()->get(['key', 'value', 'secret_value', 'is_secret'])
                ->mapWithKeys(fn (self $setting) => [$setting->key => [
                    'value' => $setting->value,
                    'secret_value' => $setting->secret_value,
                    'is_secret' => (bool) $setting->is_secret,
                ]])->all();
        });
    }

    public static function valueFor(string $key, mixed $default = null): mixed
    {
        $setting = self::settingMap()[$key] ?? null;
        if (!$setting) {
            return $default;
        }

        if ($setting['is_secret']) {
            if (empty($setting['secret_value'])) {
                return $default;
            }
            try {
                return Crypt::decryptString($setting['secret_value']);
            } catch (Throwable $exception) {
                report($exception);
                return $default;
            }
        }

        return $setting['value'] ?? $default;
    }

    public static function isConfigured(string $key): bool
    {
        $setting = self::settingMap()[$key] ?? null;
        if (!$setting) {
            return false;
        }
        $value = $setting['is_secret'] ? $setting['secret_value'] : $setting['value'];
        return is_string($value) && trim($value) !== '';
    }

    /** Return only ordinary values for use in frontend templates. */
    public static function publicValues(): array
    {
        $values = [];
        foreach (self::settingMap() as $key => $setting) {
            if (!$setting['is_secret']) {
                $values[$key] = $setting['value'];
            }
        }
        return $values;
    }

    public static function storeValue(string $key, mixed $value, bool $secret = false): void
    {
        $setting = static::query()->firstOrNew(['key' => $key]);
        $setting->is_secret = $secret;

        if ($secret) {
            $setting->value = null;
            $setting->secret_value = ($value === null || $value === '')
                ? null
                : Crypt::encryptString((string) $value);
        } else {
            $setting->value = $value === null ? null : (string) $value;
            $setting->secret_value = null;
        }

        $setting->save();
        Cache::forget(self::CACHE_KEY);
        Cache::forget('admin_public_site_settings');
    }
}
