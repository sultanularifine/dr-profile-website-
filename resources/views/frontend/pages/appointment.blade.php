@extends('frontend.layouts.app')

@section('title', 'অ্যাপয়েন্টমেন্ট | ডা. অমিত হাসান')

@section('content')

<section class="page-hero">
<div class="container">
<div class="section-head mb-0" data-aos="fade-up">
<div class="section-kicker">APPOINTMENT</div>
<h1>অ্যাপয়েন্টমেন্ট ও চেম্বার</h1>
<p>আপনার সুবিধাজনক হাসপাতাল বা চেম্বার নির্বাচন করে সময়, ঠিকানা ও যোগাযোগের তথ্য দেখুন.</p>
<div class="breadcrumb-wrap">
<nav aria-label="breadcrumb">
<ol class="breadcrumb justify-content-center mb-0">
<li class="breadcrumb-item"><a href="{{ route('home') }}">হোম</a></li>
<li aria-current="page" class="breadcrumb-item active">অ্যাপয়েন্টমেন্ট ও চেম্বার</li>
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
<span class="badge rounded-pill bg-light text-primary px-3 py-2">
              APPOINTMENT
            </span>
<h2 class="mt-3">
              আপনার শিশুর জন্য পরামর্শ নিতে যোগাযোগ করুন
            </h2>
<p class="fs-5 mt-3 mb-2">
              বিভিন্ন চেম্বার ও হাসপাতাল থেকে আপনার সুবিধাজনক
              স্থানটি নির্বাচন করুন।
            </p>
<p class="mb-0">
<i class="bi bi-telephone me-2"></i>
              সিরিয়াল / সাধারণ যোগাযোগ:
              <strong>01640-167617</strong>
</p>
</div>
<!-- Right Side -->
<div class="col-lg-6">
<div class="appointment-hospital-list">
<!-- Jhenaidah -->
<button class="appointment-hospital" data-bs-target="#jhenaidahHospitalModal" data-bs-toggle="modal" type="button">
<div class="hospital-icon">
<i class="bi bi-hospital"></i>
</div>
<div class="hospital-info">
<small>ঝিনাইদহ</small>
<h5>
                    ইসলামী ব্যাংক কমিউনিটি হাসপাতাল ঝিনাইদহ লিঃ
                  </h5>
<span>
                    প্রতি শুক্রবার • বিকাল ৪টা–রাত ৮টা
                  </span>
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
<small>ঢাকা</small>
<h5>
                    উপশম হেলথ পয়েন্ট (প্রাঃ) লিঃ
                  </h5>
<span>
                    রবি–বুধবার • সন্ধ্যা ৬টা–রাত ৮টা
                  </span>
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
<small>ঢাকা</small>
<h5>
                    বাংলাদেশ শিশু হাসপাতাল ও ইনস্টিটিউট
                  </h5>
<span>
                    শিশু ও নবজাতক বিশেষজ্ঞ সেবা
                  </span>
</div>
<div class="hospital-arrow">
<i class="bi bi-chevron-right"></i>
</div>
</button>
</div>
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
<h4 class="footer-title">
            ডা. অমিত হাসান
          </h4>
<p class="mb-3">
            শিশু, কিশোর, নবজাতক বিশেষজ্ঞ ও সার্জন।
          </p>
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
<h6 class="footer-title">
            দ্রুত লিংক
          </h6>
<div class="d-flex flex-column gap-2">
<a href="{{ route('about') }}">
              পরিচিতি
            </a>
<a href="{{ route('services') }}">
              সেবা
            </a>
<a href="{{ url('/conditions') }}">
              রোগসমূহ
            </a>
<a href="{{ route('appointment') }}">
              অ্যাপয়েন্টমেন্ট
            </a>
<a href="{{ route('faq') }}">
              সাধারণ জিজ্ঞাসা
            </a>
<a href="{{ route('contact') }}">
              যোগাযোগ
            </a>
</div>
</div>
<!-- Chamber -->
<div class="col-6 col-lg-4">
<h6 class="footer-title">
            চেম্বার
          </h6>
<p class="mb-1">
            ইসলামী ব্যাংক কমিউনিটি হাসপাতাল
            ঝিনাইদহ লিঃ
          </p>
<p class="small mb-1">
            চুয়াডাঙ্গা বাসস্ট্যান্ড,
            ঝিনাইদহ।
          </p>
<p class="small mb-1">
            শুক্রবার: বিকাল ৪টা – রাত ৮টা
          </p>
<a href="tel:+8801640167617">
            ০১৬৪০-১৬৭৬১৭
          </a>
<br/>
<a href="mailto:ibchj@gmail.com">
            ibchj@gmail.com
          </a>
</div>
</div>
<hr class="border-light opacity-10 my-4"/>
<div class="d-flex flex-wrap justify-content-between gap-2 small">
<span>
          © <span id="year"></span>
          Dr. Amit Hasan. All rights reserved.
        </span>
</div>
</div>
</footer>

<div aria-hidden="true" aria-labelledby="upashamModalLabel" class="modal fade appointment-modal" id="upashamModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<!-- Header -->
<div class="modal-header">
<div>
<span class="modal-kicker">
              APPOINTMENT • DHAKA
            </span>
<h4 class="modal-title mt-1" id="upashamModalLabel">
              উপশম হেলথ পয়েন্ট (প্রাঃ) লিঃ
            </h4>
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
<h5>হাসপাতাল ও ডায়াগনস্টিক</h5>
<p class="text-secondary mb-0">
                বাড়ি # ১৪, রোড # ২/বি, ব্লক # জে (দক্ষিণ),
                বারিধারা, ঢাকা-১২১২।
              </p>
</div>
</div>
<div class="appointment-info-grid">
<!-- Time -->
<div class="appointment-info">
<i class="bi bi-clock"></i>
<div>
<small>রোগী দেখার সময়</small>
<strong>
                  রবি থেকে বুধবার
                </strong>
<span>
                  সন্ধ্যা ৬টা থেকে রাত ৮টা
                </span>
</div>
</div>
<!-- Common -->
<div class="appointment-info">
<i class="bi bi-phone"></i>
<div>
<small>সিরিয়াল / সাধারণ যোগাযোগ</small>
<a href="tel:01640167617">
                  01640-167617
                </a>
</div>
</div>
<!-- Hospital -->
<div class="appointment-info">
<i class="bi bi-telephone"></i>
<div>
<small>হাসপাতাল যোগাযোগ</small>
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
<button class="btn btn-light" data-bs-dismiss="modal" type="button">
            বন্ধ করুন
          </button>
<a class="btn btn-primary" href="tel:01640167617">
<i class="bi bi-telephone me-2"></i>
            সিরিয়ালের জন্য কল করুন

          </a>
</div>
</div>
</div>
</div>

<div aria-hidden="true" aria-labelledby="shishuHospitalModalLabel" class="modal fade appointment-modal" id="shishuHospitalModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">
<div>
<span class="modal-kicker">
              APPOINTMENT • DHAKA
            </span>
<h4 class="modal-title mt-1" id="shishuHospitalModalLabel">
              বাংলাদেশ শিশু হাসপাতাল ও ইনস্টিটিউট
            </h4>
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
<h5>
                শিশু, কিশোর ও নবজাতক বিশেষজ্ঞ সেবা
              </h5>
<p class="text-secondary mb-0">
                শেরে বাংলা নগর, ঢাকা।
              </p>
</div>
</div>
<div class="appointment-info-grid">
<!-- Service -->
<div class="appointment-info">
<i class="bi bi-heart-pulse"></i>
<div>
<small>বিশেষজ্ঞ সেবা</small>
<strong>
                  শিশু সার্জারি
                </strong>
<span>
                  শিশু, কিশোর ও নবজাতকের চিকিৎসা ও সার্জিক্যাল সেবা
                </span>
</div>
</div>
<!-- Contact -->
<div class="appointment-info">
<i class="bi bi-phone"></i>
<div>
<small>সিরিয়াল / সাধারণ যোগাযোগ</small>
<a href="tel:01640167617">
                  01640-167617
                </a>
</div>
</div>
<!-- Location -->
<div class="appointment-info">
<i class="bi bi-geo-alt"></i>
<div>
<small>ঠিকানা</small>
<strong>
                  শেরে বাংলা নগর
                </strong>
<span>
                  ঢাকা
                </span>
</div>
</div>
</div>
</div>
<div class="modal-footer">
<button class="btn btn-light" data-bs-dismiss="modal" type="button">
            বন্ধ করুন
          </button>
<a class="btn btn-primary" href="tel:01640167617">
<i class="bi bi-telephone me-2"></i>
            সিরিয়ালের জন্য কল করুন

          </a>
</div>
</div>
</div>
</div>

<div aria-hidden="true" aria-labelledby="jhenaidahHospitalModalLabel" class="modal fade appointment-modal" id="jhenaidahHospitalModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">
<div>
<span class="modal-kicker">
              APPOINTMENT • JHENAIDAH
            </span>
<h4 class="modal-title mt-1" id="jhenaidahHospitalModalLabel">

              ইসলামী ব্যাংক কমিউনিটি হাসপাতাল
              ঝিনাইদহ লিঃ

            </h4>
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
<h5>
                ইসলামী ব্যাংক কমিউনিটি হাসপাতাল
              </h5>
<p class="text-secondary mb-0">
                চুয়াডাঙ্গা বাসস্ট্যান্ড, ঝিনাইদহ।
              </p>
</div>
</div>
<div class="appointment-info-grid">
<!-- Time -->
<div class="appointment-info">
<i class="bi bi-clock"></i>
<div>
<small>রোগী দেখার সময়</small>
<strong>
                  প্রতি শুক্রবার
                </strong>
<span>
                  বিকাল ৪টা থেকে রাত ৮টা
                </span>
</div>
</div>
<!-- Hospital Phone -->
<div class="appointment-info">
<i class="bi bi-telephone"></i>
<div>
<small>হাসপাতাল যোগাযোগ</small>
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
<small>সিরিয়াল / সাধারণ যোগাযোগ</small>
<a href="tel:01640167617">
                  01640-167617
                </a>
</div>
</div>
<!-- Email -->
<div class="appointment-info">
<i class="bi bi-envelope"></i>
<div>
<small>ই-মেইল</small>
<a href="mailto:ibchj@gmail.com">
                  ibchj@gmail.com
                </a>
</div>
</div>
</div>
</div>
<div class="modal-footer">
<button class="btn btn-light" data-bs-dismiss="modal" type="button">
            বন্ধ করুন
          </button>
<a class="btn btn-primary" href="tel:01640167617">
<i class="bi bi-telephone me-2"></i>
            সিরিয়ালের জন্য কল করুন

          </a>
</div>
</div>
</div>
</div>

<div class="modal fade" id="appointmentModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content border-0 rounded-4">
<div class="modal-header">
<h5 class="modal-title">অ্যাপয়েন্টমেন্ট রিকোয়েস্ট</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>
<form id="appointmentForm">
<div class="modal-body">
<div class="mb-3"><label class="form-label">রোগীর নাম</label><input class="form-control" required=""/>
</div>
<div class="mb-3"><label class="form-label">অভিভাবকের ফোন</label><input class="form-control" required="" type="tel"/></div>
<div class="row g-3">
<div class="col-6"><label class="form-label">তারিখ</label><input class="form-control" required="" type="date"/></div>
<div class="col-6"><label class="form-label">সময়</label><select class="form-select">
<option>সন্ধ্যা ৬:০০</option>
<option>সন্ধ্যা ৬:৩০</option>
<option>সন্ধ্যা ৭:০০</option>
<option>সন্ধ্যা ৭:৩০</option>
</select></div>
</div>
<div class="mt-3"><label class="form-label">সমস্যার সংক্ষিপ্ত বিবরণ</label><textarea class="form-control" rows="3"></textarea></div>
</div>
<div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal" type="button">বন্ধ
              করুন</button><button class="btn btn-primary-custom">রিকোয়েস্ট পাঠান</button></div>
</form>
</div>
</div>
</div>

@endsection
