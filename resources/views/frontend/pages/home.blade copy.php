@extends('frontend.layouts.app')

@section('title', 'ডা. অমিত হাসান | শিশু ও নবজাতক সার্জন')

@section('meta_description')
ডা. অমিত হাসান শিশু, কিশোর ও নবজাতক বিশেষজ্ঞ এবং শিশু সার্জন। ঢাকা ও ঝিনাইদহে বিশেষজ্ঞ পরামর্শ ও অ্যাপয়েন্টমেন্ট.
@endsection

@section('content')

<header class="hero" id="home">
  <div class="container position-relative z-1">
    <div class="row align-items-center g-5">
      <div class="col-lg-7" data-aos="fade-right">
        <span class="eyebrow"><i class="bi bi-patch-check-fill"></i> শিশু, কিশোর ও নবজাতক বিশেষজ্ঞ</span>
        <h1>ডা. অমিত হাসান — <span>শিশু ও নবজাতক সার্জন</span></h1>
        <p class="hero-lead">
          ঢাকা ও ঝিনাইদহে শিশু, কিশোর ও নবজাতকের চিকিৎসা,
          শিশু সার্জারি, শিশু ইউরোলজি ও নবজাতক সার্জারি বিষয়ে
          বিশেষজ্ঞ পরামর্শ।
        </p>
        <div class="d-flex flex-wrap gap-3 mt-4">
          <a class="btn btn-primary-custom" href="#appointment"><i class="bi bi-calendar2-check me-2"></i>অ্যাপয়েন্টমেন্ট নিন</a>
          <a class="btn btn-outline-custom" href="#about"><i class="bi bi-person-vcard me-2"></i>আরও জানুন</a>
        </div>
        <div class="d-flex flex-wrap gap-4 mt-4 text-secondary">
          <div><strong class="d-block text-primary">MBBS</strong><small>রাজশাহী</small></div>
          <div><strong class="d-block text-primary">MS</strong><small>শিশু</small></div>
          <div><strong class="d-block text-primary">MACS</strong><small>USA</small></div>
          <div><strong class="d-block text-primary">MWMA</strong><small>Paris</small></div>
        </div>
      </div>
      <div class="col-lg-5" data-aos="zoom-in">
        <div class="hero-card">
          <img alt="ডা. অমিত হাসান" class="doctor-img" src="{{ asset('assets/img/doctor-profile.jpg') }}" />
          <div class="floating-badge">
            <strong><i class="bi bi-shield-check me-1"></i>বিশেষজ্ঞ চিকিৎসক</strong>
            <span class="text-secondary ms-4">শিশু ও নবজাতক সার্জারি</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>

<section class="stats">
  <div class="container">
    <div class="row g-3">
      <div class="col-6 col-lg-3" data-aos="zoom-in">
        <div class="stat-card"><i class="bi bi-people"></i>
          <div class="counter" data-target="5000">0+</div><span class="text-secondary">রোগী পরামর্শ</span>
        </div>
      </div>
      <div class="col-6 col-lg-3" data-aos="zoom-in" data-aos-delay="100">
        <div class="stat-card"><i class="bi bi-award"></i>
          <div class="counter" data-target="10">0+</div><span class="text-secondary">বছরের অভিজ্ঞতা</span>
        </div>
      </div>
      <div class="col-6 col-lg-3" data-aos="zoom-in" data-aos-delay="200">
        <div class="stat-card"><i class="bi bi-hospital"></i>
          <div class="counter" data-target="25">0+</div><span class="text-secondary">চিকিৎসা ক্ষেত্র</span>
        </div>
      </div>
      <div class="col-6 col-lg-3" data-aos="zoom-in" data-aos-delay="300">
        <div class="stat-card"><i class="bi bi-clock-history"></i>
          <div class="counter" data-target="6">0 PM</div><span class="text-secondary">চেম্বার শুরু</span>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-head" data-aos="fade-up">
      <div class="section-kicker">ABOUT THE DOCTOR</div>
      <h2>বিশেষজ্ঞ চিকিৎসক সম্পর্কে</h2>
      <p>যোগ্যতা, অভিজ্ঞতা এবং রোগী-কেন্দ্রিক চিকিৎসা পদ্ধতির একটি সংক্ষিপ্ত পরিচিতি।</p>
    </div>
    <div class="row g-4 align-items-stretch">
      <div class="col-lg-6" data-aos="fade-right">
        <div class="about-card h-100">
          <h3>ডা. অমিত হাসান</h3>
          <p class="text-secondary mt-3">
            শিশু, কিশোর ও নবজাতক রোগীদের চিকিৎসা এবং শিশু সার্জারিতে
            বিশেষায়িত সেবা প্রদান করেন। রোগের কারণ, সম্ভাব্য চিকিৎসা,
            পরবর্তী যত্ন ও অভিভাবকের করণীয় সহজভাবে বোঝানো এই সেবার গুরুত্বপূর্ণ অংশ।
          </p>
          <ul class="check-list mt-4">
            <li><i class="bi bi-check-circle-fill"></i> শিশু ও নবজাতক বিশেষজ্ঞ চিকিৎসা</li>
            <li><i class="bi bi-check-circle-fill"></i> শিশু সার্জারি ও ইউরোলজি</li>
            <li><i class="bi bi-check-circle-fill"></i> রোগী ও অভিভাবক-কেন্দ্রিক কাউন্সেলিং</li>
            <li><i class="bi bi-check-circle-fill"></i> প্রয়োজন অনুযায়ী পরীক্ষা ও রেফারেল গাইডেন্স</li>
            <li><i class="bi bi-check-circle-fill"></i> শিশু নিউরোসার্জারি</li>
            <li><i class="bi bi-check-circle-fill"></i> শিশু বার্ন ও প্লাস্টিক সার্জারি</li>
            <li><i class="bi bi-check-circle-fill"></i> জন্মগত ত্রুটির চিকিৎসা ও সার্জারি</li>
            <li><i class="bi bi-check-circle-fill"></i> নবজাতক সার্জারি</li>
            <li><i class="bi bi-check-circle-fill"></i> শিশু ক্যান্সার সার্জারি</li>
            <li><i class="bi bi-check-circle-fill"></i> হেপাটো-বিলিয়ারি সার্জারি</li>
            <li><i class="bi bi-check-circle-fill"></i> অর্থোপেডিক্স</li>
          </ul>
        </div>
      </div>
      <div class="col-lg-6" data-aos="zoom-in">
        <div class="about-card h-100">
          <h4>
            <i class="bi bi-mortarboard text-primary me-2"></i>
            শিক্ষাগত যোগ্যতা ও উচ্চতর প্রশিক্ষণ
          </h4>
          <div class="timeline mt-4">
            <!-- MBBS -->
            <div class="timeline-item">
              <div class="timeline-dot"></div>
              <div class="timeline-card">
                <small>MBBS — রাজশাহী</small>
                <h5 class="mt-2">
                  ব্যাচেলর অব মেডিসিন অ্যান্ড সার্জারি (MBBS)
                </h5>
                <p class="text-secondary mb-0">
                  রাজশাহী থেকে এমবিবিএস (MBBS) ডিগ্রি অর্জন।
                </p>
              </div>
            </div>
            <!-- MS -->
            <div class="timeline-item">
              <div class="timeline-dot"></div>
              <div class="timeline-card">
                <small>MS — শিশু সার্জারি</small>
                <h5 class="mt-2">
                  শিশু সার্জারি (MS)
                </h5>
                <p class="text-secondary mb-0">
                  শিশু ও নবজাতকের সার্জারি বিষয়ে বিশেষায়িত উচ্চতর
                  চিকিৎসা শিক্ষা ও প্রশিক্ষণ।
                </p>
              </div>
            </div>
            <!-- Bangladesh Medical University -->
            <div class="timeline-item">
              <div class="timeline-dot"></div>
              <div class="timeline-card">
                <small>
                  বাংলাদেশ মেডিকেল বিশ্ববিদ্যালয় — ঢাকা
                </small>
                <h5 class="mt-2">
                  উচ্চতর চিকিৎসা শিক্ষা ও প্রশিক্ষণ
                </h5>
                <p class="text-secondary mb-0">
                  বাংলাদেশ মেডিকেল বিশ্ববিদ্যালয় (সাবেক পিজি হাসপাতাল),
                  ঢাকায় উচ্চতর চিকিৎসা শিক্ষা ও প্রশিক্ষণের সঙ্গে সম্পৃক্ততা।
                </p>
              </div>
            </div>
            <!-- International Qualification -->
            <div class="timeline-item mb-0">
              <div class="timeline-dot"></div>
              <div class="timeline-card">
                <small>
                  International Qualification
                </small>
                <h5 class="mt-2">
                  MACS — America &amp; উচ্চতর যোগ্যতা MWMA — Paris
                </h5>
                <p class="text-secondary mb-0">
                  আমেরিকা ও প্যারিসে উল্লেখিত উচ্চতর পেশাগত
                  যোগ্যতা ও আন্তর্জাতিক প্রশিক্ষণ।
                </p>
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
      <div class="section-kicker">CAREER</div>
      <h2>অভিজ্ঞতা ও পেশাগত পরিচিতি</h2>
      <p>
        শিশু, কিশোর ও নবজাতকের চিকিৎসা, শিশু সার্জারি এবং বিশেষজ্ঞ স্বাস্থ্যসেবার
        সঙ্গে যুক্ত পেশাগত যাত্রা ও চেম্বারসমূহ।
      </p>
    </div>
    <div class="row g-4">
      <!-- LEFT SIDE -->
      <div class="col-lg-7" data-aos="fade-right">
        <div class="timeline">
          <!-- Bangladesh Shishu Hospital -->
          <div class="timeline-item">
            <div class="timeline-dot"></div>
            <div class="timeline-card">
              <small>বর্তমান কর্মস্থল</small>
              <h4 class="mt-2">
                বাংলাদেশ শিশু হাসপাতাল ও ইনস্টিটিউট
              </h4>
              <p class="text-secondary mb-2">
                <i class="bi bi-geo-alt-fill me-1"></i>
                শেরে বাংলা নগর, ঢাকা।
              </p>
              <p class="text-secondary mb-2">
                শিশু, কিশোর ও নবজাতকের রোগ এবং শিশু সার্জারি বিষয়ে
                বিশেষজ্ঞ চিকিৎসাসেবা।
              </p>
              <!-- Common Contact Number -->
              <div class="mt-3">
                <strong>
                  <i class="bi bi-telephone-fill me-1"></i>
                  যোগাযোগ:
                </strong>
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
              <small>Professional Practice • Jhenaidah</small>
              <h4 class="mt-2">
                ইসলামী ব্যাংক কমিউনিটি হাসপাতাল ঝিনাইদহ লিঃ
              </h4>
              <p class="text-secondary mb-2">
                <i class="bi bi-geo-alt-fill me-1"></i>
                চুয়াডাঙ্গা বাসস্ট্যান্ড, ঝিনাইদহ।
              </p>
              <p class="text-secondary mb-2">
                <i class="bi bi-clock-fill me-1"></i>
                <strong>রোগী দেখার সময়:</strong>
                প্রতি শুক্রবার, বিকাল ৪টা থেকে রাত ৮টা।
              </p>
              <div class="mt-3">
                <strong>
                  <i class="bi bi-telephone-fill me-1"></i>
                  হাসপাতাল:
                </strong>
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
                  <i class="bi bi-phone-fill me-1"></i>
                  সিরিয়াল / যোগাযোগ:
                </strong>
                <a class="text-decoration-none" href="tel:01640167617">
                  01640-167617
                </a>
              </div>
              <div class="mt-2">
                <strong>
                  <i class="bi bi-envelope-fill me-1"></i>
                  ই-মেইল:
                </strong>
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
              <small>Professional Practice • Dhaka</small>
              <h4 class="mt-2">
                উপশম হেলথ পয়েন্ট (প্রাঃ) লিঃ
              </h4>
              <p class="text-secondary mb-2">
                <i class="bi bi-geo-alt-fill me-1"></i>
                বাড়ি # ১৪, রোড # ২/বি, ব্লক # জে (দক্ষিণ),
                বারিধারা, ঢাকা-১২১২।
              </p>
              <p class="text-secondary mb-2">
                <i class="bi bi-clock-fill me-1"></i>
                <strong>রোগী দেখার সময়:</strong>
                রবি থেকে বুধবার, সন্ধ্যা ৬টা থেকে রাত ৮টা।
              </p>
              <div class="mt-3">
                <strong>
                  <i class="bi bi-telephone-fill me-1"></i>
                  হাসপাতাল:
                </strong>
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
                  <i class="bi bi-phone-fill me-1"></i>
                  সিরিয়াল / যোগাযোগ:
                </strong>
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
              <small>Professional Practice • Dhaka</small>
              <h4 class="mt-2">
                নবজাতক শিশু ও জেনারেল হাসপাতাল
              </h4>
              <p class="text-secondary mb-2">
                <i class="bi bi-geo-alt-fill me-1"></i>
                লালমাটিয়া, মোহাম্মদপুর, ঢাকা।
                <br />
                <span class="ms-4">(লালমাটিয়া মহিলা কলেজের সামনে)</span>
              </p>
              <!-- Common Number -->
              <div class="mt-2">
                <strong>
                  <i class="bi bi-phone-fill me-1"></i>
                  সিরিয়াল / যোগাযোগ:
                </strong>
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
              <small>International Exposure</small>
              <h4 class="mt-2">
                USA &amp; Paris
              </h4>
              <p class="text-secondary mb-0">
                উচ্চতর প্রশিক্ষণ ও পেশাগত যোগ্যতার আন্তর্জাতিক এক্সপোজার।
              </p>
            </div>
          </div>
        </div>
      </div>
      <!-- RIGHT SIDE -->
      <div class="col-lg-5" data-aos="zoom-in">
        <div class="about-card h-100">
          <h4>চিকিৎসার নীতি</h4>
          <p class="text-secondary mt-3">
            প্রতিটি রোগীর ক্ষেত্রে রোগের ইতিহাস, শারীরিক পরীক্ষা,
            প্রয়োজনীয় পরীক্ষা-নিরীক্ষা এবং পরিবারের সঙ্গে বিস্তারিত
            আলোচনার মাধ্যমে চিকিৎসা পরিকল্পনা করা।
          </p>
          <div class="d-flex gap-3 align-items-start mt-4">
            <i class="bi bi-heart-pulse-fill fs-3 text-primary"></i>
            <div>
              <strong>Patient First</strong>
              <div class="text-secondary">
                রোগীর নিরাপত্তা, আরাম ও সঠিক চিকিৎসাকে অগ্রাধিকার।
              </div>
            </div>
          </div>
          <div class="d-flex gap-3 align-items-start mt-4">
            <i class="bi bi-chat-square-heart fs-3 text-primary"></i>
            <div>
              <strong>Family Education</strong>
              <div class="text-secondary">
                অভিভাবকদের রোগ, চিকিৎসা, প্রয়োজনীয় যত্ন ও
                ফলো-আপ সম্পর্কে পরিষ্কার নির্দেশনা।
              </div>
            </div>
          </div>
          <div class="d-flex gap-3 align-items-start mt-4">
            <i class="bi bi-activity fs-3 text-primary"></i>
            <div>
              <strong>Evidence Based</strong>
              <div class="text-secondary">
                আধুনিক ও প্রমাণভিত্তিক চিকিৎসা পদ্ধতির প্রতি গুরুত্ব।
              </div>
            </div>
          </div>
          <!-- Common Appointment Number -->
          <div class="d-flex gap-3 align-items-start mt-4">
            <i class="bi bi-telephone-outbound-fill fs-3 text-primary"></i>
            <div>
              <strong>Appointment &amp; Serial</strong>
              <div class="text-secondary">
                সকল চেম্বারের জন্য সাধারণ যোগাযোগ নম্বর
              </div>
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

<section class="section section-soft">
  <div class="container">
    <div class="section-head" data-aos="fade-up">
      <div class="section-kicker">SPECIALIZED SERVICES</div>
      <h2>চিকিৎসা ও সেবাসমূহ</h2>
      <p>শিশু ও নবজাতকের বিভিন্ন সাধারণ, সার্জিক্যাল ও বিশেষায়িত সমস্যার জন্য পরামর্শ, চিকিৎসা ও প্রয়োজনীয়
        পুনর্বাসন সেবা।</p>
    </div>
    <div class="row g-4" id="serviceGrid"></div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-head" data-aos="fade-up">
      <div class="section-kicker">CONDITIONS</div>
      <h2>যেসব রোগ ও সমস্যা দেখা হয়</h2>
      <p>নিচের ক্যাটাগরি থেকে বেছে নিয়ে প্রাসঙ্গিক সমস্যাগুলো দ্রুত খুঁজে দেখুন।</p>
    </div>
    <div class="filter-wrap" id="conditionFilters"></div>
    <div class="row g-3" id="conditionGrid"></div>
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

<section class="section section-soft">
  <div class="container">
    <div class="section-head" data-aos="fade-up">
      <div class="section-kicker">PATIENT EXPERIENCE</div>
      <h2>রোগী ও অভিভাবকের অভিজ্ঞতা</h2>
      <p>এখানে প্রকৃত রোগীর অনুমতি নিয়ে যাচাইকৃত testimonial যোগ করা যাবে। নিচেরগুলো demo content।</p>
    </div>
    <div class="row g-4">
      <div class="col-md-4" data-aos="fade-up">
        <div class="testimonial-card">
          <div class="stars">★★★★★</div>
          <p class="quote mt-3">“ডাক্তারের ব্যাখ্যা খুব সহজ ছিল। আমাদের সন্তানের সমস্যাটা বুঝতে অনেক সাহায্য হয়েছে।”
          </p><strong>একজন অভিভাবক</strong>
          <div class="text-secondary small">ঢাকা</div>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
        <div class="testimonial-card">
          <div class="stars">★★★★★</div>
          <p class="quote mt-3">“সময় নিয়ে শুনেছেন এবং পরবর্তী করণীয় পরিষ্কার করে বলেছেন।”</p><strong>একজন রোগীর
            অভিভাবক</strong>
          <div class="text-secondary small">বারিধারা</div>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
        <div class="testimonial-card">
          <div class="stars">★★★★★</div>
          <p class="quote mt-3">“শিশু সার্জারি সংক্রান্ত বিষয়ে প্রয়োজনীয় গাইডলাইন পেয়েছি।”</p><strong>একজন
            অভিভাবক</strong>
          <div class="text-secondary small">ঢাকা</div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-head" data-aos="fade-up">
      <div class="section-kicker">FAQ</div>
      <h2>সাধারণ জিজ্ঞাসা</h2>
      <p>
        অ্যাপয়েন্টমেন্ট, চেম্বারের সময়, চিকিৎসার ধরন ও
        প্রয়োজনীয় তথ্য সম্পর্কে সাধারণ প্রশ্নের উত্তর।
      </p>
    </div>
    <div class="faq-card mx-auto" data-aos="fade-up" style="max-width:900px">
      <div class="accordion" id="faqAccordion">
        <!-- FAQ 01 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button" data-bs-target="#faq1" data-bs-toggle="collapse">

              ডাক্তার কখন রোগী দেখেন?

            </button>
          </h2>
          <div class="accordion-collapse collapse show" data-bs-parent="#faqAccordion" id="faq1">
            <div class="accordion-body">

              উপশম হেলথ পয়েন্ট (প্রাঃ) লিঃ-এ
              রবি থেকে বুধবার সন্ধ্যা ৬টা থেকে রাত ৮টা পর্যন্ত
              রোগী দেখার সময় নির্ধারিত রয়েছে।

            </div>
          </div>
        </div>
        <!-- FAQ 02 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" data-bs-target="#faq2" data-bs-toggle="collapse">

              কোন ধরনের রোগী দেখা হয়?

            </button>
          </h2>
          <div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq2">
            <div class="accordion-body">

              শিশু, কিশোর ও নবজাতকের বিভিন্ন সাধারণ,
              ইউরোলজিক্যাল এবং সার্জিক্যাল সমস্যার
              বিশেষজ্ঞ পরামর্শ ও চিকিৎসাসেবা প্রদান করা হয়।

            </div>
          </div>
        </div>
        <!-- FAQ 03 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" data-bs-target="#faq3" data-bs-toggle="collapse">

              কীভাবে অ্যাপয়েন্টমেন্ট বা সিরিয়াল নেব?

            </button>
          </h2>
          <div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq3">
            <div class="accordion-body">

              অ্যাপয়েন্টমেন্ট বা সিরিয়ালের জন্য
              <a href="tel:01640167617">
                01640-167617
              </a>
              নম্বরে যোগাযোগ করতে পারেন।
              এছাড়াও নির্দিষ্ট হাসপাতালের নিজস্ব যোগাযোগ নম্বরেও
              যোগাযোগ করা যাবে।

            </div>
          </div>
        </div>
        <!-- FAQ 04 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" data-bs-target="#faq4" data-bs-toggle="collapse">

              উপশম হেলথ পয়েন্ট কোথায় অবস্থিত?

            </button>
          </h2>
          <div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq4">
            <div class="accordion-body">

              উপশম হেলথ পয়েন্ট (প্রাঃ) লিঃ অবস্থিত—
              বাড়ি # ১৪, রোড # ২/বি, ব্লক # জে (দক্ষিণ),
              বারিধারা, ঢাকা-১২১২।

            </div>
          </div>
        </div>
        <!-- FAQ 05 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" data-bs-target="#faq5" data-bs-toggle="collapse">

              উপশম হেলথ পয়েন্টের যোগাযোগ নম্বর কী?

            </button>
          </h2>
          <div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq5">
            <div class="accordion-body">

              উপশম হেলথ পয়েন্টের যোগাযোগ নম্বর:
              <br />
              <a href="tel:01932200200">
                01932-200200
              </a>
              <br />
              <a href="tel:01713888100">
                01713-888100
              </a>
              <br /><br />

              সাধারণ সিরিয়াল/যোগাযোগ:
              <a href="tel:01640167617">
                01640-167617
              </a>
            </div>
          </div>
        </div>
        <!-- FAQ 06 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" data-bs-target="#faq6" data-bs-toggle="collapse">

              বাংলাদেশ শিশু হাসপাতাল ও ইনস্টিটিউটে কী ধরনের সেবা পাওয়া যায়?

            </button>
          </h2>
          <div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq6">
            <div class="accordion-body">

              শিশু, কিশোর ও নবজাতকের বিভিন্ন সমস্যা এবং
              শিশু সার্জারি সংক্রান্ত বিশেষজ্ঞ চিকিৎসাসেবা
              সম্পর্কে পরামর্শ নেওয়া যায়।

            </div>
          </div>
        </div>
        <!-- FAQ 07 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" data-bs-target="#faq7" data-bs-toggle="collapse">

              বাংলাদেশ শিশু হাসপাতাল ও ইনস্টিটিউট কোথায়?

            </button>
          </h2>
          <div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq7">
            <div class="accordion-body">

              বাংলাদেশ শিশু হাসপাতাল ও ইনস্টিটিউট
              শেরে বাংলা নগর, ঢাকায় অবস্থিত।

            </div>
          </div>
        </div>
        <!-- FAQ 08 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" data-bs-target="#faq8" data-bs-toggle="collapse">

              ঝিনাইদহে কোথায় রোগী দেখা হয়?

            </button>
          </h2>
          <div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq8">
            <div class="accordion-body">

              ইসলামী ব্যাংক কমিউনিটি হাসপাতাল ঝিনাইদহ লিঃ,
              চুয়াডাঙ্গা বাসস্ট্যান্ড, ঝিনাইদহে রোগী দেখার
              ব্যবস্থা রয়েছে।

            </div>
          </div>
        </div>
        <!-- FAQ 09 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" data-bs-target="#faq9" data-bs-toggle="collapse">

              ঝিনাইদহে কোন দিন ও সময় রোগী দেখা হয়?

            </button>
          </h2>
          <div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq9">
            <div class="accordion-body">

              ইসলামী ব্যাংক কমিউনিটি হাসপাতাল ঝিনাইদহ লিঃ-এ
              প্রতি শুক্রবার বিকাল ৪টা থেকে রাত ৮টা পর্যন্ত
              রোগী দেখার সময় নির্ধারিত রয়েছে।

            </div>
          </div>
        </div>
        <!-- FAQ 10 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" data-bs-target="#faq10" data-bs-toggle="collapse">

              ঝিনাইদহ হাসপাতালের যোগাযোগ নম্বর কী?

            </button>
          </h2>
          <div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq10">
            <div class="accordion-body">

              ইসলামী ব্যাংক কমিউনিটি হাসপাতাল ঝিনাইদহ লিঃ-এর
              যোগাযোগ নম্বর:

              <br />
              <a href="tel:01716853022">
                01716-853022
              </a>
              <br />
              <a href="tel:01712058201">
                01712-058201
              </a>
              <br /><br />

              ই-মেইল:
              <a href="mailto:ibchj@gmail.com">
                ibchj@gmail.com
              </a>
            </div>
          </div>
        </div>
        <!-- FAQ 11 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" data-bs-target="#faq11" data-bs-toggle="collapse">

              সাধারণ যোগাযোগ বা সিরিয়ালের জন্য কোন নম্বরে কল করব?

            </button>
          </h2>
          <div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq11">
            <div class="accordion-body">

              সাধারণ সিরিয়াল ও যোগাযোগের জন্য
              <a href="tel:01640167617">
                01640-167617
              </a>
              নম্বরে কল করতে পারেন।

            </div>
          </div>
        </div>
        <!-- FAQ 12 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" data-bs-target="#faq12" data-bs-toggle="collapse">

              কোন কোন শিশু সার্জারি সংক্রান্ত সমস্যা নিয়ে পরামর্শ নেওয়া যায়?

            </button>
          </h2>
          <div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq12">
            <div class="accordion-body">

              পোস্টারে উল্লেখিত বিভিন্ন শিশু সার্জারি ও
              সংশ্লিষ্ট সমস্যার মধ্যে হার্নিয়া, হাইড্রোসিল,
              কিডনিতে পাথর, কিডনিতে পানি জমা, পেটব্যথা,
              অ্যাপেন্ডিসাইটিস, জন্মগত ত্রুটি, নাভির সমস্যা,
              মূত্রনালীর বিভিন্ন সমস্যা এবং অন্যান্য
              সার্জিক্যাল সমস্যা রয়েছে।

            </div>
          </div>
        </div>
        <!-- FAQ 13 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" data-bs-target="#faq13" data-bs-toggle="collapse">

              নবজাতকের সমস্যার জন্য কি পরামর্শ নেওয়া যায়?

            </button>
          </h2>
          <div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq13">
            <div class="accordion-body">

              হ্যাঁ। নবজাতকের বিভিন্ন জন্মগত সমস্যা ও
              সার্জিক্যাল সমস্যার ক্ষেত্রে বিশেষজ্ঞ
              পরামর্শের জন্য যোগাযোগ করা যেতে পারে।

            </div>
          </div>
        </div>
        <!-- FAQ 14 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" data-bs-target="#faq14" data-bs-toggle="collapse">

              জন্মগত ত্রুটি বা জন্মগত কোনো সমস্যা থাকলে কী করব?

            </button>
          </h2>
          <div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq14">
            <div class="accordion-body">

              শিশুর জন্মগত কোনো ত্রুটি বা অস্বাভাবিকতা থাকলে
              রোগীর অবস্থা অনুযায়ী বিশেষজ্ঞ চিকিৎসকের
              পরামর্শ নেওয়া যেতে পারে। প্রয়োজনে পূর্বের
              রিপোর্ট ও চিকিৎসার কাগজপত্র সঙ্গে নিয়ে আসুন।

            </div>
          </div>
        </div>
        <!-- FAQ 15 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" data-bs-target="#faq15" data-bs-toggle="collapse">

              অ্যাপয়েন্টমেন্টের সময় কী কী সঙ্গে নিয়ে আসব?

            </button>
          </h2>
          <div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq15">
            <div class="accordion-body">

              আগে কোনো চিকিৎসা হয়ে থাকলে পূর্বের প্রেসক্রিপশন,
              রিপোর্ট, পরীক্ষা-নিরীক্ষার ফলাফল, অপারেশনের কাগজপত্র
              এবং বর্তমানে ব্যবহৃত ওষুধের তথ্য সঙ্গে নিয়ে আসা
              উপকারী হতে পারে।

            </div>
          </div>
        </div>
        <!-- FAQ 16 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" data-bs-target="#faq16" data-bs-toggle="collapse">

              আগে অন্য কোথাও চিকিৎসা নিলে সেই রিপোর্ট দেখানো যাবে?

            </button>
          </h2>
          <div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq16">
            <div class="accordion-body">

              অবশ্যই। পূর্বের চিকিৎসার প্রেসক্রিপশন,
              রিপোর্ট, আল্ট্রাসনোগ্রাম, এক্স-রে বা অন্যান্য
              প্রাসঙ্গিক কাগজপত্র থাকলে পরামর্শের সময় সঙ্গে
              নিয়ে আসতে পারেন।

            </div>
          </div>
        </div>
        <!-- FAQ 17 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" data-bs-target="#faq17" data-bs-toggle="collapse">

              অপারেশন বা সার্জারির প্রয়োজন হলে কী হবে?

            </button>
          </h2>
          <div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq17">
            <div class="accordion-body">

              রোগীর অবস্থা মূল্যায়ন করার পর চিকিৎসক প্রয়োজনীয়
              পরীক্ষা-নিরীক্ষা ও চিকিৎসার বিকল্প সম্পর্কে
              অভিভাবককে বিস্তারিত জানাবেন। সার্জারি প্রয়োজন কি না
              তা রোগীর নির্দিষ্ট অবস্থার ভিত্তিতে নির্ধারণ করা হবে।

            </div>
          </div>
        </div>
        <!-- FAQ 18 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" data-bs-target="#faq18" data-bs-toggle="collapse">

              ফলো-আপের জন্য আবার কি অ্যাপয়েন্টমেন্ট নিতে হবে?

            </button>
          </h2>
          <div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq18">
            <div class="accordion-body">

              ফলো-আপের প্রয়োজন হলে চিকিৎসক পরবর্তী সাক্ষাতের
              সময় সম্পর্কে নির্দেশনা দিতে পারেন। পরবর্তী ভিজিটের
              আগে সংশ্লিষ্ট চেম্বারে ফোন করে সময় ও সিরিয়াল
              নিশ্চিত করে নেওয়া ভালো।

            </div>
          </div>
        </div>
        <!-- FAQ 19 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" data-bs-target="#faq19" data-bs-toggle="collapse">

              চেম্বারে যাওয়ার আগে ফোন করে সময় নিশ্চিত করা উচিত কি?

            </button>
          </h2>
          <div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq19">
            <div class="accordion-body">

              হ্যাঁ। চেম্বারের সময়সূচি পরিবর্তিত হতে পারে।
              তাই যাওয়ার আগে সংশ্লিষ্ট হাসপাতাল বা
              <a href="tel:01640167617">
                01640-167617
              </a>
              নম্বরে যোগাযোগ করে সময় ও সিরিয়াল নিশ্চিত করে
              নেওয়া ভালো।

            </div>
          </div>
        </div>
        <!-- FAQ 20 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" data-bs-target="#faq20" data-bs-toggle="collapse">

              জরুরি অবস্থায় কী করব?

            </button>
          </h2>
          <div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq20">
            <div class="accordion-body">

              গুরুতর বা জীবন-ঝুঁকিপূর্ণ অবস্থায় অনলাইন
              অ্যাপয়েন্টমেন্ট বা সাধারণ চেম্বারের সময়ের ওপর
              নির্ভর না করে দ্রুত নিকটস্থ হাসপাতালের জরুরি বিভাগে
              যোগাযোগ করুন।

            </div>
          </div>
        </div>
        <!-- FAQ 21 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" data-bs-target="#faq21" data-bs-toggle="collapse">

              ফোনে কি সরাসরি চিকিৎসার পরামর্শ পাওয়া যাবে?

            </button>
          </h2>
          <div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq21">
            <div class="accordion-body">

              ফোন নম্বরগুলো মূলত সিরিয়াল, অ্যাপয়েন্টমেন্ট,
              চেম্বারের সময় এবং যোগাযোগের জন্য ব্যবহার করা যেতে পারে।
              রোগীর বিস্তারিত মূল্যায়নের প্রয়োজন হলে সরাসরি
              চিকিৎসকের পরামর্শ নেওয়া উপযুক্ত।

            </div>
          </div>
        </div>
        <!-- FAQ 22 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" data-bs-target="#faq22" data-bs-toggle="collapse">

              একাধিক চেম্বারের মধ্যে কোনটি বেছে নেব?

            </button>
          </h2>
          <div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq22">
            <div class="accordion-body">

              আপনার অবস্থান ও সুবিধাজনক সময় অনুযায়ী
              সংশ্লিষ্ট চেম্বার নির্বাচন করতে পারেন।
              Appointment section থেকে প্রতিটি হাসপাতালের
              ঠিকানা, সময় ও যোগাযোগের তথ্য দেখে পছন্দের
              চেম্বারে সিরিয়ালের জন্য যোগাযোগ করুন।

            </div>
          </div>
        </div>
        <!-- FAQ 23 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" data-bs-target="#faq23" data-bs-toggle="collapse">

              চিকিৎসা নিতে কি আগে থেকে অ্যাপয়েন্টমেন্ট নেওয়া জরুরি?

            </button>
          </h2>
          <div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq23">
            <div class="accordion-body">

              সিরিয়াল ও রোগী দেখার সময় নিশ্চিত করার জন্য
              আগে থেকে ফোনে যোগাযোগ করা ভালো। এতে নির্ধারিত
              সময় সম্পর্কে পরিষ্কার ধারণা পাওয়া যাবে।

            </div>
          </div>
        </div>
        <!-- FAQ 24 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" data-bs-target="#faq24" data-bs-toggle="collapse">

              ওয়েবসাইট থেকে কি সরাসরি অ্যাপয়েন্টমেন্ট নেওয়া যায়?

            </button>
          </h2>
          <div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq24">
            <div class="accordion-body">

              ওয়েবসাইটের Appointment section থেকে সংশ্লিষ্ট
              হাসপাতাল নির্বাচন করে তার ঠিকানা, সময় ও
              যোগাযোগের নম্বর দেখা যাবে। এরপর দেওয়া নম্বরে
              কল করে সিরিয়াল বা অ্যাপয়েন্টমেন্ট নিশ্চিত করতে পারবেন।

            </div>
          </div>
        </div>
        <!-- FAQ 25 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" data-bs-target="#faq25" data-bs-toggle="collapse">

              শিশুর সমস্যার জন্য কখন বিশেষজ্ঞের পরামর্শ নেওয়া উচিত?

            </button>
          </h2>
          <div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq25">
            <div class="accordion-body">

              শিশুর কোনো শারীরিক সমস্যা, জন্মগত সমস্যা,
              সার্জিক্যাল সমস্যা বা দীর্ঘদিনের উপসর্গ থাকলে
              রোগীর অবস্থা অনুযায়ী বিশেষজ্ঞ চিকিৎসকের
              পরামর্শ নেওয়া যেতে পারে। গুরুতর উপসর্গ হলে
              দ্রুত চিকিৎসা প্রতিষ্ঠানে যোগাযোগ করুন।

            </div>
          </div>
        </div>
        <!-- FAQ 26 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" data-bs-target="#faq26" data-bs-toggle="collapse">

              শিশুর মূত্রনালী বা ইউরোলজিক্যাল সমস্যা হলে কি পরামর্শ নেওয়া যায়?

            </button>
          </h2>
          <div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq26">
            <div class="accordion-body">

              শিশুদের বিভিন্ন ইউরোলজিক্যাল ও সার্জিক্যাল সমস্যার
              ক্ষেত্রে বিশেষজ্ঞ চিকিৎসকের পরামর্শ নেওয়া যেতে পারে।
              রোগীর নির্দিষ্ট সমস্যার ভিত্তিতে প্রয়োজনীয়
              পরীক্ষা ও চিকিৎসা সম্পর্কে সিদ্ধান্ত নেওয়া হবে।

            </div>
          </div>
        </div>
        <!-- FAQ 27 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" data-bs-target="#faq27" data-bs-toggle="collapse">

              চেম্বারের ঠিকানা ও ফোন নম্বর কোথায় পাব?

            </button>
          </h2>
          <div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq27">
            <div class="accordion-body">

              ওয়েবসাইটের Appointment section-এ প্রতিটি
              হাসপাতালের নামের ওপর ক্লিক করলে আলাদা popup-এ
              ঠিকানা, রোগী দেখার সময়, হাসপাতালের ফোন নম্বর
              এবং সাধারণ সিরিয়াল নম্বর দেখতে পারবেন।

            </div>
          </div>
        </div>
        <!-- FAQ 28 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" data-bs-target="#faq28" data-bs-toggle="collapse">

              অ্যাপয়েন্টমেন্টের জন্য সাধারণ যোগাযোগ নম্বর কী?

            </button>
          </h2>
          <div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq28">
            <div class="accordion-body">

              সাধারণ সিরিয়াল ও যোগাযোগের জন্য:

              <br />
              <a class="fw-semibold" href="tel:01640167617">
                <i class="bi bi-telephone me-1"></i>
                01640-167617

              </a>
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
                প্রতি শুক্রবার<br />
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
            <input name="_subject" type="hidden" value="Dr. Amit Hasan - Website Contact" />
            <input name="_template" type="hidden" value="table" />
            <input name="_captcha" type="hidden" value="true" />
            <!-- Name -->
            <div class="col-md-6">
              <label class="form-label">নাম</label>
              <input class="form-control" name="name" placeholder="আপনার নাম" required="" type="text" />
            </div>
            <!-- Phone -->
            <div class="col-md-6">
              <label class="form-label">ফোন</label>
              <input class="form-control" name="phone" placeholder="01XXXXXXXXX" required="" type="tel" />
            </div>
            <!-- Email -->
            <div class="col-12">
              <label class="form-label">ইমেইল</label>
              <input class="form-control" name="email" placeholder="আপনার ইমেইল" type="email" />
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
          <div class="mb-3"><label class="form-label">রোগীর নাম</label><input class="form-control" required="" />
          </div>
          <div class="mb-3"><label class="form-label">অভিভাবকের ফোন</label><input class="form-control" required="" type="tel" /></div>
          <div class="row g-3">
            <div class="col-6"><label class="form-label">তারিখ</label><input class="form-control" required="" type="date" /></div>
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

@push('scripts')
<script src="{{ asset('frontend/js/main.js') }}"></script>
<script src="{{ asset('frontend/js/services.js') }}"></script>
<script src="{{ asset('frontend/js/conditions.js') }}"></script>
@endpush