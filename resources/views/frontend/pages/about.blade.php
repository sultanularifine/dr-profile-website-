@extends('frontend.layouts.app')

@section('title', 'পরিচিতি | ডা. অমিত হাসান')

@section('content')

<section class="section">
<div class="container">
<div class="section-head" data-aos="fade-up">
<div class="section-kicker">{{ site_content('about.258', 'ABOUT THE DOCTOR') }}</div>
<h2>{{ site_content('about.259', 'বিশেষজ্ঞ চিকিৎসক সম্পর্কে') }}</h2>
<p>{{ site_content('about.260', 'যোগ্যতা, অভিজ্ঞতা এবং রোগী-কেন্দ্রিক চিকিৎসা পদ্ধতির একটি সংক্ষিপ্ত পরিচিতি।') }}</p>
</div>
<div class="row g-4 align-items-stretch">
<div class="col-lg-6" data-aos="fade-right">
<div class="about-card h-100">
<h3>{{ site_content('about.261', 'ডা. অমিত হাসান') }}</h3>
<p class="text-secondary mt-3">{{ site_content('about.262', '
              শিশু, কিশোর ও নবজাতক রোগীদের চিকিৎসা এবং শিশু সার্জারিতে
              বিশেষায়িত সেবা প্রদান করেন। রোগের কারণ, সম্ভাব্য চিকিৎসা,
              পরবর্তী যত্ন ও অভিভাবকের করণীয় সহজভাবে বোঝানো এই সেবার গুরুত্বপূর্ণ অংশ।
            ') }}</p>
<ul class="check-list mt-4">
<li><i class="bi bi-check-circle-fill"></i>{{ site_content('about.263', ' শিশু ও নবজাতক বিশেষজ্ঞ চিকিৎসা') }}</li>
<li><i class="bi bi-check-circle-fill"></i>{{ site_content('about.264', ' শিশু সার্জারি ও ইউরোলজি') }}</li>
<li><i class="bi bi-check-circle-fill"></i>{{ site_content('about.265', ' রোগী ও অভিভাবক-কেন্দ্রিক কাউন্সেলিং') }}</li>
<li><i class="bi bi-check-circle-fill"></i>{{ site_content('about.266', ' প্রয়োজন অনুযায়ী পরীক্ষা ও রেফারেল গাইডেন্স') }}</li>
<li><i class="bi bi-check-circle-fill"></i>{{ site_content('about.267', ' শিশু নিউরোসার্জারি') }}</li>
<li><i class="bi bi-check-circle-fill"></i>{{ site_content('about.268', ' শিশু বার্ন ও প্লাস্টিক সার্জারি') }}</li>
<li><i class="bi bi-check-circle-fill"></i>{{ site_content('about.269', ' জন্মগত ত্রুটির চিকিৎসা ও সার্জারি') }}</li>
<li><i class="bi bi-check-circle-fill"></i>{{ site_content('about.270', ' নবজাতক সার্জারি') }}</li>
<li><i class="bi bi-check-circle-fill"></i>{{ site_content('about.271', ' শিশু ক্যান্সার সার্জারি') }}</li>
<li><i class="bi bi-check-circle-fill"></i>{{ site_content('about.272', ' হেপাটো-বিলিয়ারি সার্জারি') }}</li>
<li><i class="bi bi-check-circle-fill"></i>{{ site_content('about.273', ' অর্থোপেডিক্স') }}</li>
</ul>
</div>
</div>
<div class="col-lg-6" data-aos="zoom-in">
<div class="about-card h-100">
<h4>
<i class="bi bi-mortarboard text-primary me-2"></i>{{ site_content('about.274', '
              শিক্ষাগত যোগ্যতা ও উচ্চতর প্রশিক্ষণ
            ') }}</h4>
<div class="timeline mt-4">
<!-- MBBS -->
<div class="timeline-item">
<div class="timeline-dot"></div>
<div class="timeline-card">
<small>{{ site_content('about.275', 'MBBS — রাজশাহী') }}</small>
<h5 class="mt-2">{{ site_content('about.276', '
                    ব্যাচেলর অব মেডিসিন অ্যান্ড সার্জারি (MBBS)
                  ') }}</h5>
<p class="text-secondary mb-0">{{ site_content('about.277', '
                    রাজশাহী থেকে এমবিবিএস (MBBS) ডিগ্রি অর্জন।
                  ') }}</p>
</div>
</div>
<!-- MS -->
<div class="timeline-item">
<div class="timeline-dot"></div>
<div class="timeline-card">
<small>{{ site_content('about.278', 'MS — শিশু সার্জারি') }}</small>
<h5 class="mt-2">{{ site_content('about.279', '
                    শিশু সার্জারি (MS)
                  ') }}</h5>
<p class="text-secondary mb-0">{{ site_content('about.280', '
                    শিশু ও নবজাতকের সার্জারি বিষয়ে বিশেষায়িত উচ্চতর
                    চিকিৎসা শিক্ষা ও প্রশিক্ষণ।
                  ') }}</p>
</div>
</div>
<!-- Bangladesh Medical University -->
<div class="timeline-item">
<div class="timeline-dot"></div>
<div class="timeline-card">
<small>{{ site_content('about.281', '
                    বাংলাদেশ মেডিকেল বিশ্ববিদ্যালয় — ঢাকা
                  ') }}</small>
<h5 class="mt-2">{{ site_content('about.282', '
                    উচ্চতর চিকিৎসা শিক্ষা ও প্রশিক্ষণ
                  ') }}</h5>
<p class="text-secondary mb-0">{{ site_content('about.283', '
                    বাংলাদেশ মেডিকেল বিশ্ববিদ্যালয় (সাবেক পিজি হাসপাতাল),
                    ঢাকায় উচ্চতর চিকিৎসা শিক্ষা ও প্রশিক্ষণের সঙ্গে সম্পৃক্ততা।
                  ') }}</p>
</div>
</div>
<!-- International Qualification -->
<div class="timeline-item mb-0">
<div class="timeline-dot"></div>
<div class="timeline-card">
<small>{{ site_content('about.284', '
                    International Qualification
                  ') }}</small>
<h5 class="mt-2">{{ site_content('about.285', '
                    MACS — America &amp; উচ্চতর যোগ্যতা MWMA — Paris
                  ') }}</h5>
<p class="text-secondary mb-0">{{ site_content('about.286', '
                    আমেরিকা ও প্যারিসে উল্লেখিত উচ্চতর পেশাগত
                    যোগ্যতা ও আন্তর্জাতিক প্রশিক্ষণ।
                  ') }}</p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</section>

<section class="section section-soft">
<div class="container">
<div class="section-head" data-aos="fade-up">
<div class="section-kicker">{{ site_content('about.287', 'CAREER') }}</div>
<h2>{{ site_content('about.288', 'অভিজ্ঞতা ও পেশাগত পরিচিতি') }}</h2>
<p>{{ site_content('about.289', '
          শিশু, কিশোর ও নবজাতকের চিকিৎসা, শিশু সার্জারি এবং বিশেষজ্ঞ স্বাস্থ্যসেবার
          সঙ্গে যুক্ত পেশাগত যাত্রা ও চেম্বারসমূহ।
        ') }}</p>
</div>
<div class="row g-4">
<!-- LEFT SIDE -->
<div class="col-lg-7" data-aos="fade-right">
<div class="timeline">
<!-- Bangladesh Shishu Hospital -->
<div class="timeline-item">
<div class="timeline-dot"></div>
<div class="timeline-card">
<small>{{ site_content('about.290', 'বর্তমান কর্মস্থল') }}</small>
<h4 class="mt-2">{{ site_content('about.291', '
                  বাংলাদেশ শিশু হাসপাতাল ও ইনস্টিটিউট
                ') }}</h4>
<p class="text-secondary mb-2">
<i class="bi bi-geo-alt-fill me-1"></i>{{ site_content('about.292', '
                  শেরে বাংলা নগর, ঢাকা।
                ') }}</p>
<p class="text-secondary mb-2">{{ site_content('about.293', '
                  শিশু, কিশোর ও নবজাতকের রোগ এবং শিশু সার্জারি বিষয়ে
                  বিশেষজ্ঞ চিকিৎসাসেবা।
                ') }}</p>
<!-- Common Contact Number -->
<div class="mt-3">
<strong>
<i class="bi bi-telephone-fill me-1"></i>{{ site_content('about.294', '
                    যোগাযোগ:
                  ') }}</strong>
<a class="text-decoration-none" href="tel:01640167617">
                    01640-167617
                  </a>
</div>
</div>
</div>
<!-- Islami Bank Community Hospital -->
<div class="timeline-item">
<div class="timeline-dot"></div>
<div class="timeline-card">
<small>{{ site_content('about.295', 'Professional Practice • Jhenaidah') }}</small>
<h4 class="mt-2">{{ site_content('about.296', '
                  ইসলামী ব্যাংক কমিউনিটি হাসপাতাল ঝিনাইদহ লিঃ
                ') }}</h4>
<p class="text-secondary mb-2">
<i class="bi bi-geo-alt-fill me-1"></i>{{ site_content('about.297', '
                  চুয়াডাঙ্গা বাসস্ট্যান্ড, ঝিনাইদহ।
                ') }}</p>
<p class="text-secondary mb-2">
<i class="bi bi-clock-fill me-1"></i>
<strong>{{ site_content('about.298', 'রোগী দেখার সময়:') }}</strong>{{ site_content('about.299', '
                  প্রতি শুক্রবার, বিকাল ৪টা থেকে রাত ৮টা।
                ') }}</p>
<div class="mt-3">
<strong>
<i class="bi bi-telephone-fill me-1"></i>{{ site_content('about.300', '
                    হাসপাতাল:
                  ') }}</strong>
<a class="text-decoration-none me-2" href="tel:01716853022">
                    01716-853022
                  </a>
<span class="text-secondary">|</span>
<a class="text-decoration-none ms-2" href="tel:01712058201">
                    01712-058201
                  </a>
</div>
<div class="mt-2">
<strong>
<i class="bi bi-phone-fill me-1"></i>{{ site_content('about.301', '
                    সিরিয়াল / যোগাযোগ:
                  ') }}</strong>
<a class="text-decoration-none" href="tel:01640167617">
                    01640-167617
                  </a>
</div>
<div class="mt-2">
<strong>
<i class="bi bi-envelope-fill me-1"></i>{{ site_content('about.302', '
                    ই-মেইল:
                  ') }}</strong>
<a class="text-decoration-none" href="mailto:ibchj@gmail.com">
                    ibchj@gmail.com
                  </a>
</div>
</div>
</div>
<!-- Upasham Health Point -->
<div class="timeline-item">
<div class="timeline-dot"></div>
<div class="timeline-card">
<small>{{ site_content('about.303', 'Professional Practice • Dhaka') }}</small>
<h4 class="mt-2">{{ site_content('about.304', '
                  উপশম হেলথ পয়েন্ট (প্রাঃ) লিঃ
                ') }}</h4>
<p class="text-secondary mb-2">
<i class="bi bi-geo-alt-fill me-1"></i>{{ site_content('about.305', '
                  বাড়ি # ১৪, রোড # ২/বি, ব্লক # জে (দক্ষিণ),
                  বারিধারা, ঢাকা-১২১২।
                ') }}</p>
<p class="text-secondary mb-2">
<i class="bi bi-clock-fill me-1"></i>
<strong>{{ site_content('about.306', 'রোগী দেখার সময়:') }}</strong>{{ site_content('about.307', '
                  রবি থেকে বুধবার, সন্ধ্যা ৬টা থেকে রাত ৮টা।
                ') }}</p>
<div class="mt-3">
<strong>
<i class="bi bi-telephone-fill me-1"></i>{{ site_content('about.308', '
                    হাসপাতাল:
                  ') }}</strong>
<a class="text-decoration-none me-2" href="tel:01932200200">
                    01932-200200
                  </a>
<span class="text-secondary">|</span>
<a class="text-decoration-none ms-2" href="tel:01713888100">
                    01713-888100
                  </a>
</div>
<!-- Common Number -->
<div class="mt-2">
<strong>
<i class="bi bi-phone-fill me-1"></i>{{ site_content('about.309', '
                    সিরিয়াল / যোগাযোগ:
                  ') }}</strong>
<a class="text-decoration-none" href="tel:01640167617">
                    01640-167617
                  </a>
</div>
</div>
</div>
<!-- নবজাতক শিশু ও জেনারেল হাসপাতাল -->
<div class="timeline-item">
<div class="timeline-dot"></div>
<div class="timeline-card">
<small>{{ site_content('about.310', 'Professional Practice • Dhaka') }}</small>
<h4 class="mt-2">{{ site_content('about.311', '
                  নবজাতক শিশু ও জেনারেল হাসপাতাল
                ') }}</h4>
<p class="text-secondary mb-2">
<i class="bi bi-geo-alt-fill me-1"></i>{{ site_content('about.312', '
                  লালমাটিয়া, মোহাম্মদপুর, ঢাকা।
                  ') }}<br/>
<span class="ms-4">{{ site_content('about.313', '(লালমাটিয়া মহিলা কলেজের সামনে)') }}</span>
</p>
<!-- Common Number -->
<div class="mt-2">
<strong>
<i class="bi bi-phone-fill me-1"></i>{{ site_content('about.314', '
                    সিরিয়াল / যোগাযোগ:
                  ') }}</strong>
<a class="text-decoration-none" href="tel:01640167617">
                    01640-167617
                  </a>
</div>
</div>
</div>
<!-- International Exposure -->
<div class="timeline-item mb-0">
<div class="timeline-dot"></div>
<div class="timeline-card">
<small>{{ site_content('about.315', 'International Exposure') }}</small>
<h4 class="mt-2">{{ site_content('about.316', '
                  USA &amp; Paris
                ') }}</h4>
<p class="text-secondary mb-0">{{ site_content('about.317', '
                  উচ্চতর প্রশিক্ষণ ও পেশাগত যোগ্যতার আন্তর্জাতিক এক্সপোজার।
                ') }}</p>
</div>
</div>
</div>
</div>
<!-- RIGHT SIDE -->
<div class="col-lg-5" data-aos="zoom-in">
<div class="about-card h-100">
<h4>{{ site_content('about.318', 'চিকিৎসার নীতি') }}</h4>
<p class="text-secondary mt-3">{{ site_content('about.319', '
              প্রতিটি রোগীর ক্ষেত্রে রোগের ইতিহাস, শারীরিক পরীক্ষা,
              প্রয়োজনীয় পরীক্ষা-নিরীক্ষা এবং পরিবারের সঙ্গে বিস্তারিত
              আলোচনার মাধ্যমে চিকিৎসা পরিকল্পনা করা।
            ') }}</p>
<div class="d-flex gap-3 align-items-start mt-4">
<i class="bi bi-heart-pulse-fill fs-3 text-primary"></i>
<div>
<strong>{{ site_content('about.320', 'Patient First') }}</strong>
<div class="text-secondary">{{ site_content('about.321', '
                  রোগীর নিরাপত্তা, আরাম ও সঠিক চিকিৎসাকে অগ্রাধিকার।
                ') }}</div>
</div>
</div>
<div class="d-flex gap-3 align-items-start mt-4">
<i class="bi bi-chat-square-heart fs-3 text-primary"></i>
<div>
<strong>{{ site_content('about.322', 'Family Education') }}</strong>
<div class="text-secondary">{{ site_content('about.323', '
                  অভিভাবকদের রোগ, চিকিৎসা, প্রয়োজনীয় যত্ন ও
                  ফলো-আপ সম্পর্কে পরিষ্কার নির্দেশনা।
                ') }}</div>
</div>
</div>
<div class="d-flex gap-3 align-items-start mt-4">
<i class="bi bi-activity fs-3 text-primary"></i>
<div>
<strong>{{ site_content('about.324', 'Evidence Based') }}</strong>
<div class="text-secondary">{{ site_content('about.325', '
                  আধুনিক ও প্রমাণভিত্তিক চিকিৎসা পদ্ধতির প্রতি গুরুত্ব।
                ') }}</div>
</div>
</div>
<!-- Common Appointment Number -->
<div class="d-flex gap-3 align-items-start mt-4">
<i class="bi bi-telephone-outbound-fill fs-3 text-primary"></i>
<div>
<strong>{{ site_content('about.326', 'Appointment &amp; Serial') }}</strong>
<div class="text-secondary">{{ site_content('about.327', '
                  সকল চেম্বারের জন্য সাধারণ যোগাযোগ নম্বর
                ') }}</div>
<a class="text-decoration-none fw-semibold" href="tel:01640167617">
                  01640-167617
                </a>
</div>
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
<h4 class="footer-title">{{ site_content('about.328', '
            ডা. অমিত হাসান
          ') }}</h4>
<p class="mb-3">{{ site_content('about.329', '
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
<h6 class="footer-title">{{ site_content('about.330', '
            দ্রুত লিংক
          ') }}</h6>
<div class="d-flex flex-column gap-2">
<a href="{{ route('about') }}">{{ site_content('about.331', '
              পরিচিতি
            ') }}</a>
<a href="{{ route('services') }}">{{ site_content('about.332', '
              সেবা
            ') }}</a>
<a href="{{ url('/conditions') }}">{{ site_content('about.333', '
              রোগসমূহ
            ') }}</a>
<a href="{{ route('appointment') }}">{{ site_content('about.334', '
              অ্যাপয়েন্টমেন্ট
            ') }}</a>
<a href="{{ route('faq') }}">{{ site_content('about.335', '
              সাধারণ জিজ্ঞাসা
            ') }}</a>
<a href="{{ route('contact') }}">{{ site_content('about.336', '
              যোগাযোগ
            ') }}</a>
</div>
</div>
<!-- Chamber -->
<div class="col-6 col-lg-4">
<h6 class="footer-title">{{ site_content('about.337', '
            চেম্বার
          ') }}</h6>
<p class="mb-1">{{ site_content('about.338', '
            ইসলামী ব্যাংক কমিউনিটি হাসপাতাল
            ঝিনাইদহ লিঃ
          ') }}</p>
<p class="small mb-1">{{ site_content('about.339', '
            চুয়াডাঙ্গা বাসস্ট্যান্ড,
            ঝিনাইদহ।
          ') }}</p>
<p class="small mb-1">{{ site_content('about.340', '
            শুক্রবার: বিকাল ৪টা – রাত ৮টা
          ') }}</p>
<a href="tel:+8801640167617">{{ site_content('about.341', '
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
          © <span id="year"></span>{{ site_content('about.342', '
          Dr. Amit Hasan. All rights reserved.
        ') }}</span>
</div>
</div>
</footer>

@endsection
