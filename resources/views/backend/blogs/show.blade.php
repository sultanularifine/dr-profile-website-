@extends('backend.layouts.app')

@section('title', 'View Blog')

@section('main')

<div class="main-content">

    <section class="section">


        {{-- =====================================================
            HEADER
        ====================================================== --}}
        <div class="section-header">

            <h1>
                <i class="fas fa-blog mr-2"></i>
                View Blog
            </h1>


            <div class="section-header-breadcrumb">

                <div class="breadcrumb-item active">

                    <a href="{{ route('backend.blogs.index') }}">
                        Blogs
                    </a>

                </div>


                <div class="breadcrumb-item">
                    View Blog
                </div>

            </div>

        </div>



        {{-- =====================================================
            BODY
        ====================================================== --}}
        <div class="section-body">


            {{-- =================================================
                SUCCESS MESSAGE
            ================================================== --}}
            @if(session('success'))

                <div class="alert alert-success alert-dismissible fade show">

                    <i class="fas fa-check-circle mr-1"></i>

                    {{ session('success') }}


                    <button
                        type="button"
                        class="close"
                        data-dismiss="alert"
                    >

                        <span>&times;</span>

                    </button>

                </div>

            @endif



            {{-- =================================================
                ERROR MESSAGE
            ================================================== --}}
            @if(session('error'))

                <div class="alert alert-danger alert-dismissible fade show">

                    <i class="fas fa-exclamation-triangle mr-1"></i>

                    {{ session('error') }}


                    <button
                        type="button"
                        class="close"
                        data-dismiss="alert"
                    >

                        <span>&times;</span>

                    </button>

                </div>

            @endif



            <div class="row">


                {{-- =================================================
                    MAIN CONTENT
                ================================================== --}}
                <div class="col-lg-8">


                    <div class="card">


                        {{-- =================================================
                            FEATURED IMAGE
                        ================================================== --}}
                        @if($blog->image)

                            <div class="blog-featured-image">

                                <img
                                    src="{{ asset($blog->image) }}"
                                    alt="{{ $blog->title }}"
                                    class="card-img-top"
                                    style="
                                        width:100%;
                                        max-height:420px;
                                        object-fit:cover;
                                    "
                                >

                            </div>

                        @endif



                        <div class="card-body">


                            {{-- =================================================
                                CATEGORY + STATUS
                            ================================================== --}}
                            <div class="mb-3">


                                @if($blog->category)

                                    <span class="badge badge-info mr-1">

                                        <i class="fas fa-folder mr-1"></i>

                                        {{ $blog->category }}

                                    </span>

                                @endif



                                @if($blog->is_published)

                                    <span class="badge badge-success">

                                        <i class="fas fa-check-circle mr-1"></i>

                                        Published

                                    </span>

                                @else

                                    <span class="badge badge-warning">

                                        <i class="fas fa-edit mr-1"></i>

                                        Draft

                                    </span>

                                @endif

                            </div>



                            {{-- =================================================
                                TITLE
                            ================================================== --}}
                            <h2 class="mb-3">

                                {{ $blog->title }}

                            </h2>



                            {{-- =================================================
                                META
                            ================================================== --}}
                            <div class="text-muted mb-4">


                                @if($blog->published_at)

                                    <span class="mr-3">

                                        <i class="fas fa-calendar-alt mr-1"></i>

                                        {{ $blog->published_at->format('d M Y') }}

                                    </span>

                                @endif



                                @if($blog->read_time)

                                    <span class="mr-3">

                                        <i class="fas fa-clock mr-1"></i>

                                        {{ $blog->read_time }}

                                    </span>

                                @endif



                                <span>

                                    <i class="fas fa-eye mr-1"></i>

                                    Admin Preview

                                </span>

                            </div>



                            {{-- =================================================
                                SHORT SUMMARY
                            ================================================== --}}
                            @if($blog->excerpt)

                                <div class="alert alert-light border">

                                    <h6 class="mb-2">

                                        <i class="fas fa-align-left mr-1"></i>

                                        Short Description

                                    </h6>


                                    <p class="mb-0">

                                        {{ $blog->excerpt }}

                                    </p>

                                </div>

                            @endif



                            <hr>



                            {{-- =================================================
                                BLOG CONTENT
                            ================================================== --}}
                            <div class="blog-content">

                                {!! $blog->content !!}

                            </div>


                        </div>

                    </div>

                </div>



                {{-- =================================================
                    SIDEBAR
                ================================================== --}}
                <div class="col-lg-4">


                    {{-- =================================================
                        BLOG INFORMATION
                    ================================================== --}}
                    <div class="card">


                        <div class="card-header">

                            <h4>

                                <i class="fas fa-info-circle mr-2"></i>

                                Blog Information

                            </h4>

                        </div>



                        <div class="card-body">


                            {{-- CATEGORY --}}
                            <div class="mb-3">

                                <strong>
                                    Category
                                </strong>


                                <p class="mb-0 text-muted">

                                    {{ $blog->category ?: 'N/A' }}

                                </p>

                            </div>



                            {{-- CATEGORY SLUG --}}
                            <div class="mb-3">

                                <strong>
                                    Category Slug
                                </strong>


                                <p class="mb-0">

                                    <code>
                                        {{ $blog->category_slug ?: 'N/A' }}
                                    </code>

                                </p>

                            </div>



                            {{-- BLOG SLUG --}}
                            <div class="mb-3">

                                <strong>
                                    Blog Slug
                                </strong>


                                <div class="input-group mt-1">

                                    <input
                                        type="text"
                                        id="blog-slug"
                                        class="form-control form-control-sm"
                                        value="{{ $blog->slug }}"
                                        readonly
                                    >


                                    <div class="input-group-append">

                                        <button
                                            type="button"
                                            id="copy-slug-btn"
                                            class="btn btn-outline-primary btn-sm"
                                            title="Copy Slug"
                                        >

                                            <i class="fas fa-copy"></i>

                                        </button>

                                    </div>

                                </div>

                            </div>



                            {{-- READ TIME --}}
                            <div class="mb-3">

                                <strong>
                                    Read Time
                                </strong>


                                <p class="mb-0 text-muted">

                                    {{ $blog->read_time ?: 'N/A' }}

                                </p>

                            </div>



                            {{-- ICON --}}
                            <div class="mb-3">

                                <strong>
                                    Icon
                                </strong>


                                <p class="mb-0">

                                    @if($blog->icon)

                                        <i class="{{ $blog->icon }} mr-1"></i>

                                        <code>
                                            {{ $blog->icon }}
                                        </code>

                                    @else

                                        <span class="text-muted">
                                            N/A
                                        </span>

                                    @endif

                                </p>

                            </div>



                            {{-- CREATED --}}
                            <div class="mb-3">

                                <strong>
                                    Created At
                                </strong>


                                <p class="mb-0 text-muted">

                                    @if($blog->created_at)

                                        {{ $blog->created_at->format('d M Y, h:i A') }}

                                    @else

                                        N/A

                                    @endif

                                </p>

                            </div>



                            {{-- UPDATED --}}
                            <div>

                                <strong>
                                    Updated At
                                </strong>


                                <p class="mb-0 text-muted">

                                    @if($blog->updated_at)

                                        {{ $blog->updated_at->format('d M Y, h:i A') }}

                                    @else

                                        N/A

                                    @endif

                                </p>

                            </div>


                        </div>

                    </div>



                    {{-- =================================================
                        TAGS
                    ================================================== --}}
                    @php

                        $tags = $blog->tags;

                        if (!is_array($tags)) {
                            $tags = [];
                        }

                    @endphp


                    @if(count($tags) > 0)

                        <div class="card">


                            <div class="card-header">

                                <h4>

                                    <i class="fas fa-tags mr-2"></i>

                                    Tags

                                </h4>

                            </div>



                            <div class="card-body">

                                @foreach($tags as $tag)

                                    @if(!empty(trim($tag)))

                                        <span class="badge badge-primary mr-1 mb-1">

                                            <i class="fas fa-tag mr-1"></i>

                                            {{ $tag }}

                                        </span>

                                    @endif

                                @endforeach

                            </div>

                        </div>

                    @endif



                    {{-- =================================================
                        ACTIONS
                    ================================================== --}}
                    <div class="card">


                        <div class="card-header">

                            <h4>

                                <i class="fas fa-cogs mr-2"></i>

                                Actions

                            </h4>

                        </div>



                        <div class="card-body">


                            {{-- EDIT --}}
                            <a
                                href="{{ route('backend.blogs.edit', $blog) }}"
                                class="btn btn-primary btn-block mb-2"
                            >

                                <i class="fas fa-edit mr-1"></i>

                                Edit Blog

                            </a>



                            {{-- FRONTEND VIEW --}}
                            @if($blog->is_published)

                                <a
                                    href="{{ route('blog.view', $blog) }}"
                                    target="_blank"
                                    class="btn btn-info btn-block mb-2"
                                >

                                    <i class="fas fa-external-link-alt mr-1"></i>

                                    View on Website

                                </a>

                            @endif



                            {{-- BACK --}}
                            <a
                                href="{{ route('backend.blogs.index') }}"
                                class="btn btn-secondary btn-block mb-2"
                            >

                                <i class="fas fa-arrow-left mr-1"></i>

                                Back to Blogs

                            </a>



                            {{-- DELETE --}}
                            <form
                                action="{{ route('backend.blogs.destroy', $blog) }}"
                                method="POST"
                                id="delete-blog-form"
                            >

                                @csrf

                                @method('DELETE')


                                <button
                                    type="submit"
                                    id="delete-blog-btn"
                                    class="btn btn-danger btn-block"
                                >

                                    <i class="fas fa-trash mr-1"></i>

                                    Delete Blog

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection



{{-- =====================================================
    SCRIPTS
====================================================== --}}
@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    'use strict';



    /* =====================================================
       COPY BLOG SLUG
    ====================================================== */

    const copyButton =
        document.getElementById('copy-slug-btn');

    const slugInput =
        document.getElementById('blog-slug');


    if (copyButton && slugInput) {

        copyButton.addEventListener(
            'click',
            function () {


                const slug =
                    slugInput.value;


                /*
                |--------------------------------------------------------------------------
                | Modern Clipboard API
                |--------------------------------------------------------------------------
                */

                if (
                    navigator.clipboard &&
                    window.isSecureContext
                ) {

                    navigator.clipboard
                        .writeText(slug)
                        .then(function () {

                            showCopySuccess();

                        })
                        .catch(function () {

                            fallbackCopy(slug);

                        });

                } else {

                    fallbackCopy(slug);

                }

            }
        );

    }



    /* =====================================================
       FALLBACK COPY
    ====================================================== */

    function fallbackCopy(text) {

        const tempInput =
            document.createElement('textarea');


        tempInput.value = text;

        tempInput.style.position =
            'fixed';

        tempInput.style.left =
            '-9999px';


        document.body.appendChild(
            tempInput
        );


        tempInput.select();


        try {

            document.execCommand(
                'copy'
            );

            showCopySuccess();

        } catch (error) {

            alert(
                'Slug copy করা যায়নি।'
            );

        }


        document.body.removeChild(
            tempInput
        );

    }



    /* =====================================================
       COPY SUCCESS
    ====================================================== */

    function showCopySuccess() {

        if (!copyButton) {
            return;
        }


        const oldHtml =
            copyButton.innerHTML;


        copyButton.innerHTML =
            '<i class="fas fa-check"></i>';


        copyButton.classList.remove(
            'btn-outline-primary'
        );


        copyButton.classList.add(
            'btn-success'
        );


        setTimeout(function () {

            copyButton.innerHTML =
                oldHtml;


            copyButton.classList.remove(
                'btn-success'
            );


            copyButton.classList.add(
                'btn-outline-primary'
            );

        }, 1500);

    }



    /* =====================================================
       DELETE CONFIRMATION
    ====================================================== */

    const deleteForm =
        document.getElementById(
            'delete-blog-form'
        );


    const deleteButton =
        document.getElementById(
            'delete-blog-btn'
        );


    if (deleteForm) {

        deleteForm.addEventListener(
            'submit',
            function (event) {


                const confirmed =
                    confirm(
                        'আপনি কি নিশ্চিতভাবে এই Blog টি Delete করতে চান?\n\nএই কাজটি Undo করা যাবে না।'
                    );


                if (!confirmed) {

                    event.preventDefault();

                    return false;

                }


                /*
                |--------------------------------------------------------------------------
                | Prevent double delete
                |--------------------------------------------------------------------------
                */

                if (deleteButton) {

                    deleteButton.disabled =
                        true;


                    deleteButton.innerHTML =
                        '<i class="fas fa-spinner fa-spin"></i> Deleting...';

                }

            }
        );

    }

});

</script>

@endpush