<?php

return [
    'website' => [
        'title' => 'Website basics',
        'description' => 'Public identity and default SEO values. Leave an optional field blank to keep the original frontend fallback.',
        'fields' => [
            ['key' => 'site_name', 'label' => 'Website name', 'type' => 'text', 'default' => 'ডা. অমিত হাসান', 'max' => 255],
            ['key' => 'site_logo_image', 'label' => 'Website logo image', 'type' => 'image'],
            ['key' => 'site_logo_alt', 'label' => 'Website logo alt text', 'type' => 'text', 'default' => 'ডা. অমিত হাসান', 'max' => 255],
            ['key' => 'public_phone', 'label' => 'Primary public phone', 'type' => 'text', 'default' => '01912-200200', 'max' => 80],
            ['key' => 'secondary_public_phone', 'label' => 'Secondary public phone', 'type' => 'text', 'default' => '01640-167617', 'max' => 80],
            ['key' => 'public_email', 'label' => 'Public email', 'type' => 'email', 'default' => 'ibchj@gmail.com', 'max' => 255],
            ['key' => 'timezone', 'label' => 'Display timezone', 'type' => 'text', 'default' => 'Asia/Dhaka', 'max' => 100],
            ['key' => 'currency', 'label' => 'Currency code', 'type' => 'text', 'default' => 'BDT', 'max' => 5],
            ['key' => 'default_seo_title', 'label' => 'Default SEO title', 'type' => 'text', 'default' => 'ডা. অমিত হাসান | শিশু ও নবজাতক সার্জন', 'max' => 255],
            ['key' => 'default_seo_description', 'label' => 'Default meta description', 'type' => 'textarea', 'default' => 'ডা. অমিত হাসান শিশু, কিশোর ও নবজাতক বিশেষজ্ঞ এবং শিশু সার্জন। ঢাকা ও ঝিনাইদহে বিশেষজ্ঞ পরামর্শ ও অ্যাপয়েন্টমেন্ট।', 'max' => 320],
            ['key' => 'default_og_image', 'label' => 'Default social sharing image', 'type' => 'image'],
        ],
    ],
    'analytics' => [
        'title' => 'Analytics and marketing',
        'description' => 'IDs are configuration only. Optional scripts are loaded only after the visitor grants the corresponding consent. Do not put personal or medical information in analytics events.',
        'fields' => [
            ['key' => 'cookie_consent_enabled', 'label' => 'Show cookie consent banner', 'type' => 'toggle', 'default' => '1'],
            ['key' => 'gtm_enabled', 'label' => 'Enable Google Tag Manager', 'type' => 'toggle', 'default' => '0'],
            ['key' => 'gtm_container_id', 'label' => 'GTM container ID', 'type' => 'text', 'default' => '', 'max' => 30],
            ['key' => 'ga4_enabled', 'label' => 'Enable Google Analytics 4', 'type' => 'toggle', 'default' => '0'],
            ['key' => 'ga4_measurement_id', 'label' => 'GA4 measurement ID', 'type' => 'text', 'default' => '', 'max' => 30],
            ['key' => 'google_site_verification', 'label' => 'Google Search Console verification token', 'type' => 'text', 'default' => '', 'max' => 255],
            ['key' => 'meta_pixel_enabled', 'label' => 'Enable Meta Pixel', 'type' => 'toggle', 'default' => '0'],
            ['key' => 'meta_pixel_id', 'label' => 'Meta Pixel ID', 'type' => 'text', 'default' => '', 'max' => 40],
            ['key' => 'google_ads_enabled', 'label' => 'Enable Google Ads base tag', 'type' => 'toggle', 'default' => '0'],
            ['key' => 'google_ads_conversion_id', 'label' => 'Google Ads conversion ID (AW-...)', 'type' => 'text', 'default' => '', 'max' => 40],
            ['key' => 'google_ads_conversion_label', 'label' => 'Google Ads conversion label', 'type' => 'text', 'default' => '', 'max' => 255],
        ],
    ],
    'payments' => [
        'title' => 'Manual payment instructions',
        'description' => 'Configure instructions and account details for manual payment submissions. Online gateway credentials are managed separately in Payment Settings.',
        'fields' => [
            ['key' => 'manual_payment_enabled', 'label' => 'Enable manual payment submissions', 'type' => 'toggle', 'default' => '0'],
            ['key' => 'payment_instructions', 'label' => 'General payment instructions for patients', 'type' => 'textarea', 'default' => 'Please confirm current payment details with the clinic before transferring money.', 'max' => 2000],
            ['key' => 'bkash_payment_number', 'label' => 'bKash payment number', 'type' => 'text', 'default' => '', 'max' => 80],
            ['key' => 'nagad_payment_number', 'label' => 'Nagad payment number', 'type' => 'text', 'default' => '', 'max' => 80],
            ['key' => 'bank_name', 'label' => 'Bank name', 'type' => 'text', 'default' => '', 'max' => 255],
            ['key' => 'bank_account_name', 'label' => 'Bank account name', 'type' => 'text', 'default' => '', 'max' => 255],
            ['key' => 'bank_account_number', 'label' => 'Bank account number', 'type' => 'text', 'default' => '', 'max' => 120],
        ],
    ],
    'credentials' => [
        'title' => 'Optional provider credentials',
        'description' => 'Secrets are encrypted with APP_KEY and never displayed again after saving. This form stores credentials securely; provider-specific automated meeting creation, SMS and payment adapters still require their own implementation and testing.',
        'fields' => [
            ['key' => 'google_oauth_client_secret', 'label' => 'Google OAuth client secret', 'type' => 'secret'],
            ['key' => 'zoom_api_secret', 'label' => 'Zoom API secret', 'type' => 'secret'],
            ['key' => 'bkash_app_secret', 'label' => 'bKash app secret', 'type' => 'secret'],
            ['key' => 'nagad_merchant_password', 'label' => 'Nagad merchant password', 'type' => 'secret'],
            ['key' => 'sms_api_token', 'label' => 'SMS provider API token', 'type' => 'secret'],
        ],
    ],
];
