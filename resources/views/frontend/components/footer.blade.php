<footer class="pt-5 pb-4">
    <div class="container">
        <div class="row g-4">
            <!-- Doctor -->
            <div class="col-lg-5">
                <h4 class="footer-title">{{ site_content('shared_footer.639', '
                    ডা. অমিত হাসান
                ') }}</h4>
                <p class="mb-3">{{ site_content('shared_footer.640', '
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
                <h6 class="footer-title">{{ site_content('shared_footer.641', '
                    দ্রুত লিংক
                ') }}</h6>
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('about') }}">{{ site_content('shared_footer.642', '
                        পরিচিতি
                    ') }}</a>
                    <a href="{{ route('services') }}">{{ site_content('shared_footer.643', '
                        সেবা
                    ') }}</a>
                  
                    <a href="{{ route('appointment') }}">{{ site_content('shared_footer.644', '
                        অ্যাপয়েন্টমেন্ট
                    ') }}</a>
                    <a href="{{ route('faq') }}">{{ site_content('shared_footer.645', '
                        সাধারণ জিজ্ঞাসা
                    ') }}</a>
                    <a href="{{ route('contact') }}">{{ site_content('shared_footer.646', '
                        যোগাযোগ
                    ') }}</a>
                </div>
            </div>
            <!-- Chamber -->
            <div class="col-6 col-lg-4">
                <h6 class="footer-title">{{ site_content('shared_footer.647', '
                    চেম্বার
                ') }}</h6>
                <p class="mb-1">{{ site_content('shared_footer.648', '
                    ইসলামী ব্যাংক কমিউনিটি হাসপাতাল
                    ঝিনাইদহ লিঃ
                ') }}</p>
                <p class="small mb-1">{{ site_content('shared_footer.649', '
                    চুয়াডাঙ্গা বাসস্ট্যান্ড,
                    ঝিনাইদহ।
                ') }}</p>
                <p class="small mb-1">{{ site_content('shared_footer.650', '
                    শুক্রবার: বিকাল ৪টা – রাত ৮টা
                ') }}</p>
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', (string)($adminPublicSettings['secondary_public_phone'] ?? '01640-167617')) }}">{{ $adminPublicSettings['secondary_public_phone'] ?? site_content('shared_footer.651', '০১৬৪০-১৬৭৬১৭') }}</a>
                <br />
                <a href="mailto:{{ $adminPublicSettings['public_email'] ?? 'ibchj@gmail.com' }}">
                    {{ $adminPublicSettings['public_email'] ?? 'ibchj@gmail.com' }}
                </a>
            </div>
        </div>
        <hr class="border-light opacity-10 my-4" />
        <div class="d-flex flex-wrap justify-content-between gap-2 small">
            <span>
                © <span id="year"></span>{{ site_content('shared_footer.652', '
                Dr. Amit Hasan. All rights reserved.
            ') }}</span>
        </div>
    </div>
</footer>
