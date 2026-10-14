<!DOCTYPE html>
<html lang="bn" data-theme="light">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="theme-color" content="#075b8f">

    @php
        $fallbackTitle = $adminPublicSettings['default_seo_title'] ?? 'ডা. অমিত হাসান | শিশু ও নবজাতক সার্জন';
        $fallbackDescription = $adminPublicSettings['default_seo_description'] ?? 'ডা. অমিত হাসান শিশু, কিশোর ও নবজাতক বিশেষজ্ঞ এবং শিশু সার্জন। ঢাকা ও ঝিনাইদহে বিশেষজ্ঞ পরামর্শ ও অ্যাপয়েন্টমেন্ট।';
        $sectionTitle = trim((string) $__env->yieldContent('title', $fallbackTitle));
        $sectionDescription = trim((string) $__env->yieldContent('meta_description', $fallbackDescription));
        $seoTitle = trim((string) ($adminSeoPage?->seo_title ?: ($sectionTitle ?: $fallbackTitle)));
        $seoDescription = trim((string) ($adminSeoPage?->meta_description ?: ($sectionDescription ?: $fallbackDescription)));
        $seoOgTitle = trim((string) ($adminSeoPage?->og_title ?: $seoTitle));
        $seoOgDescription = trim((string) ($adminSeoPage?->og_description ?: $seoDescription));
        $seoOgImage = $adminSeoPage?->og_image ?: ($adminPublicSettings['default_og_image'] ?? null);
        $seoOgImageUrl = $seoOgImage ? (preg_match('/^https?:\/\//i', $seoOgImage) ? $seoOgImage : asset('storage/' . ltrim($seoOgImage, '/'))) : null;
        $siteName = $adminPublicSettings['site_name'] ?? 'ডা. অমিত হাসান';
        $consentUiEnabled = (string)($adminPublicSettings['cookie_consent_enabled'] ?? '1') === '1';
        $analyticsConsent = (bool) session('site_consent_analytics', false);
        $marketingConsent = (bool) session('site_consent_marketing', false);
        $ga4Id = (string)($adminPublicSettings['ga4_measurement_id'] ?? '');
        $ga4Ready = preg_match('/^G-[A-Z0-9]+$/i', $ga4Id) === 1;
        $adsId = (string)($adminPublicSettings['google_ads_conversion_id'] ?? '');
        $adsReady = preg_match('/^AW-[0-9]+$/i', $adsId) === 1;
        $gtmId = (string)($adminPublicSettings['gtm_container_id'] ?? '');
        $gtmReady = preg_match('/^GTM-[A-Z0-9]+$/i', $gtmId) === 1;
        $pixelId = (string)($adminPublicSettings['meta_pixel_id'] ?? '');
        $pixelReady = preg_match('/^[0-9]{5,30}$/', $pixelId) === 1;
        $loadGtag = (($analyticsConsent && (string)($adminPublicSettings['ga4_enabled'] ?? '0') === '1' && $ga4Ready)
            || ($marketingConsent && (string)($adminPublicSettings['google_ads_enabled'] ?? '0') === '1' && $adsReady));
        $gtagLoaderId = ($analyticsConsent && (string)($adminPublicSettings['ga4_enabled'] ?? '0') === '1' && $ga4Ready) ? $ga4Id : $adsId;
    @endphp

    <meta name="description" content="{{ $seoDescription }}">
    <meta name="author" content="{{ $siteName }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="{{ ($adminSeoPage?->robots_index ?? true) ? 'index' : 'noindex' }},{{ ($adminSeoPage?->robots_follow ?? true) ? 'follow' : 'nofollow' }}">
    @if($adminSeoPage?->canonical_url)<link rel="canonical" href="{{ $adminSeoPage->canonical_url }}">@endif
    @if(!empty($adminPublicSettings['google_site_verification']))<meta name="google-site-verification" content="{{ $adminPublicSettings['google_site_verification'] }}">@endif

    <title>{{ $seoTitle }}</title>

    @if(!$adminIsBlogDetail)
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="{{ $siteName }}">
        <meta property="og:title" content="{{ $seoOgTitle }}">
        <meta property="og:description" content="{{ $seoOgDescription }}">
        <meta property="og:url" content="{{ url()->current() }}">
        @if($seoOgImageUrl)<meta property="og:image" content="{{ $seoOgImageUrl }}">@endif
        <meta name="twitter:card" content="{{ $adminSeoPage?->twitter_card ?: 'summary_large_image' }}">
        <meta name="twitter:title" content="{{ $seoOgTitle }}">
        <meta name="twitter:description" content="{{ $seoOgDescription }}">
        @if($seoOgImageUrl)<meta name="twitter:image" content="{{ $seoOgImageUrl }}">@endif
    @endif
    @stack('meta')

    @if($loadGtag)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gtagLoaderId }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            @if($analyticsConsent && (string)($adminPublicSettings['ga4_enabled'] ?? '0') === '1' && $ga4Ready)
                gtag('config', @json($ga4Id), {anonymize_ip: true});
            @endif
            @if($marketingConsent && (string)($adminPublicSettings['google_ads_enabled'] ?? '0') === '1' && $adsReady)
                gtag('config', @json($adsId));
            @endif
        </script>
    @endif
    @if($marketingConsent && (string)($adminPublicSettings['gtm_enabled'] ?? '0') === '1' && $gtmReady)
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer',@json($gtmId));</script>
    @endif
    @if($marketingConsent && (string)($adminPublicSettings['meta_pixel_enabled'] ?? '0') === '1' && $pixelReady)
        <script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');fbq('init',@json($pixelId));fbq('track','PageView');</script>
    @endif


    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Noto+Serif+Bengali:wght@500;600;700&display=swap"
        rel="stylesheet">


    {{-- Bootstrap --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">


    {{-- Bootstrap Icons --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet">


    {{-- AOS --}}
    <link
        href="https://unpkg.com/aos@2.3.4/dist/aos.css"
        rel="stylesheet">


    {{-- Main CSS --}}
    <link
        rel="stylesheet"
        href="{{ asset('frontend/css/style.css') }}">


    {{-- Blog CSS --}}
    <link
        rel="stylesheet"
        href="{{ asset('frontend/css/blog.css') }}">


    {{-- Page Specific CSS --}}
    @stack('styles')

    @yield('style')
    <style>
        .cookie-consent-panel{position:fixed;z-index:1090;left:16px;right:16px;bottom:16px;max-width:920px;margin:0 auto;background:#fff;color:#243746;border:1px solid #dfe7ef;border-radius:12px;box-shadow:0 12px 40px rgba(8,40,60,.18);padding:18px;font-family:inherit}
        .cookie-consent-content{display:grid;grid-template-columns:minmax(200px,1.2fr) minmax(150px,.8fr);gap:12px 20px;align-items:start}
        .cookie-consent-copy p{font-size:14px;line-height:1.5;color:#596c78}
        .cookie-consent-options{display:flex;flex-wrap:wrap;gap:8px 14px;font-size:13px}
        .cookie-consent-options label{display:flex;align-items:center;gap:5px}
        .cookie-consent-actions{grid-column:1/-1;display:flex;justify-content:flex-end;flex-wrap:wrap;gap:8px}
        .cookie-consent-manage{position:fixed;z-index:1080;left:14px;bottom:14px;border:1px solid #cad6df;border-radius:999px;padding:8px 13px;background:#fff;color:#075b8f;font-size:12px;box-shadow:0 3px 12px rgba(0,0,0,.10)}
        @media(max-width:600px){.cookie-consent-content{grid-template-columns:1fr}.cookie-consent-actions{justify-content:stretch}.cookie-consent-actions .btn{flex:1 1 100%}}
    </style>

</head>


<body>

    @if($marketingConsent && (string)($adminPublicSettings['gtm_enabled'] ?? '0') === '1' && $gtmReady)
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtmId }}" height="0" width="0" style="display:none;visibility:hidden" title="Google Tag Manager"></iframe></noscript>
    @endif

    {{-- Header --}}
    @include('frontend.components.header')


    {{-- Main Content --}}
    <main>

        @yield('content')

    </main>


    {{-- Footer --}}
    @include('frontend.components.footer')


    {{-- Mobile Appointment --}}
    <a
        class="mobile-appointment-btn"
        href="{{ route('appointment') }}"
    >

        <i class="bi bi-calendar-check-fill"></i>

        <span>
            অ্যাপয়েন্টমেন্ট
        </span>

    </a>


    {{-- Back To Top --}}
    <button
        aria-label="Back to top"
        id="backToTop"
        type="button"
    >

        <i class="bi bi-arrow-up"></i>

    </button>


    {{-- Toast --}}
    <div class="toast-wrap">

        <div
            class="toast-custom"
            id="toast">
        </div>

    </div>


    @if($consentUiEnabled)
        <div id="cookie-consent-banner" role="dialog" aria-live="polite" aria-label="Cookie preferences" class="cookie-consent-panel" style="display:{{ session()->has('site_consent_choice') ? 'none' : 'block' }}">
            <div class="cookie-consent-content">
                <div class="cookie-consent-copy"><strong>আপনার গোপনীয়তা</strong><p class="mb-2">প্রয়োজনীয় cookie সাইট চালাতে ব্যবহৃত হয়। আপনার অনুমতি ছাড়া ঐচ্ছিক analytics বা marketing tag চালু হবে না।</p></div>
                <div class="cookie-consent-options">
                    <label><input type="checkbox" checked disabled> প্রয়োজনীয়</label>
                    <label><input type="checkbox" id="consent-analytics" @checked((bool)session('site_consent_analytics', false))> Analytics</label>
                    <label><input type="checkbox" id="consent-marketing" @checked((bool)session('site_consent_marketing', false))> Marketing</label>
                </div>
                <div class="cookie-consent-actions">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-consent-reject>ঐচ্ছিক cookie প্রত্যাখ্যান</button>
                    <button type="button" class="btn btn-sm btn-outline-primary" data-consent-save>পছন্দ সংরক্ষণ</button>
                    <button type="button" class="btn btn-sm btn-primary" data-consent-accept>সব গ্রহণ</button>
                </div>
                <small id="cookie-consent-error" class="text-danger" aria-live="polite"></small>
            </div>
        </div>
        <button type="button" id="cookie-consent-manage" class="cookie-consent-manage" style="display:{{ session()->has('site_consent_choice') ? 'inline-flex' : 'none' }}">Cookie preferences</button>
    @endif

    {{-- Bootstrap JS --}}
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>


    {{-- AOS JS --}}
    <script
        src="https://unpkg.com/aos@2.3.4/dist/aos.js">
    </script>


    {{-- Main JS --}}
    <script src="{{ asset('frontend/js/main.js') }}"></script>


    {{-- Services JS --}}
    <script src="{{ asset('frontend/js/services.js') }}"></script>


    {{-- Conditions JS --}}
    <script src="{{ asset('frontend/js/conditions.js') }}"></script>


    @stack('scripts')

    @yield('scripts')
    @if($consentUiEnabled)
        <script>
        (function(){
            const banner=document.getElementById('cookie-consent-banner');
            const manage=document.getElementById('cookie-consent-manage');
            const analytics=document.getElementById('consent-analytics');
            const marketing=document.getElementById('consent-marketing');
            const errorBox=document.getElementById('cookie-consent-error');
            if(!banner)return;
            async function save(allowAnalytics,allowMarketing){
                errorBox.textContent='';
                const token=document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')||'';
                try{
                    const response=await fetch(@json(route('privacy.consent')),{method:'POST',headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':token},body:JSON.stringify({analytics:!!allowAnalytics,marketing:!!allowMarketing})});
                    if(!response.ok)throw new Error('Consent preferences could not be saved. Please reload the page and try again.');
                    window.location.reload();
                }catch(e){errorBox.textContent=e.message||'Could not save preferences.';}
            }
            document.querySelector('[data-consent-accept]')?.addEventListener('click',()=>save(true,true));
            document.querySelector('[data-consent-reject]')?.addEventListener('click',()=>save(false,false));
            document.querySelector('[data-consent-save]')?.addEventListener('click',()=>save(analytics.checked,marketing.checked));
            manage?.addEventListener('click',()=>{banner.style.display='block';manage.style.display='none';});
        })();
        </script>
    @endif

</body>

</html>