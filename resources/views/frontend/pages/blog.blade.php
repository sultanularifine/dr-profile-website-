@extends('frontend.layouts.app')

@section('title', 'ব্লগ | ডা. অমিত হাসান')

@section('content')

<section class="blog-section">

    <div class="container">

        {{-- =========================
            Search
        ========================== --}}

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

            @if(request('category'))

                <input
                    type="hidden"
                    name="category"
                    value="{{ request('category') }}"
                >

            @endif

            <button type="submit">
                <i class="bi bi-search"></i>
            </button>

        </form>


        {{-- =========================
            Categories
        ========================== --}}

        <div class="blog-categories">

            <a
                href="{{ route('blog') }}"
                class="blog-category {{ !request('category') ? 'active' : '' }}"
            >
                সব

                @if($categories->sum('total') > 0)
                    <span>
                        {{ $categories->sum('total') }}
                    </span>
                @endif

            </a>


            @foreach($categories as $category)

                <a
                    href="{{ route('blog', [
                        'category' => $category->category_slug
                    ]) }}"
                    class="blog-category
                    {{ request('category') == $category->category_slug ? 'active' : '' }}"
                >

                    {{ $category->category }}

                    <span>
                        {{ $category->total }}
                    </span>

                </a>

            @endforeach

        </div>


        {{-- =========================
            Active Search Message
        ========================== --}}

        @if(request('search'))

            <div class="mb-4">

                <strong>
                    "{{ request('search') }}"
                </strong>

                এর জন্য অনুসন্ধানের ফলাফল

                <a
                    href="{{ route('blog') }}"
                    class="ms-2"
                >
                    × Clear
                </a>

            </div>

        @endif


        {{-- =========================
            Blog Grid
        ========================== --}}

        <div class="row g-4">

            @forelse($blogs as $blog)

                <div class="col-md-6 col-xl-4">

                    <article class="blog-card">

                        {{-- Image --}}

                        <div class="blog-image">

                            @if($blog->image)

                                <img
                                    src="{{ asset($blog->image) }}"
                                    alt="{{ $blog->title }}"
                                    class="img-fluid"
                                    loading="lazy"
                                >

                            @else

                                <div class="blog-placeholder-icon">

                                    <i
                                        class="bi {{ $blog->icon ?? 'bi-heart-pulse' }}"
                                    ></i>

                                </div>

                            @endif


                            <span class="blog-category-label">
                                {{ $blog->category }}
                            </span>

                        </div>


                        {{-- Body --}}

                        <div class="blog-card-body">

                            <div class="blog-meta">

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

                                    </span>

                                @endif

                            </div>


                            <h3>
                                {{ $blog->title }}
                            </h3>


                            @if($blog->excerpt)

                                <p>
                                    {{ $blog->excerpt }}
                                </p>

                            @endif


                            <a
                                href="{{ route('blog.view', $blog) }}"
                                class="blog-read-more"
                            >

                                বিস্তারিত পড়ুন

                                <i class="bi bi-arrow-right"></i>

                            </a>

                        </div>

                    </article>

                </div>

            @empty

                <div class="col-12">

                    <div class="text-center py-5">

                        <i
                            class="bi bi-journal-x"
                            style="font-size: 50px;"
                        ></i>

                        <h3 class="mt-3">
                            কোনো ব্লগ পাওয়া যায়নি।
                        </h3>

                        <p>
                            অন্য কোনো শব্দ দিয়ে আবার চেষ্টা করুন।
                        </p>

                        <a
                            href="{{ route('blog') }}"
                            class="btn btn-primary"
                        >
                            সব ব্লগ দেখুন
                        </a>

                    </div>

                </div>

            @endforelse

        </div>


        {{-- =========================
            Pagination
        ========================== --}}

        @if($blogs->hasPages())

            <div class="mt-5">

                {{ $blogs->onEachSide(1)->links() }}

            </div>

        @endif

    </div>

</section>

@endsection