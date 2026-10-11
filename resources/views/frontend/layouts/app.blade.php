<!DOCTYPE html>
<html lang="bn" data-theme="light">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="theme-color" content="#075b8f">

    <meta name="description"
        content="@yield('meta_description', 'ডা. অমিত হাসান শিশু, কিশোর ও নবজাতক বিশেষজ্ঞ এবং শিশু সার্জন। ঢাকা ও ঝিনাইদহে বিশেষজ্ঞ পরামর্শ ও অ্যাপয়েন্টমেন্ট।')">

    <meta name="author" content="ডা. অমিত হাসান">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', 'ডা. অমিত হাসান | শিশু ও নবজাতক সার্জন')
    </title>


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

</head>


<body>


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

</body>

</html>