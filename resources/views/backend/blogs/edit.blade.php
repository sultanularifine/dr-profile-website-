@extends('backend.layouts.app')

@section('title', 'Edit Blog')

@section('main')

<div class="main-content">

    <section class="section">

        {{-- =====================================================
            HEADER
        ====================================================== --}}
        <div class="section-header">

            <h1>
                Edit Blog
            </h1>

            <div class="section-header-breadcrumb">

                <div class="breadcrumb-item active">

                    <a href="{{ route('backend.blogs.index') }}">
                        Blogs
                    </a>

                </div>

                <div class="breadcrumb-item">
                    Edit Blog
                </div>

            </div>

        </div>


        <div class="section-body">

            {{-- =====================================================
                SUCCESS MESSAGE
            ====================================================== --}}
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


            {{-- =====================================================
                ERROR MESSAGE
            ====================================================== --}}
            @if($errors->any())

                <div class="alert alert-danger">

                    <strong>
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        Whoops!
                    </strong>

                    <p class="mb-2">
                        Please fix the following errors:
                    </p>

                    <ul class="mb-0">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- =====================================================
                FORM
            ====================================================== --}}
            <form
                id="blog-form"
                action="{{ route('backend.blogs.update', $blog) }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf

                @method('PUT')


                <div class="row">

                    {{-- =================================================
                        LEFT COLUMN
                    ================================================== --}}
                    <div class="col-lg-8">


                        {{-- =================================================
                            BLOG INFORMATION
                        ================================================== --}}
                        <div class="card">

                            <div class="card-header">

                                <h4>

                                    <i class="fas fa-blog mr-2"></i>

                                    Blog Information

                                </h4>

                            </div>


                            <div class="card-body">


                                {{-- =================================================
                                    TITLE
                                ================================================== --}}
                                <div class="form-group">

                                    <label for="title">

                                        <strong>

                                            Blog Title

                                            <span class="text-danger">
                                                *
                                            </span>

                                        </strong>

                                    </label>


                                    <input
                                        type="text"
                                        id="title"
                                        name="title"
                                        value="{{ old('title', $blog->title) }}"
                                        class="form-control @error('title') is-invalid @enderror"
                                        placeholder="Enter blog title"
                                        required
                                    >


                                    @error('title')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>



                                {{-- =================================================
                                    SEO TITLE
                                ================================================== --}}
                                <div class="form-group">

                                    <label for="seo_title">

                                        <strong>
                                            SEO Title
                                        </strong>

                                        <span class="text-muted">
                                            (Google Search Title)
                                        </span>

                                    </label>


                                    <input
                                        type="text"
                                        id="seo_title"
                                        name="seo_title"
                                        value="{{ old('seo_title', $blog->seo_title ?? '') }}"
                                        maxlength="255"
                                        class="form-control @error('seo_title') is-invalid @enderror"
                                        placeholder="Google search result-এ যে title দেখাতে চান"
                                    >


                                    <div class="d-flex justify-content-between">

                                        <small class="form-text text-muted">
                                            Recommended: 50–60 characters
                                        </small>

                                        <small class="form-text text-muted">

                                            <strong id="seo-title-count">
                                                0
                                            </strong>

                                            characters

                                        </small>

                                    </div>


                                    @error('seo_title')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>



                                {{-- =================================================
                                    CATEGORY
                                ================================================== --}}
                                <div class="row">

                                    <div class="form-group col-md-6">

                                        <label for="category">

                                            <strong>

                                                Category

                                                <span class="text-danger">
                                                    *
                                                </span>

                                            </strong>

                                        </label>


                                        <input
                                            type="text"
                                            id="category"
                                            name="category"
                                            value="{{ old('category', $blog->category) }}"
                                            class="form-control @error('category') is-invalid @enderror"
                                            placeholder="যেমন: শিশু স্বাস্থ্য"
                                            required
                                        >


                                        @error('category')

                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>

                                        @enderror

                                    </div>



                                    <div class="form-group col-md-6">

                                        <label for="category_slug">

                                            <strong>

                                                Category Slug

                                                <span class="text-danger">
                                                    *
                                                </span>

                                            </strong>

                                        </label>


                                        <input
                                            type="text"
                                            id="category_slug"
                                            name="category_slug"
                                            value="{{ old('category_slug', $blog->category_slug) }}"
                                            class="form-control @error('category_slug') is-invalid @enderror"
                                            placeholder="child-health"
                                            required
                                        >


                                        @error('category_slug')

                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>

                                        @enderror

                                    </div>

                                </div>



                                {{-- =================================================
                                    FOCUS KEYWORD
                                ================================================== --}}
                                <div class="form-group">

                                    <label for="focus_keyword">

                                        <strong>
                                            Focus Keyword
                                        </strong>

                                    </label>


                                    <input
                                        type="text"
                                        id="focus_keyword"
                                        name="focus_keyword"
                                        value="{{ old('focus_keyword', $blog->focus_keyword ?? '') }}"
                                        maxlength="255"
                                        class="form-control @error('focus_keyword') is-invalid @enderror"
                                        placeholder="যেমন: শিশুর হার্নিয়া চিকিৎসা"
                                    >


                                    <small class="form-text text-muted">

                                        Google-এ যে keyword দিয়ে Blog rank করাতে চান।

                                    </small>


                                    @error('focus_keyword')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>



                                {{-- =================================================
                                    EXCERPT
                                ================================================== --}}
                                <div class="form-group">

                                    <label for="excerpt">

                                        <strong>
                                            Short Summary / Note
                                        </strong>

                                    </label>


                                    <textarea
                                        name="excerpt"
                                        id="excerpt"
                                        rows="4"
                                        maxlength="500"
                                        class="form-control @error('excerpt') is-invalid @enderror"
                                        placeholder="Blog সম্পর্কে সংক্ষিপ্ত Summary লিখুন..."
                                    >{{ old('excerpt', $blog->excerpt ?? '') }}</textarea>


                                    <small class="form-text text-muted">

                                        Blog List এবং Social Preview-এর জন্য ব্যবহার করা যাবে।

                                    </small>


                                    @error('excerpt')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>



                                {{-- =================================================
                                    META DESCRIPTION
                                ================================================== --}}
                                <div class="form-group">

                                    <label for="meta_description">

                                        <strong>
                                            Meta Description
                                        </strong>

                                    </label>


                                    <textarea
                                        name="meta_description"
                                        id="meta_description"
                                        rows="4"
                                        maxlength="500"
                                        class="form-control @error('meta_description') is-invalid @enderror"
                                        placeholder="Google Search Result-এ দেখানোর জন্য description লিখুন..."
                                    >{{ old('meta_description', $blog->meta_description ?? '') }}</textarea>


                                    <div class="d-flex justify-content-between">

                                        <small class="form-text text-muted">

                                            Recommended: 120–160 characters

                                        </small>


                                        <small class="form-text text-muted">

                                            <strong id="meta-description-count">
                                                0
                                            </strong>

                                            characters

                                        </small>

                                    </div>


                                    @error('meta_description')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>



                                {{-- =================================================
                                    CONTENT
                                ================================================== --}}
                                <div class="form-group">

                                    <label for="blog-content">

                                        <strong>

                                            Blog Content

                                            <span class="text-danger">
                                                *
                                            </span>

                                        </strong>

                                    </label>


                                    <textarea
                                        name="content"
                                        id="blog-content"
                                        rows="20"
                                        class="form-control @error('content') is-invalid @enderror"
                                        placeholder="এখানে সম্পূর্ণ Blog Article লিখুন..."
                                    >{{ old('content', $blog->content ?? '') }}</textarea>


                                    <small class="form-text text-muted">

                                        Heading, Paragraph, Bold, Italic, List, Link, Table ইত্যাদি ব্যবহার করতে পারবেন।

                                    </small>


                                    @error('content')

                                        <div class="text-danger small mt-2">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                            </div>

                        </div>



                        {{-- =================================================
                            SEO SETTINGS
                        ================================================== --}}
                        <div class="card">

                            <div class="card-header">

                                <h4>

                                    <i class="fas fa-search mr-2"></i>

                                    SEO Settings

                                </h4>

                            </div>


                            <div class="card-body">


                                {{-- =================================================
                                    GOOGLE PREVIEW
                                ================================================== --}}
                                <div class="seo-preview-box mb-4">

                                    <div class="small text-muted mb-2">

                                        Google Search Preview

                                    </div>


                                    <div
                                        id="google-preview-title"
                                        class="google-preview-title"
                                    >

                                        {{ old(
                                            'seo_title',
                                            $blog->seo_title ?? $blog->title
                                        ) ?: 'আপনার Blog Title এখানে দেখা যাবে' }}

                                    </div>


                                    <div
                                        id="google-preview-url"
                                        class="google-preview-url"
                                    >

                                        {{ url('/blog') }}/{{ $blog->slug ?? 'your-blog-slug' }}

                                    </div>


                                    <div
                                        id="google-preview-description"
                                        class="google-preview-description"
                                    >

                                        {{ old(
                                            'meta_description',
                                            $blog->meta_description ?? $blog->excerpt
                                        ) ?: 'আপনার Meta Description এখানে দেখা যাবে।' }}

                                    </div>

                                </div>



                                {{-- =================================================
                                    CANONICAL URL
                                ================================================== --}}
                                <div class="form-group">

                                    <label for="canonical_url">

                                        <strong>
                                            Canonical URL
                                        </strong>

                                    </label>


                                    <input
                                        type="url"
                                        id="canonical_url"
                                        name="canonical_url"
                                        value="{{ old('canonical_url', $blog->canonical_url ?? '') }}"
                                        maxlength="500"
                                        class="form-control @error('canonical_url') is-invalid @enderror"
                                        placeholder="https://example.com/blog/your-blog"
                                    >


                                    @error('canonical_url')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>



                                {{-- =================================================
                                    OG TITLE
                                ================================================== --}}
                                <div class="form-group">

                                    <label for="og_title">

                                        <strong>
                                            Social / OG Title
                                        </strong>

                                    </label>


                                    <input
                                        type="text"
                                        id="og_title"
                                        name="og_title"
                                        value="{{ old('og_title', $blog->og_title ?? '') }}"
                                        maxlength="255"
                                        class="form-control @error('og_title') is-invalid @enderror"
                                        placeholder="Facebook / LinkedIn share title"
                                    >


                                    @error('og_title')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>



                                {{-- =================================================
                                    OG DESCRIPTION
                                ================================================== --}}
                                <div class="form-group">

                                    <label for="og_description">

                                        <strong>
                                            Social / OG Description
                                        </strong>

                                    </label>


                                    <textarea
                                        name="og_description"
                                        id="og_description"
                                        rows="3"
                                        maxlength="500"
                                        class="form-control @error('og_description') is-invalid @enderror"
                                        placeholder="Facebook / LinkedIn share description"
                                    >{{ old('og_description', $blog->og_description ?? '') }}</textarea>


                                    @error('og_description')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>



                                {{-- =================================================
                                    SEO SCORE
                                ================================================== --}}
                                <input
                                    type="hidden"
                                    name="seo_score"
                                    id="seo_score"
                                    value="{{ old('seo_score', $blog->seo_score ?? 0) }}"
                                >


                                <div class="seo-score-box">

                                    <div class="d-flex justify-content-between align-items-center">

                                        <strong>
                                            SEO Score
                                        </strong>


                                        <span
                                            id="seo-score-number"
                                            class="badge badge-secondary"
                                        >
                                            0/100
                                        </span>

                                    </div>


                                    <div class="progress mt-2">

                                        <div
                                            id="seo-score-progress"
                                            class="progress-bar"
                                            role="progressbar"
                                            style="width:0%"
                                        >
                                            0%
                                        </div>

                                    </div>

                                </div>



                                {{-- =================================================
                                    SEO ANALYSIS
                                ================================================== --}}
                                <div class="mt-4">

                                    <h6 class="font-weight-bold">

                                        <i class="fas fa-chart-line mr-1"></i>

                                        SEO Analysis

                                    </h6>


                                    <ul
                                        id="seo-analysis-list"
                                        class="list-group"
                                    ></ul>

                                </div>

                            </div>

                        </div>



                        {{-- =================================================
                            TAGS
                        ================================================== --}}
                        <div class="card">

                            <div class="card-header">

                                <h4>

                                    <i class="fas fa-tags mr-2"></i>

                                    Blog Tags

                                </h4>

                            </div>


                            <div class="card-body">

                                @php

                                    $oldTags = old(
                                        'tags',
                                        $blog->tags ?? ['']
                                    );

                                    if (!is_array($oldTags) || empty($oldTags)) {
                                        $oldTags = [''];
                                    }

                                @endphp


                                <div id="tags-wrapper">

                                    @foreach($oldTags as $index => $tag)

                                        <div class="input-group mb-2 tag-row">

                                            <input
                                                type="text"
                                                name="tags[]"
                                                value="{{ $tag }}"
                                                class="form-control"
                                                placeholder="যেমন: শিশু স্বাস্থ্য"
                                            >


                                            <div class="input-group-append">

                                                @if($index === 0)

                                                    <button
                                                        type="button"
                                                        class="btn btn-primary add-tag"
                                                    >

                                                        <i class="fas fa-plus"></i>

                                                    </button>

                                                @else

                                                    <button
                                                        type="button"
                                                        class="btn btn-danger remove-tag"
                                                    >

                                                        <i class="fas fa-times"></i>

                                                    </button>

                                                @endif

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                    </div>



                    {{-- =================================================
                        RIGHT COLUMN
                    ================================================== --}}
                    <div class="col-lg-4">


                        {{-- =================================================
                            PUBLISH SETTINGS
                        ================================================== --}}
                        <div class="card">

                            <div class="card-header">

                                <h4>

                                    <i class="fas fa-cog mr-2"></i>

                                    Publish Settings

                                </h4>

                            </div>


                            <div class="card-body">


                                {{-- PUBLISHED DATE --}}
                                <div class="form-group">

                                    <label for="published_at">

                                        <strong>
                                            Published Date
                                        </strong>

                                    </label>


                                    <input
                                        type="date"
                                        id="published_at"
                                        name="published_at"
                                        value="{{ old(
                                            'published_at',
                                            optional($blog->published_at)->format('Y-m-d')
                                        ) }}"
                                        class="form-control @error('published_at') is-invalid @enderror"
                                    >


                                    @error('published_at')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>



                                {{-- READ TIME --}}
                                <div class="form-group">

                                    <label for="read_time">

                                        <strong>
                                            Read Time
                                        </strong>

                                    </label>


                                    <input
                                        type="text"
                                        id="read_time"
                                        name="read_time"
                                        value="{{ old('read_time', $blog->read_time ?? '') }}"
                                        class="form-control @error('read_time') is-invalid @enderror"
                                        placeholder="যেমন: ৫ মিনিট"
                                    >


                                    @error('read_time')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>



                                {{-- ICON --}}
                                <div class="form-group">

                                    <label for="icon">

                                        <strong>
                                            Bootstrap Icon
                                        </strong>

                                    </label>


                                    <input
                                        type="text"
                                        id="icon"
                                        name="icon"
                                        value="{{ old('icon', $blog->icon ?? 'bi-heart-pulse') }}"
                                        class="form-control"
                                        placeholder="bi-heart-pulse"
                                    >

                                </div>



                                {{-- PUBLISH SWITCH --}}
                                <div class="form-group mb-0">

                                    <div class="custom-control custom-switch">

                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            id="is_published"
                                            name="is_published"
                                            value="1"
                                            {{ old(
                                                'is_published',
                                                $blog->is_published
                                            ) ? 'checked' : '' }}
                                        >


                                        <label
                                            class="custom-control-label"
                                            for="is_published"
                                        >

                                            Publish করুন

                                        </label>

                                    </div>

                                </div>

                            </div>

                        </div>



                        {{-- =================================================
                            FEATURED IMAGE
                        ================================================== --}}
                        <div class="card">

                            <div class="card-header">

                                <h4>

                                    <i class="fas fa-image mr-2"></i>

                                    Featured Image

                                </h4>

                            </div>


                            <div class="card-body">


                                {{-- EXISTING IMAGE --}}
                                @if(!empty($blog->image))

                                    <div
                                        id="existing-image-wrapper"
                                        class="mb-3"
                                    >

                                        <strong>
                                            Current Image
                                        </strong>


                                        <img
                                            src="{{ asset($blog->image) }}"
                                            alt="{{ $blog->title }}"
                                            class="img-fluid rounded shadow-sm mt-2"
                                            style="width:100%;height:220px;object-fit:cover;"
                                        >

                                    </div>

                                @endif


                                {{-- NEW IMAGE --}}
                                <input
                                    type="file"
                                    name="image"
                                    id="featured-image"
                                    class="form-control-file"
                                    accept="image/jpeg,image/png,image/webp"
                                >


                                <small class="form-text text-muted">

                                    JPG, JPEG, PNG অথবা WEBP
                                    <br>
                                    Maximum: 2MB

                                </small>


                                @error('image')

                                    <div class="text-danger small mt-2">
                                        {{ $message }}
                                    </div>

                                @enderror


                                {{-- NEW IMAGE PREVIEW --}}
                                <div
                                    id="image-preview-wrapper"
                                    style="display:none;"
                                >

                                    <hr>

                                    <strong>
                                        New Image Preview
                                    </strong>


                                    <img
                                        id="image-preview"
                                        src=""
                                        alt="Image Preview"
                                        class="img-fluid rounded shadow-sm mt-2"
                                        style="width:100%;height:220px;object-fit:cover;"
                                    >

                                </div>

                            </div>

                        </div>



                        {{-- =================================================
                            SEO TIPS
                        ================================================== --}}
                        <div class="card">

                            <div class="card-header">

                                <h4>

                                    <i class="fas fa-lightbulb mr-2"></i>

                                    SEO Tips

                                </h4>

                            </div>


                            <div class="card-body">

                                <ul class="pl-3 mb-0">

                                    <li class="mb-2">
                                        Focus Keyword ব্যবহার করুন।
                                    </li>

                                    <li class="mb-2">
                                        SEO Title 50–60 characters রাখুন।
                                    </li>

                                    <li class="mb-2">
                                        Meta Description 120–160 characters রাখুন।
                                    </li>

                                    <li class="mb-2">
                                        প্রথম paragraph-এ keyword রাখুন।
                                    </li>

                                    <li class="mb-2">
                                        H2/H3 heading ব্যবহার করুন।
                                    </li>

                                    <li>
                                        Internal ও trusted External Link ব্যবহার করুন।
                                    </li>

                                </ul>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- =====================================================
                    BUTTON
                ====================================================== --}}
                <div class="card">

                    <div class="card-footer text-right">

                        <a
                            href="{{ route('backend.blogs.index') }}"
                            class="btn btn-secondary"
                        >

                            <i class="fas fa-arrow-left"></i>

                            Back

                        </a>


                        <button
                            type="submit"
                            id="save-blog-btn"
                            class="btn btn-primary"
                        >

                            <i class="fas fa-save"></i>

                            Update Blog

                        </button>

                    </div>

                </div>


            </form>

        </div>

    </section>

</div>

@endsection



{{-- ============================================================
    CSS
============================================================= --}}
@push('styles')

<style>

.seo-preview-box {

    border: 1px solid #e5e7eb;

    border-radius: 8px;

    padding: 18px;

    background: #fff;

}


.google-preview-title {

    color: #1a0dab;

    font-size: 20px;

    line-height: 1.4;

}


.google-preview-url {

    color: #188038;

    font-size: 13px;

    margin: 5px 0;

    word-break: break-all;

}


.google-preview-description {

    color: #4d5156;

    font-size: 14px;

    line-height: 1.5;

}


.seo-score-box {

    background: #f8f9fa;

    border-radius: 8px;

    padding: 15px;

}


.seo-score-box .progress {

    height: 12px;

}


.seo-check {

    font-size: 14px;

}


.ck-editor__editable {

    min-height: 450px;

}


#image-preview-wrapper img {

    max-width: 100%;

}


.tag-row .form-control {

    min-height: 38px;

}

</style>

@endpush



{{-- ============================================================
    JAVASCRIPT
============================================================= --}}
@push('scripts')

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    'use strict';


    /* =====================================================
       VARIABLES
    ====================================================== */

    const form =
        document.getElementById('blog-form');

    const textarea =
        document.getElementById('blog-content');

    const saveButton =
        document.getElementById('save-blog-btn');

    const titleInput =
        document.getElementById('title');

    const seoTitleInput =
        document.getElementById('seo_title');

    const keywordInput =
        document.getElementById('focus_keyword');

    const excerptInput =
        document.getElementById('excerpt');

    const metaInput =
        document.getElementById('meta_description');

    const canonicalInput =
        document.getElementById('canonical_url');

    const seoScoreInput =
        document.getElementById('seo_score');

    const seoScoreNumber =
        document.getElementById('seo-score-number');

    const seoProgress =
        document.getElementById('seo-score-progress');

    const analysisList =
        document.getElementById('seo-analysis-list');

    const previewTitle =
        document.getElementById('google-preview-title');

    const previewUrl =
        document.getElementById('google-preview-url');

    const previewDescription =
        document.getElementById(
            'google-preview-description'
        );

    const seoTitleCount =
        document.getElementById(
            'seo-title-count'
        );

    const metaCount =
        document.getElementById(
            'meta-description-count'
        );

    const tagsWrapper =
        document.getElementById(
            'tags-wrapper'
        );


    let editor = null;

    let submitting = false;



    /* =====================================================
       CKEDITOR
    ====================================================== */

    if (
        textarea &&
        typeof ClassicEditor !== 'undefined'
    ) {

        ClassicEditor
            .create(textarea, {

                toolbar: [

                    'heading',

                    '|',

                    'bold',
                    'italic',
                    'underline',
                    'strikethrough',

                    '|',

                    'link',
                    'bulletedList',
                    'numberedList',

                    '|',

                    'blockQuote',
                    'insertTable',

                    '|',

                    'undo',
                    'redo'

                ],

                heading: {

                    options: [

                        {
                            model: 'paragraph',
                            title: 'Paragraph',
                            class: 'ck-heading_paragraph'
                        },

                        {
                            model: 'heading2',
                            view: 'h2',
                            title: 'Heading 2',
                            class: 'ck-heading_heading2'
                        },

                        {
                            model: 'heading3',
                            view: 'h3',
                            title: 'Heading 3',
                            class: 'ck-heading_heading3'
                        },

                        {
                            model: 'heading4',
                            view: 'h4',
                            title: 'Heading 4',
                            class: 'ck-heading_heading4'
                        }

                    ]

                }

            })

            .then(function (instance) {

                editor = instance;


                editor.model.document.on(
                    'change:data',
                    runSeoAnalysis
                );


                runSeoAnalysis();

            })

            .catch(function (error) {

                console.error(
                    'CKEditor Error:',
                    error
                );

            });

    }



    /* =====================================================
       STRIP HTML
    ====================================================== */

    function stripHtml(html) {

        const div =
            document.createElement('div');

        div.innerHTML =
            html || '';

        return (

            div.textContent ||
            div.innerText ||
            ''

        )
        .replace(/\s+/g, ' ')
        .trim();

    }



    /* =====================================================
       WORD COUNT
    ====================================================== */

    function wordCount(text) {

        if (!text) {
            return 0;
        }

        return text
            .trim()
            .split(/\s+/)
            .filter(Boolean)
            .length;

    }



    /* =====================================================
       SLUGIFY
    ====================================================== */

    function slugify(text) {

        return text
            .toString()
            .trim()
            .toLowerCase()
            .replace(/[^\p{L}\p{N}\s-]/gu, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');

    }



    /* =====================================================
       SEO ANALYSIS
    ====================================================== */

    function runSeoAnalysis() {

        const title =
            titleInput?.value.trim() || '';

        const seoTitle =
            seoTitleInput?.value.trim() || '';

        const keyword =
            keywordInput?.value
                .trim()
                .toLowerCase() || '';

        const excerpt =
            excerptInput?.value.trim() || '';

        const meta =
            metaInput?.value.trim() || '';

        const canonical =
            canonicalInput?.value.trim() || '';


        const contentHtml =

            editor

                ? editor.getData()

                : (
                    textarea?.value || ''
                );


        const content =
            stripHtml(contentHtml);


        const lowerContent =
            content.toLowerCase();


        const currentTitle =
            seoTitle || title;


        let score = 0;

        const checks = [];



        /* =================================================
           1. FOCUS KEYWORD
        ================================================== */

        if (keyword) {

            score += 10;

            checks.push([
                true,
                'Focus Keyword সেট করা হয়েছে।'
            ]);

        } else {

            checks.push([
                false,
                'Focus Keyword যোগ করুন।'
            ]);

        }



        /* =================================================
           2. SEO TITLE LENGTH
        ================================================== */

        if (
            currentTitle.length >= 50 &&
            currentTitle.length <= 60
        ) {

            score += 10;

            checks.push([
                true,
                'SEO Title length ভালো।'
            ]);

        } else {

            checks.push([
                false,
                'SEO Title 50–60 characters রাখুন।'
            ]);

        }



        /* =================================================
           3. KEYWORD IN TITLE
        ================================================== */

        if (
            keyword &&
            currentTitle
                .toLowerCase()
                .includes(keyword)
        ) {

            score += 10;

            checks.push([
                true,
                'Focus Keyword SEO Title-এ আছে।'
            ]);

        } else {

            checks.push([
                false,
                'Focus Keyword SEO Title-এ রাখুন।'
            ]);

        }



        /* =================================================
           4. META DESCRIPTION LENGTH
        ================================================== */

        if (
            meta.length >= 120 &&
            meta.length <= 160
        ) {

            score += 10;

            checks.push([
                true,
                'Meta Description length ভালো।'
            ]);

        } else {

            checks.push([
                false,
                'Meta Description 120–160 characters রাখুন।'
            ]);

        }



        /* =================================================
           5. KEYWORD IN META
        ================================================== */

        if (
            keyword &&
            meta
                .toLowerCase()
                .includes(keyword)
        ) {

            score += 10;

            checks.push([
                true,
                'Focus Keyword Meta Description-এ আছে।'
            ]);

        } else {

            checks.push([
                false,
                'Focus Keyword Meta Description-এ রাখুন।'
            ]);

        }



        /* =================================================
           6. CONTENT LENGTH
        ================================================== */

        const words =
            wordCount(content);


        if (words >= 600) {

            score += 10;

            checks.push([
                true,
                `Content length ভালো (${words} words)।`
            ]);

        } else {

            checks.push([
                false,
                `Content আরও বিস্তারিত করুন (${words} words)।`
            ]);

        }



        /* =================================================
           7. KEYWORD IN CONTENT
        ================================================== */

        if (
            keyword &&
            lowerContent.includes(keyword)
        ) {

            score += 10;

            checks.push([
                true,
                'Focus Keyword content-এ আছে।'
            ]);

        } else {

            checks.push([
                false,
                'Focus Keyword content-এ ব্যবহার করুন।'
            ]);

        }



        /* =================================================
           8. KEYWORD IN FIRST 300 CHARACTERS
        ================================================== */

        if (
            keyword &&
            lowerContent
                .substring(0, 300)
                .includes(keyword)
        ) {

            score += 10;

            checks.push([
                true,
                'Focus Keyword প্রথম 300 characters-এর মধ্যে আছে।'
            ]);

        } else {

            checks.push([
                false,
                'প্রথম 300 characters-এর মধ্যে Focus Keyword রাখুন।'
            ]);

        }



        /* =================================================
           9. HEADINGS
        ================================================== */

        if (
            /<h2[\s>]|<h3[\s>]|<h4[\s>]/i
                .test(contentHtml)
        ) {

            score += 5;

            checks.push([
                true,
                'H2/H3/H4 heading ব্যবহার করা হয়েছে।'
            ]);

        } else {

            checks.push([
                false,
                'Article-এ H2/H3 heading ব্যবহার করুন।'
            ]);

        }



        /* =================================================
           10. LINKS
        ================================================== */

        const links =
            contentHtml.match(
                /<a\b[^>]*href=["'][^"']+["']/gi
            ) || [];


        let internal = false;

        let external = false;


        links.forEach(function (link) {

            const match =
                link.match(
                    /href=["']([^"']+)["']/i
                );


            if (!match) {
                return;
            }


            const href =
                match[1];


            if (
                href.startsWith('/') ||
                href.includes(
                    window.location.hostname
                )
            ) {

                internal = true;

            } else if (
                /^https?:\/\//i.test(href)
            ) {

                external = true;

            }

        });



        /* INTERNAL */

        if (internal) {

            score += 5;

            checks.push([
                true,
                'Internal link ব্যবহার করা হয়েছে।'
            ]);

        } else {

            checks.push([
                false,
                'প্রয়োজনে Internal Link দিন।'
            ]);

        }



        /* EXTERNAL */

        if (external) {

            score += 5;

            checks.push([
                true,
                'External link ব্যবহার করা হয়েছে।'
            ]);

        } else {

            checks.push([
                false,
                'প্রয়োজনে trusted External Link দিন।'
            ]);

        }



        /* =================================================
           FINAL SCORE
        ================================================== */

        score =
            Math.min(100, score);



        /* SAVE SCORE TO HIDDEN INPUT */

        if (seoScoreInput) {

            seoScoreInput.value =
                score;

        }



        /* SCORE NUMBER */

        if (seoScoreNumber) {

            seoScoreNumber.textContent =
                `${score}/100`;


            seoScoreNumber.className =
                'badge ' +

                (
                    score >= 80

                        ? 'badge-success'

                        : score >= 60

                            ? 'badge-warning'

                            : 'badge-danger'
                );

        }



        /* PROGRESS */

        if (seoProgress) {

            seoProgress.style.width =
                `${score}%`;

            seoProgress.textContent =
                `${score}%`;

        }



        /* =================================================
           SEO ANALYSIS LIST
        ================================================== */

        if (analysisList) {

            analysisList.innerHTML = '';


            checks.forEach(function (item) {

                const li =
                    document.createElement('li');


                li.className =
                    'list-group-item seo-check';


                li.innerHTML =

                    `<i class="fas ${
                        item[0]

                            ? 'fa-check-circle text-success'

                            : 'fa-exclamation-circle text-warning'

                    } mr-2"></i>${item[1]}`;


                analysisList.appendChild(li);

            });

        }



        /* =================================================
           GOOGLE PREVIEW TITLE
        ================================================== */

        if (previewTitle) {

            previewTitle.textContent =

                currentTitle ||

                'আপনার Blog Title এখানে দেখা যাবে';

        }



        /* =================================================
           GOOGLE PREVIEW DESCRIPTION
        ================================================== */

        if (previewDescription) {

            previewDescription.textContent =

                meta ||

                excerpt ||

                'আপনার Meta Description এখানে দেখা যাবে।';

        }



        /* =================================================
           GOOGLE PREVIEW URL
        ================================================== */

        if (previewUrl) {

            previewUrl.textContent =

                `{{ url('/blog') }}/${slugify(title) || @json($blog->slug ?? 'your-blog-slug')}`;

        }



        /* =================================================
           SEO TITLE COUNTER
        ================================================== */

        if (seoTitleCount) {

            seoTitleCount.textContent =
                currentTitle.length;

        }



        /* =================================================
           META DESCRIPTION COUNTER
        ================================================== */

        if (metaCount) {

            metaCount.textContent =
                meta.length;

        }

    }



    /* =====================================================
       INPUT EVENTS
    ====================================================== */

    [

        titleInput,

        seoTitleInput,

        keywordInput,

        excerptInput,

        metaInput,

        canonicalInput

    ].forEach(function (input) {

        if (input) {

            input.addEventListener(
                'input',
                runSeoAnalysis
            );

        }

    });



    /* =====================================================
       TAG SYSTEM
    ====================================================== */

    if (tagsWrapper) {

        tagsWrapper.addEventListener(
            'click',
            function (event) {


                /* ADD TAG */

                const addButton =
                    event.target.closest(
                        '.add-tag'
                    );


                /* REMOVE TAG */

                const removeButton =
                    event.target.closest(
                        '.remove-tag'
                    );



                if (addButton) {

                    const row =
                        document.createElement('div');


                    row.className =
                        'input-group mb-2 tag-row';


                    row.innerHTML = `

                        <input
                            type="text"
                            name="tags[]"
                            class="form-control"
                            placeholder="যেমন: শিশু স্বাস্থ্য"
                        >

                        <div class="input-group-append">

                            <button
                                type="button"
                                class="btn btn-danger remove-tag"
                            >

                                <i class="fas fa-times"></i>

                            </button>

                        </div>

                    `;


                    tagsWrapper.appendChild(row);

                }



                if (removeButton) {

                    const row =
                        removeButton.closest(
                            '.tag-row'
                        );


                    if (row) {

                        row.remove();

                    }

                }

            }
        );

    }



    /* =====================================================
       IMAGE PREVIEW
    ====================================================== */

    const imageInput =
        document.getElementById(
            'featured-image'
        );

    const previewWrapper =
        document.getElementById(
            'image-preview-wrapper'
        );

    const imagePreview =
        document.getElementById(
            'image-preview'
        );



    if (imageInput) {

        imageInput.addEventListener(
            'change',
            function () {


                const file =
                    this.files[0];


                if (!file) {

                    previewWrapper.style.display =
                        'none';

                    imagePreview.src = '';

                    return;

                }



                /* ALLOWED TYPES */

                const allowed = [

                    'image/jpeg',
                    'image/png',
                    'image/webp'

                ];



                if (
                    !allowed.includes(
                        file.type
                    )
                ) {

                    alert(
                        'শুধুমাত্র JPG, JPEG, PNG অথবা WEBP image ব্যবহার করুন।'
                    );


                    this.value = '';


                    previewWrapper.style.display =
                        'none';


                    return;

                }



                /* MAX 2MB */

                if (
                    file.size >
                    2 * 1024 * 1024
                ) {

                    alert(
                        'Image size সর্বোচ্চ 2MB হতে পারবে।'
                    );


                    this.value = '';


                    previewWrapper.style.display =
                        'none';


                    return;

                }



                /* PREVIEW */

                const reader =
                    new FileReader();


                reader.onload =
                    function (e) {

                        imagePreview.src =
                            e.target.result;


                        previewWrapper.style.display =
                            'block';

                    };


                reader.readAsDataURL(file);

            }
        );

    }



    /* =====================================================
       FORM SUBMIT
    ====================================================== */

    if (form) {

        form.addEventListener(
            'submit',
            function (event) {


                /* PREVENT DOUBLE SUBMIT */

                if (submitting) {

                    event.preventDefault();

                    return;

                }



                let content = '';



                /* GET CKEDITOR DATA */

                if (editor) {

                    content =
                        editor.getData().trim();


                    textarea.value =
                        content;

                } else {

                    content =
                        textarea.value.trim();

                }



                /* CONTENT REQUIRED */

                if (!content) {

                    event.preventDefault();


                    alert(
                        'অনুগ্রহ করে Blog Content লিখুন।'
                    );


                    return;

                }



                /* FINAL SEO CALCULATION */

                runSeoAnalysis();



                submitting = true;



                /* DISABLE BUTTON */

                if (saveButton) {

                    saveButton.disabled =
                        true;


                    saveButton.innerHTML =
                        '<i class="fas fa-spinner fa-spin"></i> Updating...';

                }

            }
        );

    }



    /* =====================================================
       INITIAL SEO ANALYSIS
    ====================================================== */

    runSeoAnalysis();

});

</script>

@endpush