<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class PaymentSettingsController extends Controller
{
    private function authorizeSettingsManager(): void
    {
        abort_unless(auth()->user()?->hasRole('Super Admin'), 403);
    }

    public function edit()
    {
        $this->authorizeSettingsManager();
        $manualSettings = [];
        foreach (config('site_settings_fields.payments.fields', []) as $field) {
            $manualSettings[$field['key']] = (string) SiteSetting::valueFor($field['key'], $field['default'] ?? '');
        }

        return view('backend.settings.payment', [
            'enabled' => (string) SiteSetting::valueFor('sslcommerz_enabled', '0') === '1',
            'environment' => (string) SiteSetting::valueFor('sslcommerz_environment', 'sandbox'),
            'storeId' => (string) SiteSetting::valueFor('sslcommerz_store_id', ''),
            'passwordConfigured' => trim((string) SiteSetting::valueFor('sslcommerz_store_passwd', '')) !== '',
            'storeIdConfigured' => trim((string) SiteSetting::valueFor('sslcommerz_store_id', '')) !== '',
            'manualSettings' => $manualSettings,
        ]);
    }

    public function update(Request $request)
    {
        $this->authorizeSettingsManager();
        $validated = $request->validate([
            'sslcommerz_enabled' => ['required', 'boolean'],
            'sslcommerz_environment' => ['required', 'in:sandbox,live'],
            'sslcommerz_store_id' => ['nullable', 'string', 'max:100'],
            'sslcommerz_store_passwd' => ['nullable', 'string', 'max:10000'],
            'clear_store_password' => ['nullable', 'boolean'],
            'manual_payment_enabled' => ['required', 'boolean'],
            'payment_instructions' => ['nullable', 'string', 'max:2000'],
            'bkash_payment_number' => ['nullable', 'string', 'max:80'],
            'nagad_payment_number' => ['nullable', 'string', 'max:80'],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'bank_account_name' => ['nullable', 'string', 'max:255'],
            'bank_account_number' => ['nullable', 'string', 'max:120'],
        ]);

        SiteSetting::storeValue('sslcommerz_enabled', $request->boolean('sslcommerz_enabled') ? '1' : '0');
        SiteSetting::storeValue('sslcommerz_environment', $validated['sslcommerz_environment']);
        $storeId = trim((string) ($validated['sslcommerz_store_id'] ?? ''));
        SiteSetting::storeValue('sslcommerz_store_id', $storeId === '' ? null : $storeId);

        if ($request->boolean('clear_store_password')) {
            SiteSetting::storeValue('sslcommerz_store_passwd', null, true);
        } elseif (trim((string) ($validated['sslcommerz_store_passwd'] ?? '')) !== '') {
            SiteSetting::storeValue('sslcommerz_store_passwd', $validated['sslcommerz_store_passwd'], true);
        }

        // Manual payment numbers are ordinary, displayable settings. Empty values remove the number from patient checkout.
        foreach (['payment_instructions', 'bkash_payment_number', 'nagad_payment_number', 'bank_name', 'bank_account_name', 'bank_account_number'] as $key) {
            $value = trim((string) ($validated[$key] ?? ''));
            SiteSetting::storeValue($key, $value === '' ? null : $value);
        }
        SiteSetting::storeValue('manual_payment_enabled', $request->boolean('manual_payment_enabled') ? '1' : '0');

        $enabled = $request->boolean('sslcommerz_enabled');
        $configured = trim($storeId) !== '' && trim((string) SiteSetting::valueFor('sslcommerz_store_passwd', '')) !== '';
        $hasManualMethod = trim((string) ($validated['bkash_payment_number'] ?? '')) !== '' || trim((string) ($validated['nagad_payment_number'] ?? '')) !== '' || (trim((string) ($validated['bank_name'] ?? '')) !== '' && trim((string) ($validated['bank_account_number'] ?? '')) !== '');
        if ($request->boolean('manual_payment_enabled') && !$hasManualMethod) {
            return redirect()->route('admin.payment-settings.edit')->with('warning', 'সেটিংস সেভ হয়েছে, তবে bKash/Nagad বা Bank তথ্য না দেওয়া পর্যন্ত রোগী কোনো manual payment method দেখতে পাবে না।');
        }
        $message = $enabled && !$configured
            ? 'সেটিংস সেভ হয়েছে, কিন্তু SSLCommerz চালাতে Store ID ও Store Password দিতে হবে।'
            : 'Payment settings সফলভাবে সেভ হয়েছে।';

        return redirect()->route('admin.payment-settings.edit')->with($enabled && !$configured ? 'warning' : 'success', $message);
    }
}
