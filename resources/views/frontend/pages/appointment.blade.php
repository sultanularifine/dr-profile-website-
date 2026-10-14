@extends('frontend.layouts.app')

@section('title', 'অ্যাপয়েন্টমেন্ট | ডা. অমিত হাসান')

@section('content')

<section class="page-hero">
<div class="container">
<div class="section-head mb-0" data-aos="fade-up">
<div class="section-kicker">{{ site_content('appointment.547', 'APPOINTMENT') }}</div>
<h1>{{ site_content('appointment.548', 'অ্যাপয়েন্টমেন্ট ও চেম্বার') }}</h1>
<p>{{ site_content('appointment.549', 'আপনার সুবিধাজনক হাসপাতাল বা চেম্বার নির্বাচন করে সময়, ঠিকানা ও যোগাযোগের তথ্য দেখুন.') }}</p>
<div class="breadcrumb-wrap">
<nav aria-label="breadcrumb">
<ol class="breadcrumb justify-content-center mb-0">
<li class="breadcrumb-item"><a href="{{ route('home') }}">{{ site_content('appointment.550', 'হোম') }}</a></li>
<li aria-current="page" class="breadcrumb-item active">{{ site_content('appointment.551', 'অ্যাপয়েন্টমেন্ট ও চেম্বার') }}</li>
</ol>
</nav>
</div>
</div>
</div>
</section>

<section class="section">
<div class="container">
<div class="appointment" data-aos="zoom-in">
<div class="row align-items-center g-4 position-relative z-1">
<!-- Left Content -->
<div class="col-lg-6">
<span class="badge rounded-pill bg-light text-primary px-3 py-2">{{ site_content('appointment.552', '
              APPOINTMENT
            ') }}</span>
<h2 class="mt-3">{{ site_content('appointment.553', '
              আপনার শিশুর জন্য পরামর্শ নিতে যোগাযোগ করুন
            ') }}</h2>
<p class="fs-5 mt-3 mb-2">{{ site_content('appointment.554', '
              বিভিন্ন চেম্বার ও হাসপাতাল থেকে আপনার সুবিধাজনক
              স্থানটি নির্বাচন করুন।
            ') }}</p>
<p class="mb-0">
<i class="bi bi-telephone me-2"></i>{{ site_content('appointment.555', '
              সিরিয়াল / সাধারণ যোগাযোগ:
              ') }}<strong>01640-167617</strong>
</p>
</div>
<!-- Right Side -->
<div class="col-lg-6">
<div class="appointment-hospital-list">
@if(isset($chambers) && $chambers->isNotEmpty())
    @php $weekdayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']; @endphp
    @foreach($chambers as $chamber)
        <a class="appointment-hospital" href="{{ route('appointment.book', ['chamber_id' => $chamber->id]) }}" aria-label="Book an appointment at {{ $chamber->name }}">
            <div class="hospital-icon"><i class="bi bi-hospital"></i></div>
            <div class="hospital-info">
                <small>{{ $chamber->hospital_name ?: ($chamber->department ?: 'Hospital / Chamber') }}</small>
                <h5>{{ $chamber->name }}</h5>
                <span>{{ $chamber->address }}</span>
                @if($chamber->schedules->isNotEmpty())
                    @foreach($chamber->schedules->take(2) as $schedule)
                        <span class="d-block">{{ $weekdayNames[(int) $schedule->weekday] ?? 'Schedule' }} · {{ \Illuminate\Support\Carbon::parse('2000-01-01 '.$schedule->starts_at)->format('g:i A') }}–{{ \Illuminate\Support\Carbon::parse('2000-01-01 '.$schedule->ends_at)->format('g:i A') }}</span>
                    @endforeach
                @else
                    <span class="d-block">Call the chamber for visiting hours.</span>
                @endif
                @if($chamber->phone)<span class="d-block">{{ $chamber->phone }}</span>@endif
            </div>
            <div class="hospital-arrow"><i class="bi bi-chevron-right"></i></div>
        </a>
    @endforeach
@else
<!-- Jhenaidah -->
<button class="appointment-hospital" data-bs-target="#jhenaidahHospitalModal" data-bs-toggle="modal" type="button">
<div class="hospital-icon">
<i class="bi bi-hospital"></i>
</div>
<div class="hospital-info">
<small>{{ site_content('appointment.556', 'ঝিনাইদহ') }}</small>
<h5>{{ site_content('appointment.557', '
                    ইসলামী ব্যাংক কমিউনিটি হাসপাতাল ঝিনাইদহ লিঃ
                  ') }}</h5>
<span>{{ site_content('appointment.558', '
                    প্রতি শুক্রবার • বিকাল ৪টা–রাত ৮টা
                  ') }}</span>
</div>
<div class="hospital-arrow">
<i class="bi bi-chevron-right"></i>
</div>
</button>
<!-- Upasham -->
<button class="appointment-hospital" data-bs-target="#upashamModal" data-bs-toggle="modal" type="button">
<div class="hospital-icon">
<i class="bi bi-hospital"></i>
</div>
<div class="hospital-info">
<small>{{ site_content('appointment.559', 'ঢাকা') }}</small>
<h5>{{ site_content('appointment.560', '
                    উপশম হেলথ পয়েন্ট (প্রাঃ) লিঃ
                  ') }}</h5>
<span>{{ site_content('appointment.561', '
                    রবি–বুধবার • সন্ধ্যা ৬টা–রাত ৮টা
                  ') }}</span>
</div>
<div class="hospital-arrow">
<i class="bi bi-chevron-right"></i>
</div>
</button>
<!-- Bangladesh Shishu Hospital -->
<button class="appointment-hospital" data-bs-target="#shishuHospitalModal" data-bs-toggle="modal" type="button">
<div class="hospital-icon">
<i class="bi bi-hospital"></i>
</div>
<div class="hospital-info">
<small>{{ site_content('appointment.562', 'ঢাকা') }}</small>
<h5>{{ site_content('appointment.563', '
                    বাংলাদেশ শিশু হাসপাতাল ও ইনস্টিটিউট
                  ') }}</h5>
<span>{{ site_content('appointment.564', '
                    শিশু ও নবজাতক বিশেষজ্ঞ সেবা
                  ') }}</span>
</div>
<div class="hospital-arrow">
<i class="bi bi-chevron-right"></i>
</div>
</button>
@endif
</div>
</div>
</div>
</div>
</div>
</section>

<section class="section pt-0">
<div class="container">
    <div class="appointment-booking-portal p-4 p-lg-5 rounded-4" style="background:var(--bs-light, #f7f9fc);border:1px solid rgba(20,91,136,.12);">
        <div class="row align-items-center g-3">
            <div class="col-lg-8">
                <span class="text-primary fw-semibold">ONLINE PATIENT PORTAL</span>
                <h3 class="mt-2 mb-2">অনলাইনে সিরিয়াল নিন ও রিপোর্ট দেখুন</h3>
                <p class="mb-0">Patient account থেকে appointment request, payment status, consultation link এবং published prescription দেখুন।</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a class="btn btn-primary btn-lg mb-2" href="{{ route('appointment.book') }}">অনলাইনে অ্যাপয়েন্টমেন্ট নিন</a>
                @guest
                    <div><a href="{{ route('login') }}">Patient login</a> <span class="mx-1">·</span> <a href="{{ route('register') }}">Create patient account</a></div>
                @else
                    <div><a href="{{ auth()->user()->hasRole('Patient') ? route('patient.dashboard') : route('dashboard') }}">Dashboard খুলুন</a></div>
                @endguest
            </div>
        </div>
    </div>
</div>
</section>

<footer class="pt-5 pb-4">
<div class="container">
<div class="row g-4">
<!-- Doctor -->
<div class="col-lg-5">
<h4 class="footer-title">{{ site_content('appointment.565', '
            ডা. অমিত হাসান
          ') }}</h4>
<p class="mb-3">{{ site_content('appointment.566', '
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
<h6 class="footer-title">{{ site_content('appointment.567', '
            দ্রুত লিংক
          ') }}</h6>
<div class="d-flex flex-column gap-2">
<a href="{{ route('about') }}">{{ site_content('appointment.568', '
              পরিচিতি
            ') }}</a>
<a href="{{ route('services') }}">{{ site_content('appointment.569', '
              সেবা
            ') }}</a>
<a href="{{ url('/conditions') }}">{{ site_content('appointment.570', '
              রোগসমূহ
            ') }}</a>
<a href="{{ route('appointment') }}">{{ site_content('appointment.571', '
              অ্যাপয়েন্টমেন্ট
            ') }}</a>
<a href="{{ route('faq') }}">{{ site_content('appointment.572', '
              সাধারণ জিজ্ঞাসা
            ') }}</a>
<a href="{{ route('contact') }}">{{ site_content('appointment.573', '
              যোগাযোগ
            ') }}</a>
</div>
</div>
<!-- Chamber -->
<div class="col-6 col-lg-4">
<h6 class="footer-title">{{ site_content('appointment.574', '
            চেম্বার
          ') }}</h6>
<p class="mb-1">{{ site_content('appointment.575', '
            ইসলামী ব্যাংক কমিউনিটি হাসপাতাল
            ঝিনাইদহ লিঃ
          ') }}</p>
<p class="small mb-1">{{ site_content('appointment.576', '
            চুয়াডাঙ্গা বাসস্ট্যান্ড,
            ঝিনাইদহ।
          ') }}</p>
<p class="small mb-1">{{ site_content('appointment.577', '
            শুক্রবার: বিকাল ৪টা – রাত ৮টা
          ') }}</p>
<a href="tel:+8801640167617">{{ site_content('appointment.578', '
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
          © <span id="year"></span>{{ site_content('appointment.579', '
          Dr. Amit Hasan. All rights reserved.
        ') }}</span>
</div>
</div>
</footer>

<div aria-hidden="true" aria-labelledby="upashamModalLabel" class="modal fade appointment-modal" id="upashamModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<!-- Header -->
<div class="modal-header">
<div>
<span class="modal-kicker">{{ site_content('appointment.580', '
              APPOINTMENT • DHAKA
            ') }}</span>
<h4 class="modal-title mt-1" id="upashamModalLabel">{{ site_content('appointment.581', '
              উপশম হেলথ পয়েন্ট (প্রাঃ) লিঃ
            ') }}</h4>
</div>
<button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
</button>
</div>
<!-- Body -->
<div class="modal-body">
<div class="appointment-detail-card">
<div class="appointment-detail-icon">
<i class="bi bi-hospital"></i>
</div>
<div>
<h5>{{ site_content('appointment.582', 'হাসপাতাল ও ডায়াগনস্টিক') }}</h5>
<p class="text-secondary mb-0">{{ site_content('appointment.583', '
                বাড়ি # ১৪, রোড # ২/বি, ব্লক # জে (দক্ষিণ),
                বারিধারা, ঢাকা-১২১২।
              ') }}</p>
</div>
</div>
<div class="appointment-info-grid">
<!-- Time -->
<div class="appointment-info">
<i class="bi bi-clock"></i>
<div>
<small>{{ site_content('appointment.584', 'রোগী দেখার সময়') }}</small>
<strong>{{ site_content('appointment.585', '
                  রবি থেকে বুধবার
                ') }}</strong>
<span>{{ site_content('appointment.586', '
                  সন্ধ্যা ৬টা থেকে রাত ৮টা
                ') }}</span>
</div>
</div>
<!-- Common -->
<div class="appointment-info">
<i class="bi bi-phone"></i>
<div>
<small>{{ site_content('appointment.587', 'সিরিয়াল / সাধারণ যোগাযোগ') }}</small>
<a href="tel:01640167617">
                  01640-167617
                </a>
</div>
</div>
<!-- Hospital -->
<div class="appointment-info">
<i class="bi bi-telephone"></i>
<div>
<small>{{ site_content('appointment.588', 'হাসপাতাল যোগাযোগ') }}</small>
<a href="tel:01932200200">
                  01932-200200
                </a>
<a href="tel:01713888100">
                  01713-888100
                </a>
</div>
</div>
</div>
</div>
<!-- Footer -->
<div class="modal-footer">
<button class="btn btn-light" data-bs-dismiss="modal" type="button">{{ site_content('appointment.589', '
            বন্ধ করুন
          ') }}</button>
<a class="btn btn-primary" href="tel:01640167617">
<i class="bi bi-telephone me-2"></i>{{ site_content('appointment.590', '
            সিরিয়ালের জন্য কল করুন

          ') }}</a>
</div>
</div>
</div>
</div>

<div aria-hidden="true" aria-labelledby="shishuHospitalModalLabel" class="modal fade appointment-modal" id="shishuHospitalModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">
<div>
<span class="modal-kicker">{{ site_content('appointment.591', '
              APPOINTMENT • DHAKA
            ') }}</span>
<h4 class="modal-title mt-1" id="shishuHospitalModalLabel">{{ site_content('appointment.592', '
              বাংলাদেশ শিশু হাসপাতাল ও ইনস্টিটিউট
            ') }}</h4>
</div>
<button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
</button>
</div>
<div class="modal-body">
<div class="appointment-detail-card">
<div class="appointment-detail-icon">
<i class="bi bi-hospital"></i>
</div>
<div>
<h5>{{ site_content('appointment.593', '
                শিশু, কিশোর ও নবজাতক বিশেষজ্ঞ সেবা
              ') }}</h5>
<p class="text-secondary mb-0">{{ site_content('appointment.594', '
                শেরে বাংলা নগর, ঢাকা।
              ') }}</p>
</div>
</div>
<div class="appointment-info-grid">
<!-- Service -->
<div class="appointment-info">
<i class="bi bi-heart-pulse"></i>
<div>
<small>{{ site_content('appointment.595', 'বিশেষজ্ঞ সেবা') }}</small>
<strong>{{ site_content('appointment.596', '
                  শিশু সার্জারি
                ') }}</strong>
<span>{{ site_content('appointment.597', '
                  শিশু, কিশোর ও নবজাতকের চিকিৎসা ও সার্জিক্যাল সেবা
                ') }}</span>
</div>
</div>
<!-- Contact -->
<div class="appointment-info">
<i class="bi bi-phone"></i>
<div>
<small>{{ site_content('appointment.598', 'সিরিয়াল / সাধারণ যোগাযোগ') }}</small>
<a href="tel:01640167617">
                  01640-167617
                </a>
</div>
</div>
<!-- Location -->
<div class="appointment-info">
<i class="bi bi-geo-alt"></i>
<div>
<small>{{ site_content('appointment.599', 'ঠিকানা') }}</small>
<strong>{{ site_content('appointment.600', '
                  শেরে বাংলা নগর
                ') }}</strong>
<span>{{ site_content('appointment.601', '
                  ঢাকা
                ') }}</span>
</div>
</div>
</div>
</div>
<div class="modal-footer">
<button class="btn btn-light" data-bs-dismiss="modal" type="button">{{ site_content('appointment.602', '
            বন্ধ করুন
          ') }}</button>
<a class="btn btn-primary" href="tel:01640167617">
<i class="bi bi-telephone me-2"></i>{{ site_content('appointment.603', '
            সিরিয়ালের জন্য কল করুন

          ') }}</a>
</div>
</div>
</div>
</div>

<div aria-hidden="true" aria-labelledby="jhenaidahHospitalModalLabel" class="modal fade appointment-modal" id="jhenaidahHospitalModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">
<div>
<span class="modal-kicker">{{ site_content('appointment.604', '
              APPOINTMENT • JHENAIDAH
            ') }}</span>
<h4 class="modal-title mt-1" id="jhenaidahHospitalModalLabel">{{ site_content('appointment.605', '

              ইসলামী ব্যাংক কমিউনিটি হাসপাতাল
              ঝিনাইদহ লিঃ

            ') }}</h4>
</div>
<button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
</button>
</div>
<div class="modal-body">
<div class="appointment-detail-card">
<div class="appointment-detail-icon">
<i class="bi bi-hospital"></i>
</div>
<div>
<h5>{{ site_content('appointment.606', '
                ইসলামী ব্যাংক কমিউনিটি হাসপাতাল
              ') }}</h5>
<p class="text-secondary mb-0">{{ site_content('appointment.607', '
                চুয়াডাঙ্গা বাসস্ট্যান্ড, ঝিনাইদহ।
              ') }}</p>
</div>
</div>
<div class="appointment-info-grid">
<!-- Time -->
<div class="appointment-info">
<i class="bi bi-clock"></i>
<div>
<small>{{ site_content('appointment.608', 'রোগী দেখার সময়') }}</small>
<strong>{{ site_content('appointment.609', '
                  প্রতি শুক্রবার
                ') }}</strong>
<span>{{ site_content('appointment.610', '
                  বিকাল ৪টা থেকে রাত ৮টা
                ') }}</span>
</div>
</div>
<!-- Hospital Phone -->
<div class="appointment-info">
<i class="bi bi-telephone"></i>
<div>
<small>{{ site_content('appointment.611', 'হাসপাতাল যোগাযোগ') }}</small>
<a href="tel:01716853022">
                  01716-853022
                </a>
<a href="tel:01712058201">
                  01712-058201
                </a>
</div>
</div>
<!-- Common Number -->
<div class="appointment-info">
<i class="bi bi-phone"></i>
<div>
<small>{{ site_content('appointment.612', 'সিরিয়াল / সাধারণ যোগাযোগ') }}</small>
<a href="tel:01640167617">
                  01640-167617
                </a>
</div>
</div>
<!-- Email -->
<div class="appointment-info">
<i class="bi bi-envelope"></i>
<div>
<small>{{ site_content('appointment.613', 'ই-মেইল') }}</small>
<a href="mailto:ibchj@gmail.com">
                  ibchj@gmail.com
                </a>
</div>
</div>
</div>
</div>
<div class="modal-footer">
<button class="btn btn-light" data-bs-dismiss="modal" type="button">{{ site_content('appointment.614', '
            বন্ধ করুন
          ') }}</button>
<a class="btn btn-primary" href="tel:01640167617">
<i class="bi bi-telephone me-2"></i>{{ site_content('appointment.615', '
            সিরিয়ালের জন্য কল করুন

          ') }}</a>
</div>
</div>
</div>
</div>

<div class="modal fade" id="appointmentModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content border-0 rounded-4">
<div class="modal-header">
<h5 class="modal-title">{{ site_content('appointment.616', 'অ্যাপয়েন্টমেন্ট রিকোয়েস্ট') }}</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>
<form id="appointmentForm">
<div class="modal-body">
<div class="mb-3"><label class="form-label">{{ site_content('appointment.617', 'রোগীর নাম') }}</label><input class="form-control" required=""/>
</div>
<div class="mb-3"><label class="form-label">{{ site_content('appointment.618', 'অভিভাবকের ফোন') }}</label><input class="form-control" required="" type="tel"/></div>
<div class="row g-3">
<div class="col-6"><label class="form-label">{{ site_content('appointment.619', 'তারিখ') }}</label><input class="form-control" required="" type="date"/></div>
<div class="col-6"><label class="form-label">{{ site_content('appointment.620', 'সময়') }}</label><select class="form-select">
<option>{{ site_content('appointment.621', 'সন্ধ্যা ৬:০০') }}</option>
<option>{{ site_content('appointment.622', 'সন্ধ্যা ৬:৩০') }}</option>
<option>{{ site_content('appointment.623', 'সন্ধ্যা ৭:০০') }}</option>
<option>{{ site_content('appointment.624', 'সন্ধ্যা ৭:৩০') }}</option>
</select></div>
</div>
<div class="mt-3"><label class="form-label">{{ site_content('appointment.625', 'সমস্যার সংক্ষিপ্ত বিবরণ') }}</label><textarea class="form-control" rows="3"></textarea></div>
</div>
<div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal" type="button">{{ site_content('appointment.626', 'বন্ধ
              করুন') }}</button><button class="btn btn-primary-custom">{{ site_content('appointment.627', 'রিকোয়েস্ট পাঠান') }}</button></div>
</form>
</div>
</div>
</div>

@endsection
