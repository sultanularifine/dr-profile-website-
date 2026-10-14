@extends('frontend.layouts.app')

@section('title', 'চিকিৎসাসেবা | ডা. অমিত হাসান')

@section('content')

<section class="section section-soft">
<div class="container">
<div class="section-head" data-aos="fade-up">
<div class="section-kicker">{{ site_content('services.343', 'SPECIALIZED SERVICES') }}</div>
<h2>{{ site_content('services.344', 'চিকিৎসা ও সেবাসমূহ') }}</h2>
<p>{{ site_content('services.345', 'শিশু ও নবজাতকের বিভিন্ন সাধারণ, সার্জিক্যাল ও বিশেষায়িত সমস্যার জন্য পরামর্শ, চিকিৎসা ও প্রয়োজনীয়
          পুনর্বাসন সেবা।') }}</p>
</div>
<div class="row g-4" id="serviceGrid"></div>
</div>
</section>

<section class="section">
<div class="container">
<div class="section-head" data-aos="fade-up">
<div class="section-kicker">{{ site_content('services.346', 'CONDITIONS') }}</div>
<h2>{{ site_content('services.347', 'যেসব রোগ ও সমস্যা দেখা হয়') }}</h2>
<p>{{ site_content('services.348', 'নিচের ক্যাটাগরি থেকে বেছে নিয়ে প্রাসঙ্গিক সমস্যাগুলো দ্রুত খুঁজে দেখুন।') }}</p>
</div>
<div class="filter-wrap" id="conditionFilters"></div>
<div class="row g-3" id="conditionGrid"></div>
</div>
</section>

<footer class="pt-5 pb-4">
<div class="container">
<div class="row g-4">
<!-- Doctor -->
<div class="col-lg-5">
<h4 class="footer-title">{{ site_content('services.349', '
            ডা. অমিত হাসান
          ') }}</h4>
<p class="mb-3">{{ site_content('services.350', '
            শিশু, কিশোর, নবজাতক বিশেষজ্ঞ ও সার্জন।
          ') }}</p>
<div class="d-flex gap-2">
<a aria-label="Facebook" class="social" href="#">
<i class="bi bi-facebook"></i>
</a>
<a aria-label="LinkedIn" class="social" href="#">
<i class="bi bi-linkedin"></i>
</a>
</div>
</div>
<!-- Quick Links -->
<div class="col-6 col-lg-3">
<h6 class="footer-title">{{ site_content('services.351', '
            দ্রুত লিংক
          ') }}</h6>
<div class="d-flex flex-column gap-2">
<a href="{{ route('about') }}">{{ site_content('services.352', '
              পরিচিতি
            ') }}</a>
<a href="{{ route('services') }}">{{ site_content('services.353', '
              সেবা
            ') }}</a>
<a href="{{ url('/conditions') }}">{{ site_content('services.354', '
              রোগসমূহ
            ') }}</a>
<a href="{{ route('appointment') }}">{{ site_content('services.355', '
              অ্যাপয়েন্টমেন্ট
            ') }}</a>
<a href="{{ route('faq') }}">{{ site_content('services.356', '
              সাধারণ জিজ্ঞাসা
            ') }}</a>
<a href="{{ route('contact') }}">{{ site_content('services.357', '
              যোগাযোগ
            ') }}</a>
</div>
</div>
<!-- Chamber -->
<div class="col-6 col-lg-4">
<h6 class="footer-title">{{ site_content('services.358', '
            চেম্বার
          ') }}</h6>
<p class="mb-1">{{ site_content('services.359', '
            ইসলামী ব্যাংক কমিউনিটি হাসপাতাল
            ঝিনাইদহ লিঃ
          ') }}</p>
<p class="small mb-1">{{ site_content('services.360', '
            চুয়াডাঙ্গা বাসস্ট্যান্ড,
            ঝিনাইদহ।
          ') }}</p>
<p class="small mb-1">{{ site_content('services.361', '
            শুক্রবার: বিকাল ৪টা – রাত ৮টা
          ') }}</p>
<a href="tel:+8801640167617">{{ site_content('services.362', '
            ০১৬৪০-১৬৭৬১৭
          ') }}</a>
<br/>
<a href="mailto:ibchj@gmail.com">
            ibchj@gmail.com
          </a>
</div>
</div>
<hr class="border-light opacity-10 my-4"/>
<div class="d-flex flex-wrap justify-content-between gap-2 small">
<span>
          © <span id="year"></span>{{ site_content('services.363', '
          Dr. Amit Hasan. All rights reserved.
        ') }}</span>
</div>
</div>
</footer>

@endsection

@push('scripts')
<script src="{{ asset('assets/services.js') }}"></script>
<script src="{{ asset('assets/conditions.js') }}"></script>
@endpush
