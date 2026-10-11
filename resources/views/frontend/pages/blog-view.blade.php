@extends('frontend.layouts.app')

@section('title', ($blog->seo_title ?: $blog->title) . ' | ডা. অমিত হাসান')

@section('meta_description', $blog->meta_description ?: $blog->excerpt)

@section('content')

{{-- =========================================================
     SEO META
========================================================= --}}

@push('meta')

    <meta
        name="description"
        content="{{ $blog->meta_description ?: $blog->excerpt }}"
    >

    <meta
        name="robots"
        content="index, follow"
    >

    <link
        rel="canonical"
        href="{{ $blog->canonical_url ?: url()->current() }}"
    >

    {{-- Open Graph --}}

    <meta
        property="og:type"
        content="article"
    >

    <meta
        property="og:title"
        content="{{ $blog->og_title ?: ($blog->seo_title ?: $blog->title) }}"
    >

    <meta
        property="og:description"
        content="{{ $blog->og_description ?: ($blog->meta_description ?: $blog->excerpt) }}"
    >

    <meta
        property="og:url"
        content="{{ url()->current() }}"
    >

    <meta
        property="og:site_name"
        content="ডা. অমিত হাসান"
    >

    @if($blog->image)

        <meta
            property="og:image"
            content="{{ asset($blog->image) }}"
        >

    @endif

    {{-- Twitter --}}

    <meta
        name="twitter:card"
        content="summary_large_image"
    >

    <meta
        name="twitter:title"
        content="{{ $blog->og_title ?: ($blog->seo_title ?: $blog->title) }}"
    >

    <meta
        name="twitter:description"
        content="{{ $blog->og_description ?: ($blog->meta_description ?: $blog->excerpt) }}"
    >

    @if($blog->image)

        <meta
            name="twitter:image"
            content="{{ asset($blog->image) }}"
        >

    @endif

@endpush



<!-- =========================================================
     HERO
========================================================= -->

<section class="blog-single-hero">

    <div class="container">

        <div class="blog-breadcrumb">

            <a href="{{ route('home') }}">
                হোম
            </a>

            <i class="bi bi-chevron-right"></i>

            <a href="{{ route('blog') }}">
                ব্লগ
            </a>

            <i class="bi bi-chevron-right"></i>

            <span>
                {{ $blog->category }}
            </span>

        </div>


        <div class="blog-single-category">

            <span>
                {{ $blog->category }}
            </span>

        </div>


        <h1>
            {{ $blog->title }}
        </h1>


        <div class="blog-single-meta">

            @if($blog->published_at)

                <span>

                    <i class="bi bi-calendar3"></i>

                    {{ $blog->published_at->format('d F Y') }}

                </span>

            @endif


            @if($blog->read_time)

                <span>

                    <i class="bi bi-clock"></i>

                    {{ $blog->read_time }}
                    পড়তে সময় লাগবে

                </span>

            @endif


            <span>

                <i class="bi bi-person"></i>

                ডা. অমিত হাসান

            </span>

        </div>

    </div>

</section>



<!-- =========================================================
     BLOG CONTENT
========================================================= -->

<main class="blog-single-section">

    <div class="container">

        <div class="row g-5">


            {{-- =================================================
                 MAIN
            ================================================== --}}

            <div class="col-lg-8">

                <article class="blog-single-card">


                    {{-- FEATURED IMAGE --}}

                    @if($blog->image)

                        <div class="blog-single-featured">

                            <img
                                src="{{ asset($blog->image) }}"
                                alt="{{ $blog->title }}"
                                loading="eager"
                                fetchpriority="high"
                            >

                        </div>

                    @else

                        <div class="blog-single-featured blog-single-featured-empty">

                            <div class="featured-icon">

                                <i class="bi {{ $blog->icon ?: 'bi-heart-pulse' }}"></i>

                            </div>

                        </div>

                    @endif


                    {{-- ARTICLE --}}

                    <div class="blog-article-body">

                        <div class="article-intro">

                            <strong>
                                গুরুত্বপূর্ণ তথ্য:
                            </strong>

                            এই লেখাটি সাধারণ স্বাস্থ্য তথ্যের জন্য।
                            ব্যক্তিগত চিকিৎসার ক্ষেত্রে যোগ্য চিকিৎসকের
                            পরামর্শ গ্রহণ করুন।

                        </div>


                        <div class="blog-article-content">

                            <div class="blog-content-wrapper">

                                {!! $blog->content !!}

                            </div>

                        </div>


                        {{-- TAGS --}}

                        @if(is_array($blog->tags) && count($blog->tags))

                            <div class="article-tags">

                                <span>

                                    <i class="bi bi-tags"></i>

                                    ট্যাগ:

                                </span>


                                @foreach($blog->tags as $tag)

                                    @if(!empty($tag))

                                        <a
                                            href="{{ route('blog', ['search' => $tag]) }}"
                                        >
                                            {{ $tag }}
                                        </a>

                                    @endif

                                @endforeach

                            </div>

                        @endif


                        {{-- SHARE --}}

                        <div class="article-share">

                            <span>
                                শেয়ার করুন:
                            </span>


                            <button
                                type="button"
                                class="share-btn facebook"
                                onclick="shareFacebook()"
                                aria-label="Facebook এ শেয়ার করুন"
                            >

                                <i class="bi bi-facebook"></i>

                            </button>


                            <button
                                type="button"
                                class="share-btn whatsapp"
                                onclick="shareWhatsApp()"
                                aria-label="WhatsApp এ শেয়ার করুন"
                            >

                                <i class="bi bi-whatsapp"></i>

                            </button>


                            <button
                                type="button"
                                class="share-btn copy"
                                onclick="copyBlogLink()"
                                aria-label="লিংক কপি করুন"
                            >

                                <i class="bi bi-link-45deg"></i>

                            </button>

                        </div>

                    </div>

                </article>


                {{-- AUTHOR --}}

                <div class="blog-author-box">

                    <div class="author-avatar">

                        <i class="bi bi-person"></i>

                    </div>


                    <div>

                        <span>
                            লেখক
                        </span>

                        <h4>
                            ডা. অমিত হাসান
                        </h4>

                        <p>
                            শিশু, কিশোর ও নবজাতক বিশেষজ্ঞ
                            এবং শিশু সার্জন।
                        </p>

                    </div>

                </div>


                {{-- RELATED BLOGS --}}

                @if($relatedBlogs->count())

                    <div class="related-blog-section">

                        <div class="related-heading">

                            <span>
                                RELATED ARTICLES
                            </span>

                            <h2>
                                আরও পড়ুন
                            </h2>

                        </div>


                        <div class="row g-4">

                            @foreach($relatedBlogs as $related)

                                <div class="col-md-6 col-lg-4">

                                    <article class="blog-card">

                                        <div class="blog-image">

                                            @if($related->image)

                                                <img
                                                    src="{{ asset($related->image) }}"
                                                    alt="{{ $related->title }}"
                                                    loading="lazy"
                                                >

                                            @else

                                                <div class="blog-placeholder-icon">

                                                    <i class="bi {{ $related->icon ?: 'bi-heart-pulse' }}"></i>

                                                </div>

                                            @endif


                                            <span class="blog-category-label">

                                                {{ $related->category }}

                                            </span>

                                        </div>


                                        <div class="blog-card-body">

                                            <h3>
                                                {{ $related->title }}
                                            </h3>


                                            @if($related->excerpt)

                                                <p>
                                                    {{ \Illuminate\Support\Str::limit($related->excerpt, 120) }}
                                                </p>

                                            @endif


                                            <a
                                                href="{{ route('blog.view', $related) }}"
                                                class="blog-read-more"
                                            >

                                                বিস্তারিত পড়ুন

                                                <i class="bi bi-arrow-right"></i>

                                            </a>

                                        </div>

                                    </article>

                                </div>

                            @endforeach

                        </div>

                    </div>

                @endif

            </div>



            {{-- =================================================
                 SIDEBAR
            ================================================== --}}

            <div class="col-lg-4">

                <aside class="blog-sidebar">


                    {{-- SEARCH --}}

                    <div class="sidebar-widget">

                        <h4>
                            ব্লগ খুঁজুন
                        </h4>

                        <form
                            action="{{ route('blog') }}"
                            method="GET"
                            class="sidebar-search"
                        >

                            <input
                                type="search"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="ব্লগ খুঁজুন..."
                                aria-label="ব্লগ খুঁজুন"
                            >

                            <button type="submit">

                                <i class="bi bi-search"></i>

                            </button>

                        </form>

                    </div>


                    {{-- CATEGORIES --}}

                    <div class="sidebar-widget">

                        <h4>
                            ক্যাটাগরি
                        </h4>

                        <ul class="sidebar-category-list">

                            @foreach($categories as $category)

                                <li>

                                    <a
                                        href="{{ route('blog', ['category' => $category->category_slug]) }}"
                                    >

                                        {{ $category->category }}

                                        <span>
                                            {{ $category->total }}
                                        </span>

                                    </a>

                                </li>

                            @endforeach

                        </ul>

                    </div>


                    {{-- APPOINTMENT --}}

                    <div class="sidebar-appointment">

                        <div class="appointment-icon">

                            <i class="bi bi-calendar2-check"></i>

                        </div>

                        <h3>
                            পরামর্শের প্রয়োজন?
                        </h3>

                        <p>
                            আপনার শিশুর স্বাস্থ্য নিয়ে কোনো প্রশ্ন
                            থাকলে অ্যাপয়েন্টমেন্ট নিতে পারেন।
                        </p>

                        <a
                            class="sidebar-appointment-btn"
                            href="{{ route('appointment') }}"
                        >

                            অ্যাপয়েন্টমেন্ট নিন

                            <i class="bi bi-arrow-right"></i>

                        </a>

                    </div>

                </aside>

            </div>

        </div>

    </div>

</main>

@endsection



{{-- =========================================================
     SHARE JS
========================================================= --}}

@push('scripts')

<script>

function shareFacebook()
{
    const url =
        encodeURIComponent(window.location.href);

    window.open(
        'https://www.facebook.com/sharer/sharer.php?u=' + url,
        '_blank',
        'width=700,height=500'
    );
}


function shareWhatsApp()
{
    const text =
        encodeURIComponent(
            document.title + ' - ' + window.location.href
        );

    window.open(
        'https://wa.me/?text=' + text,
        '_blank'
    );
}


function copyBlogLink()
{
    const url =
        window.location.href;


    if (
        navigator.clipboard &&
        window.isSecureContext
    ) {

        navigator.clipboard
            .writeText(url)
            .then(function () {

                alert(
                    'ব্লগের লিংক কপি হয়েছে।'
                );

            })
            .catch(function () {

                fallbackCopy(url);

            });

    } else {

        fallbackCopy(url);

    }
}


function fallbackCopy(text)
{
    const textarea =
        document.createElement('textarea');

    textarea.value =
        text;

    textarea.style.position =
        'fixed';

    textarea.style.left =
        '-999999px';

    textarea.style.top =
        '0';

    document.body.appendChild(
        textarea
    );

    textarea.focus();

    textarea.select();

    try {

        document.execCommand('copy');

        alert(
            'ব্লগের লিংক কপি হয়েছে।'
        );

    } catch (error) {

        alert(
            'লিংক কপি করা যায়নি।'
        );

    }

    document.body.removeChild(
        textarea
    );
}

</script>

@endpush



{{-- =========================================================
     FEATURED IMAGE FIX CSS
========================================================= --}}

@push('styles')

<style>

.blog-single-card {
    width: 100%;
    max-width: 100%;
    position: relative;
    display: block;
    overflow: hidden;
}


.blog-single-featured {
    width: 100%;
    height: 380px;
    position: relative;
    overflow: hidden;
    margin: 0;
    padding: 0;
    background: #f5f8fb;
}


.blog-single-featured img {
    width: 100% !important;
    height: 100% !important;
    display: block !important;
    object-fit: cover !important;
    object-position: center center !important;
    margin: 0 !important;
    padding: 0 !important;
    float: none !important;
}


.blog-single-featured-empty {
    display: flex;
    align-items: center;
    justify-content: center;
}


.featured-icon {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
    box-shadow: 0 10px 30px rgba(0,0,0,.08);
}


.featured-icon i {
    font-size: 42px;
}


.blog-article-body,
.blog-article-content,
.blog-content-wrapper {
    width: 100%;
    position: relative;
    display: block;
    clear: both;
}


.blog-content-wrapper {
    overflow-wrap: break-word;
    word-wrap: break-word;
}


.blog-content-wrapper p,
.blog-content-wrapper h1,
.blog-content-wrapper h2,
.blog-content-wrapper h3,
.blog-content-wrapper h4,
.blog-content-wrapper h5,
.blog-content-wrapper h6,
.blog-content-wrapper ul,
.blog-content-wrapper ol,
.blog-content-wrapper blockquote,
.blog-content-wrapper table {
    float: none !important;
    position: static !important;
}


.blog-content-wrapper img {
    max-width: 100% !important;
    height: auto !important;
    display: block !important;
    float: none !important;
    margin: 25px auto !important;
}


.blog-content-wrapper table {
    width: 100%;
    max-width: 100%;
    border-collapse: collapse;
    overflow-x: auto;
}


.blog-content-wrapper iframe,
.blog-content-wrapper video {
    max-width: 100%;
}


.blog-content-wrapper a {
    overflow-wrap: anywhere;
    word-break: break-word;
}


.blog-content-wrapper blockquote {
    margin-left: 0;
    margin-right: 0;
}


@media (max-width: 991px) {

    .blog-single-featured {
        height: 320px;
    }

}


@media (max-width: 767px) {

    .blog-single-featured {
        height: 240px;
    }

}


@media (max-width: 480px) {

    .blog-single-featured {
        height: 210px;
    }

    .featured-icon {
        width: 70px;
        height: 70px;
    }

    .featured-icon i {
        font-size: 32px;
    }

}

</style>

@endpush