@extends('frontend.layouts.app')

@section('title', 'যোগাযোগ | ডা. অমিত হাসান')

@section('content')

<section class="section section-soft">
<div class="container">
<div class="section-head" data-aos="fade-up">
<div class="section-kicker">CONTACT</div>
<h2>যোগাযোগ ও চেম্বার</h2>
<p>অ্যাপয়েন্টমেন্ট, সিরিয়াল, লোকেশন এবং অন্যান্য তথ্যের জন্য যোগাযোগ করুন।</p>
</div>
<div class="row g-4">
<!-- Contact Information -->
<div class="col-lg-5" data-aos="fade-right">
<!-- Highlighted Islami Bank Chamber -->
<div class="contact-card mb-3 border border-primary border-2">
<div class="d-flex justify-content-between align-items-center mb-3">
<span class="badge rounded-pill bg-primary px-3 py-2">
<i class="bi bi-star-fill me-1"></i>
                চেম্বার
              </span>
</div>
<!-- Location -->
<div class="d-flex gap-3">
<div class="contact-icon">
<i class="bi bi-hospital"></i>
</div>
<div>
<h5>
                  ইসলামী ব্যাংক কমিউনিটি হাসপাতাল
                  ঝিনাইদহ লিঃ
                </h5>
<p class="text-secondary mb-0">
                  চুয়াডাঙ্গা বাসস্ট্যান্ড,
                  ঝিনাইদহ।
                </p>
</div>
</div>
<!-- Hospital Phone -->
<div class="d-flex gap-3 mt-4">
<div class="contact-icon">
<i class="bi bi-telephone"></i>
</div>
<div>
<h5>হাসপাতাল যোগাযোগ</h5>
<p class="mb-1">
<a href="tel:+8801716853022">
                    ০১৭১৬ ৮৫৩০২২
                  </a>
</p>
<p class="mb-0">
<a href="tel:+8801712058201">
                    ০১৭১২ ০৫৮২০১
                  </a>
</p>
</div>
</div>
<!-- Chamber Time -->
<div class="d-flex gap-3 mt-4">
<div class="contact-icon">
<i class="bi bi-clock"></i>
</div>
<div>
<h5>চেম্বার সময়</h5>
<p class="text-secondary mb-0">
                  প্রতি শুক্রবার<br/>
                  বিকাল ৪টা – রাত ৮টা
                </p>
</div>
</div>
<!-- Serial -->
<div class="d-flex gap-3 mt-4">
<div class="contact-icon">
<i class="bi bi-phone"></i>
</div>
<div>
<h5>সাধারণ সিরিয়াল</h5>
<p class="mb-0">
<a href="tel:+8801640167617">
                    ০১৬৪০ ১৬৭৬১৭
                  </a>
</p>
</div>
</div>
<!-- Email -->
<div class="d-flex gap-3 mt-4">
<div class="contact-icon">
<i class="bi bi-envelope"></i>
</div>
<div>
<h5>ই-মেইল</h5>
<p class="mb-0">
<a href="mailto:ibchj@gmail.com">
                    ibchj@gmail.com
                  </a>
</p>
</div>
</div>
<!-- Call Button -->
<div class="mt-4">
<a class="btn btn-primary-custom w-100" href="tel:+8801640167617">
<i class="bi bi-telephone-fill me-2"></i>
                সিরিয়ালের জন্য কল করুন

              </a>
</div>
</div>
</div>
<!-- Contact Form -->
<div class="col-lg-7" data-aos="zoom-in">
<div class="contact-card">
<h4>
<i class="bi bi-chat-square-text text-primary me-2"></i>
              বার্তা পাঠান
            </h4>
<p class="text-secondary">
              অ্যাপয়েন্টমেন্ট, সিরিয়াল বা অন্যান্য তথ্যের জন্য
              আপনার তথ্য ও বার্তা পাঠাতে পারেন।
            </p>
<form action="https://formsubmit.co/arifinejobayer307@gmail.com" class="row g-3 mt-1" id="contactForm" method="POST">
<!-- FormSubmit Settings -->
<input name="_subject" type="hidden" value="Dr. Amit Hasan - Website Contact"/>
<input name="_template" type="hidden" value="table"/>
<input name="_captcha" type="hidden" value="true"/>
<!-- Name -->
<div class="col-md-6">
<label class="form-label">নাম</label>
<input class="form-control" name="name" placeholder="আপনার নাম" required="" type="text"/>
</div>
<!-- Phone -->
<div class="col-md-6">
<label class="form-label">ফোন</label>
<input class="form-control" name="phone" placeholder="01XXXXXXXXX" required="" type="tel"/>
</div>
<!-- Email -->
<div class="col-12">
<label class="form-label">ইমেইল</label>
<input class="form-control" name="email" placeholder="আপনার ইমেইল" type="email"/>
</div>
<!-- Message -->
<div class="col-12">
<label class="form-label">বার্তা</label>
<textarea class="form-control" name="message" placeholder="আপনার বার্তা লিখুন..." required="" rows="5"></textarea>
</div>
<!-- Submit -->
<div class="col-12">
<button class="btn btn-primary-custom" type="submit">
<i class="bi bi-send me-2"></i>
                  বার্তা পাঠান

                </button>
</div>
</form>
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

@endsection
