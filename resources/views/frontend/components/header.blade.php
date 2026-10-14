@php
    $mainPhoneDisplay = trim((string)($adminPublicSettings['public_phone'] ?? '01912-200200'));
    $secondaryPhoneDisplay = trim((string)($adminPublicSettings['secondary_public_phone'] ?? '01640-167617'));
    $mainPhoneHref = preg_replace('/[^0-9+]/', '', $mainPhoneDisplay);
    $secondaryPhoneHref = preg_replace('/[^0-9+]/', '', $secondaryPhoneDisplay);
@endphp
<div class="topbar py-2">
    <div class="container d-flex justify-content-between align-items-center gap-3">

        <!-- Left: Phone Numbers -->
        <div class="d-flex gap-3 phone-info">

            <span>
                <i class="bi bi-telephone me-1"></i>
                <a href="tel:{{ $mainPhoneHref }}">
                    {{ $mainPhoneDisplay }}
                </a>
            </span>

            <span>
                <i class="bi bi-telephone me-1"></i>
                <a href="tel:{{ $secondaryPhoneHref }}">
                    {{ $secondaryPhoneDisplay }}
                </a>
            </span>

            <span class="hide-mobile">
                <i class="bi bi-clock me-1"></i>{{ site_content('shared_header.628', '
                রবি–বুধ: সন্ধ্যা ৬টা–রাত ৮টা
            ') }}</span>

        </div>

        <!-- Right: Address -->
        <span class="address-info">
            <i class="bi bi-geo-alt me-1"></i>{{ site_content('shared_header.629', '
            ইসলামী ব্যাংক হাসপাতাল, ঝিনাইদহ।
        ') }}</span>

    </div>
</div>


<!-- Navbar -->
<nav class="navbar navbar-expand-lg sticky-top" id="mainNav">

    <div class="container py-2">

        <!-- Brand -->
        <a
            class="navbar-brand d-flex align-items-center gap-2"
            href="{{ route('home') }}"
        >

            @if(!empty($adminPublicSettings['site_logo_image']))
                <img class="site-logo-image" src="{{ asset('storage/' . $adminPublicSettings['site_logo_image']) }}" alt="{{ $adminPublicSettings['site_logo_alt'] ?? $adminPublicSettings['site_name'] ?? 'Website logo' }}">
            @else
                <div class="brand-mark">
                    <i class="bi bi-heart-pulse"></i>
                </div>
            @endif

            <div class="brand-title">
                <strong>{{ site_content('shared_header.630', $adminPublicSettings['site_name'] ?? 'ডা. অমিত হাসান') }}</strong>

                <small class="tagline">{{ site_content('shared_header.631', '
                    শিশু ও নবজাতক সার্জন
                ') }}</small>
            </div>

        </a>


        <!-- Right Side -->
        <div class="d-flex align-items-center gap-2 order-lg-3">

            <!-- Theme Toggle -->
            <button
                aria-label="Theme"
                class="icon-btn"
                id="themeToggle"
                type="button"
            >
                <i class="bi bi-moon-stars"></i>
            </button>


            <!-- Appointment -->
            <a
                class="btn btn-primary-custom d-none d-sm-inline-block"
                href="{{ route('appointment') }}"
            >{{ site_content('shared_header.632', '
                অ্যাপয়েন্টমেন্ট
            ') }}</a>


            <!-- Mobile Menu -->
            <button
                class="navbar-toggler border-0"
                data-bs-target="#navMenu"
                data-bs-toggle="collapse"
                type="button"
                aria-label="Toggle navigation"
            >
                <i class="bi bi-list fs-2"></i>
            </button>

        </div>


        <!-- Navigation -->
        <div
            class="collapse navbar-collapse order-lg-2"
            id="navMenu"
        >

            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">

                <!-- Home -->
                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                        href="{{ route('home') }}"
                    >{{ site_content('shared_header.633', '
                        হোম
                    ') }}</a>
                </li>


                <!-- About -->
                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}"
                        href="{{ route('about') }}"
                    >{{ site_content('shared_header.634', '
                        পরিচিতি
                    ') }}</a>
                </li>


                <!-- Services -->
                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}"
                        href="{{ route('services') }}"
                    >{{ site_content('shared_header.635', '
                        সেবা
                    ') }}</a>
                </li>


                <!-- Blog -->
                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('blog', 'blog.view') ? 'active' : '' }}"
                        href="{{ route('blog') }}"
                    >{{ site_content('shared_header.636', '
                        ব্লগ
                    ') }}</a>
                </li>


                <!-- FAQ -->
                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('faq') ? 'active' : '' }}"
                        href="{{ route('faq') }}"
                    >{{ site_content('shared_header.637', '
                        FAQ
                    ') }}</a>
                </li>


                <!-- Contact -->
                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                        href="{{ route('contact') }}"
                    >{{ site_content('shared_header.638', '
                        যোগাযোগ
                    ') }}</a>
                </li>

                <!-- Patient Portal -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('patient.*', 'login', 'register') ? 'active' : '' }}"
                       href="{{ auth()->check() ? (auth()->user()->hasRole('Patient') ? route('patient.dashboard') : route('dashboard')) : route('login') }}">
                        {{ auth()->check() ? (auth()->user()->hasRole('Patient') ? 'পেশেন্ট প্যানেল' : 'ড্যাশবোর্ড') : 'পেশেন্ট লগইন' }}
                    </a>
                </li>

            </ul>

        </div>

    </div>

</nav>