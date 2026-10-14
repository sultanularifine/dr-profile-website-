@extends('backend.layouts.app')

@section('title', 'Create New Blog')

@section('main')

<div class="main-content">

    <section class="section">

        <div class="section-header">

            <h1>Create New Blog</h1>

            <div class="section-header-breadcrumb">

                <div class="breadcrumb-item active">
                    <a href="{{ route('backend.blogs.index') }}">
                        Blogs
                    </a>
                </div>

                <div class="breadcrumb-item">
                    Create Blog
                </div>

            </div>

        </div>


        <div class="section-body">

            {{-- SUCCESS --}}
            @if(session('success'))

                <div class="alert alert-success alert-dismissible fade show">

                    <i class="fas fa-check-circle"></i>

                    {{ session('success') }}

                    <button type="button"
                            class="close"
                            data-dismiss="alert">

                        <span>&times;</span>

                    </button>

                </div>

            @endif


            {{-- ERRORS --}}
            @if($errors->any())

                <div class="alert alert-danger">

                    <strong>
                        <i class="fas fa-exclamation-triangle"></i>
                        Whoops!
                    </strong>

                    <p class="mb-2">
                        Please fix the following errors:
                    </p>

                    <ul class="mb-0">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <form
                id="blog-form"
                action="{{ route('backend.blogs.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf


                <div class="row">

                    {{-- =====================================================
                        LEFT
                    ====================================================== --}}
                    <div class="col-lg-8">

                        {{-- BLOG INFORMATION --}}
                        <div class="card">

                            <div class="card-header">

                                <h4>
                                    <i class="fas fa-blog mr-2"></i>
                                    Blog Information
                                </h4>

                            </div>


                            <div class="card-body">

                                {{-- TITLE --}}
                                <div class="form-group">

                                    <label for="title">
                                        <strong>
                                            Blog Title
                                            <span class="text-danger">*</span>
                                        </strong>
                                    </label>

                                    <input
                                        type="text"
                                        id="title"
                                        name="title"
                                        value="{{ old('title') }}"
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


                                {{-- SEO TITLE --}}
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
                                        value="{{ old('seo_title') }}"
                                        maxlength="255"
                                        class="form-control @error('seo_title') is-invalid @enderror"
                                        placeholder="Google search result-এ যে title দেখাতে চান"
                                    >

                                    <div class="d-flex justify-content-between">

                                        <small class="form-text text-muted">
                                            Recommended: 50–60 characters
                                        </small>

                                        <small class="form-text text-muted">
                                            <strong id="seo-title-count">0</strong>
                                            characters
                                        </small>

                                    </div>

                                    @error('seo_title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>


                                {{-- CATEGORY --}}
                                <div class="row">

                                    <div class="form-group col-md-6">

                                        <label for="category">

                                            <strong>
                                                Category
                                                <span class="text-danger">*</span>
                                            </strong>

                                        </label>

                                        <input
                                            type="text"
                                            id="category"
                                            name="category"
                                            value="{{ old('category') }}"
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
                                                <span class="text-danger">*</span>
                                            </strong>

                                        </label>

                                        <input
                                            type="text"
                                            id="category_slug"
                                            name="category_slug"
                                            value="{{ old('category_slug') }}"
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


                                {{-- FOCUS KEYWORD --}}
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
                                        value="{{ old('focus_keyword') }}"
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


                                {{-- EXCERPT --}}
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
                                    >{{ old('excerpt') }}</textarea>

                                    <small class="form-text text-muted">
                                        Blog List এবং Social Preview-এর জন্য ব্যবহার করা যাবে।
                                    </small>

                                    @error('excerpt')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>


                                {{-- META DESCRIPTION --}}
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
                                    >{{ old('meta_description') }}</textarea>

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


                                {{-- CONTENT --}}
                                <div class="form-group">

                                    <label for="blog-content">

                                        <strong>
                                            Blog Content
                                            <span class="text-danger">*</span>
                                        </strong>

                                    </label>

                                    <textarea
                                        name="content"
                                        id="blog-content"
                                        rows="20"
                                        class="form-control @error('content') is-invalid @enderror"
                                        placeholder="এখানে সম্পূর্ণ Blog Article লিখুন..."
                                    >{{ old('content') }}</textarea>

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


                        {{-- SEO SETTINGS --}}
                        <div class="card">

                            <div class="card-header">

                                <h4>
                                    <i class="fas fa-search mr-2"></i>
                                    SEO Settings
                                </h4>

                            </div>


                            <div class="card-body">

                                {{-- GOOGLE PREVIEW --}}
                                <div class="seo-preview-box mb-4">

                                    <div class="small text-muted mb-2">
                                        Google Search Preview
                                    </div>

                                    <div
                                        id="google-preview-title"
                                        class="google-preview-title"
                                    >
                                        আপনার Blog Title এখানে দেখা যাবে
                                    </div>

                                    <div
                                        id="google-preview-url"
                                        class="google-preview-url"
                                    >
                                        {{ url('/blog') }}/your-blog-slug
                                    </div>

                                    <div
                                        id="google-preview-description"
                                        class="google-preview-description"
                                    >
                                        আপনার Meta Description এখানে দেখা যাবে।
                                    </div>

                                </div>


                                {{-- CANONICAL --}}
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
                                        value="{{ old('canonical_url') }}"
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


                                {{-- OG TITLE --}}
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
                                        value="{{ old('og_title') }}"
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


                                {{-- OG DESCRIPTION --}}
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
                                    >{{ old('og_description') }}</textarea>

                                    @error('og_description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>


                                {{-- SEO SCORE --}}
                                <input
                                    type="hidden"
                                    name="seo_score"
                                    id="seo_score"
                                    value="{{ old('seo_score', 0) }}"
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


                                {{-- ANALYSIS --}}
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


                        {{-- TAGS --}}
                        <div class="card">

                            <div class="card-header">

                                <h4>
                                    <i class="fas fa-tags mr-2"></i>
                                    Blog Tags
                                </h4>

                            </div>

                            <div class="card-body">

                                @php

                                    $oldTags = old('tags', ['']);

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


                    {{-- =====================================================
                        RIGHT
                    ====================================================== --}}
                    <div class="col-lg-4">

                        {{-- PUBLISH --}}
                        <div class="card">

                            <div class="card-header">

                                <h4>
                                    <i class="fas fa-cog mr-2"></i>
                                    Publish Settings
                                </h4>

                            </div>

                            <div class="card-body">

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
                                        value="{{ old('published_at', now()->format('Y-m-d')) }}"
                                        class="form-control @error('published_at') is-invalid @enderror"
                                    >

                                    @error('published_at')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>


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
                                        value="{{ old('read_time') }}"
                                        class="form-control @error('read_time') is-invalid @enderror"
                                        placeholder="যেমন: ৫ মিনিট"
                                    >

                                    @error('read_time')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>


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
                                        value="{{ old('icon', 'bi-heart-pulse') }}"
                                        class="form-control"
                                        placeholder="bi-heart-pulse"
                                    >

                                </div>


                                <div class="form-group mb-0">

                                    <div class="custom-control custom-switch">

                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            id="is_published"
                                            name="is_published"
                                            value="1"
                                            {{ old('is_published', 1) ? 'checked' : '' }}
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


                        {{-- IMAGE --}}
                        <div class="card">

                            <div class="card-header">

                                <h4>
                                    <i class="fas fa-image mr-2"></i>
                                    Featured Image
                                </h4>

                            </div>

                            <div class="card-body">

                                <button type="button" class="btn btn-outline-primary btn-block mb-3" data-toggle="modal" data-target="#blogFeatureMakerModal" id="open-feature-image-maker" title="নিজের ছবি ও ব্লগের শিরোনাম দিয়ে 1200×630 feature image বানান; তৈরি হলে ফর্মে যুক্ত হবে।">
                                    <i class="fas fa-magic mr-1"></i> Feature Image Maker খুলুন
                                </button>
                                <div class="small text-muted mb-3">এই টুল দিয়ে বানানো ছবি স্বয়ংক্রিয়ভাবে নিচের Featured Image upload field-এ বসবে। এরপর ব্লগ Save করুন।</div>

                                <input
                                    type="file"
                                    name="image"
                                    id="featured-image"
                                    class="form-control-file"
                                    accept="image/jpeg,image/png,image/webp"
                                >

                                <small class="form-text text-muted">
                                    JPG, JPEG, PNG অথবা WEBP<br>
                                    Maximum: 2MB
                                </small>

                                <div class="form-group mt-3">
                                    <label for="image_alt">Featured image alt text</label>
                                    <input type="text" id="image_alt" name="image_alt" class="form-control @error('image_alt') is-invalid @enderror" maxlength="255" value="{{ old('image_alt') }}" placeholder="Describe the image briefly">
                                    <small class="form-text text-muted">Used by screen readers and search engines. If left blank, the blog title is used.</small>
                                    @error('image_alt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                @error('image')
                                    <div class="text-danger small mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror


                                <div
                                    id="image-preview-wrapper"
                                    style="display:none;"
                                >

                                    <hr>

                                    <strong>
                                        Image Preview
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


                        {{-- SEO TIPS --}}
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


                {{-- BUTTON --}}
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
                            Save Blog
                        </button>

                    </div>

                </div>

            </form>


            <div class="modal fade" id="blogFeatureMakerModal" tabindex="-1" role="dialog" aria-labelledby="blogFeatureMakerModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered blog-feature-maker-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div><h5 class="modal-title" id="blogFeatureMakerModalLabel"><i class="fas fa-magic text-primary mr-2"></i>Blog Feature Image Maker</h5><small class="text-muted">ছবি তৈরি করে “এই ছবিটি ব্লগে ব্যবহার করুন” চাপুন</small></div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="বন্ধ করুন"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body p-0"><div id="blog-feature-maker-loading" class="p-4 text-center" role="status">Feature Image Maker লোড হচ্ছে…</div><iframe id="blog-feature-maker-frame" title="Blog Feature Image Maker" src="{{ asset('admin/feature-image-maker.html') }}"></iframe></div>
                        <div class="modal-footer"><span class="small text-muted mr-auto" id="blog-feature-maker-status" role="status">ছবি তৈরি হলে Blog Form-এর Featured Image-এ সেট হবে।</span><a class="btn btn-outline-primary" id="blog-feature-maker-new-tab" href="{{ asset('admin/feature-image-maker.html') }}" target="_blank" rel="noopener">নতুন ট্যাবে খুলুন</a><button type="button" class="btn btn-secondary" data-dismiss="modal">বন্ধ করুন</button></div>
                    </div>
                </div>
            </div>

        </div>

    </section>

</div>

@endsection


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

</style>

@endpush


@push('scripts')

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    'use strict';

    const form = document.getElementById('blog-form');
    const textarea = document.getElementById('blog-content');
    const saveButton = document.getElementById('save-blog-btn');

    const titleInput = document.getElementById('title');
    const seoTitleInput = document.getElementById('seo_title');
    const keywordInput = document.getElementById('focus_keyword');
    const excerptInput = document.getElementById('excerpt');
    const metaInput = document.getElementById('meta_description');
    const canonicalInput = document.getElementById('canonical_url');

    const seoScoreInput = document.getElementById('seo_score');
    const seoScoreNumber = document.getElementById('seo-score-number');
    const seoProgress = document.getElementById('seo-score-progress');
    const analysisList = document.getElementById('seo-analysis-list');

    const previewTitle = document.getElementById('google-preview-title');
    const previewUrl = document.getElementById('google-preview-url');
    const previewDescription = document.getElementById('google-preview-description');

    const seoTitleCount = document.getElementById('seo-title-count');
    const metaCount = document.getElementById('meta-description-count');

    const tagsWrapper = document.getElementById('tags-wrapper');

    let editor = null;
    let submitting = false;


    /* =====================================================
       CKEDITOR
    ====================================================== */

    if (textarea && typeof ClassicEditor !== 'undefined') {

        ClassicEditor.create(textarea, {

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

            console.error('CKEditor Error:', error);

        });

    }


    /* =====================================================
       HELPERS
    ====================================================== */

    function stripHtml(html) {

        const div = document.createElement('div');

        div.innerHTML = html || '';

        return (
            div.textContent ||
            div.innerText ||
            ''
        )
        .replace(/\s+/g, ' ')
        .trim();

    }


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
            keywordInput?.value.trim().toLowerCase() || '';

        const excerpt =
            excerptInput?.value.trim() || '';

        const meta =
            metaInput?.value.trim() || '';

        const canonical =
            canonicalInput?.value.trim() || '';

        const contentHtml =
            editor
                ? editor.getData()
                : (textarea?.value || '');

        const content =
            stripHtml(contentHtml);

        const lowerContent =
            content.toLowerCase();

        const currentTitle =
            seoTitle || title;

        let score = 0;

        const checks = [];


        /* 1 KEYWORD */

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


        /* 2 SEO TITLE */

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


        /* 3 KEYWORD TITLE */

        if (
            keyword &&
            currentTitle.toLowerCase().includes(keyword)
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


        /* 4 META */

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


        /* 5 KEYWORD META */

        if (
            keyword &&
            meta.toLowerCase().includes(keyword)
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


        /* 6 CONTENT */

        const words = wordCount(content);

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


        /* 7 KEYWORD CONTENT */

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


        /* 8 FIRST 300 */

        if (
            keyword &&
            lowerContent.substring(0, 300).includes(keyword)
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


        /* 9 HEADINGS */

        if (/<h2[\s>]|<h3[\s>]|<h4[\s>]/i.test(contentHtml)) {

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


        /* 10 LINKS */

        const links =
            contentHtml.match(/<a\b[^>]*href=["'][^"']+["']/gi) || [];

        let internal = false;
        let external = false;

        links.forEach(function (link) {

            const match =
                link.match(/href=["']([^"']+)["']/i);

            if (!match) {
                return;
            }

            const href = match[1];

            if (
                href.startsWith('/') ||
                href.includes(window.location.hostname)
            ) {

                internal = true;

            } else if (
                /^https?:\/\//i.test(href)
            ) {

                external = true;

            }

        });


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


        /* SCORE */

        score = Math.min(100, score);


        if (seoScoreInput) {
            seoScoreInput.value = score;
        }


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


        if (seoProgress) {

            seoProgress.style.width =
                `${score}%`;

            seoProgress.textContent =
                `${score}%`;

        }


        /* ANALYSIS */

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


        /* GOOGLE PREVIEW */

        if (previewTitle) {

            previewTitle.textContent =
                currentTitle ||
                'আপনার Blog Title এখানে দেখা যাবে';

        }


        if (previewDescription) {

            previewDescription.textContent =
                meta ||
                excerpt ||
                'আপনার Meta Description এখানে দেখা যাবে।';

        }


        if (previewUrl) {

            previewUrl.textContent =
                `{{ url('/blog') }}/${slugify(title) || 'your-blog-slug'}`;

        }


        if (seoTitleCount) {

            seoTitleCount.textContent =
                currentTitle.length;

        }


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

                const addButton =
                    event.target.closest('.add-tag');

                const removeButton =
                    event.target.closest('.remove-tag');


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
                        removeButton.closest('.tag-row');

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
        document.getElementById('featured-image');

    const previewWrapper =
        document.getElementById('image-preview-wrapper');

    const imagePreview =
        document.getElementById('image-preview');


    if (imageInput) {

        imageInput.addEventListener(
            'change',
            function () {

                const file =
                    this.files[0];

                if (!file) {

                    previewWrapper.style.display = 'none';

                    imagePreview.src = '';

                    return;

                }


                const allowed =
                    [
                        'image/jpeg',
                        'image/png',
                        'image/webp'
                    ];


                if (!allowed.includes(file.type)) {

                    alert(
                        'শুধুমাত্র JPG, JPEG, PNG অথবা WEBP image ব্যবহার করুন।'
                    );

                    this.value = '';

                    previewWrapper.style.display = 'none';

                    return;

                }


                if (file.size > 2 * 1024 * 1024) {

                    alert(
                        'Image size সর্বোচ্চ 2MB হতে পারবে।'
                    );

                    this.value = '';

                    previewWrapper.style.display = 'none';

                    return;

                }


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

                if (submitting) {

                    event.preventDefault();

                    return;

                }


                let content = '';


                if (editor) {

                    content =
                        editor.getData().trim();

                    textarea.value =
                        content;

                } else {

                    content =
                        textarea.value.trim();

                }


                if (!content) {

                    event.preventDefault();

                    alert(
                        'অনুগ্রহ করে Blog Content লিখুন।'
                    );

                    return;

                }


                runSeoAnalysis();


                submitting = true;


                if (saveButton) {

                    saveButton.disabled = true;

                    saveButton.innerHTML =
                        '<i class="fas fa-spinner fa-spin"></i> Saving...';

                }

            }
        );

    }


    runSeoAnalysis();

});

</script>

@endpush

@push('styles')
<style>
/* Keep the feature maker above the entire admin shell/sidebar. The modal is moved directly under body by the bridge below. */
body.feature-maker-modal-open > .modal-backdrop{z-index:200000!important}
body.feature-maker-modal-open > #blogFeatureMakerModal{position:fixed!important;inset:0!important;z-index:200010!important;width:100vw!important;max-width:none!important;height:100vh;height:100dvh;max-height:none!important;margin:0!important;padding:0!important;overflow-x:hidden!important;overflow-y:auto!important}
#blogFeatureMakerModal .blog-feature-maker-dialog{width:min(calc(100vw - 32px),1180px);max-width:1180px;margin:1rem auto}
#blogFeatureMakerModal .modal-content{display:flex;flex-direction:column;height:min(92vh,900px);height:min(92dvh,900px);min-height:260px;max-height:none;border:0;border-radius:16px;overflow:hidden;box-shadow:0 20px 80px rgba(0,0,0,.25)}
#blogFeatureMakerModal .modal-header,#blogFeatureMakerModal .modal-footer{flex:0 0 auto;padding:12px 16px;align-items:center}
#blogFeatureMakerModal .modal-title{font-size:16px;font-weight:800}
#blogFeatureMakerModal .modal-header small{font-size:11px}
#blogFeatureMakerModal .modal-body{position:relative;min-height:0;flex:1 1 auto;overflow:hidden;padding:0!important}
#blogFeatureMakerModal iframe{position:absolute;inset:0;display:block;width:100%;height:100%;min-height:0;border:0;background:#f3f8fb}
#blogFeatureMakerModal #blog-feature-maker-loading{position:absolute;z-index:1;inset:0 auto auto 0;width:100%;pointer-events:none;background:rgba(243,248,251,.94);color:#0b2a3d;font-weight:700}
#blogFeatureMakerModal .modal-footer{gap:8px;flex-wrap:wrap}
#blogFeatureMakerModal #blog-feature-maker-status{overflow-wrap:anywhere;flex:1 1 240px}
#blogFeatureMakerModal #blog-feature-maker-new-tab{white-space:nowrap}
@media(max-width:575px){
 body.feature-maker-modal-open > #blogFeatureMakerModal{padding:0!important}
 #blogFeatureMakerModal .blog-feature-maker-dialog{width:100vw;max-width:none;height:100%;margin:0}
 #blogFeatureMakerModal .modal-content{height:100vh;height:100dvh;min-height:0;border-radius:0}
 #blogFeatureMakerModal .modal-header{padding:10px 12px}
 #blogFeatureMakerModal .modal-footer{align-items:stretch;flex-direction:column}
 #blogFeatureMakerModal .modal-footer .btn,#blogFeatureMakerModal #blog-feature-maker-new-tab{width:100%;text-align:center}
 #blogFeatureMakerModal #blog-feature-maker-status{flex-basis:auto}
}
</style>
@endpush

@push('scripts')
<script>
(function () {
    function initBlogFeatureMakerBridge() {
        var modal = document.getElementById('blogFeatureMakerModal');
        var frame = document.getElementById('blog-feature-maker-frame');
        var titleInput = document.getElementById('title');
        var fileInput = document.getElementById('featured-image');
        var preview = document.getElementById('image-preview');
        var previewWrapper = document.getElementById('image-preview-wrapper');
        var status = document.getElementById('blog-feature-maker-status');
        var loading = document.getElementById('blog-feature-maker-loading');
        var altInput = document.getElementById('image_alt');
        if (!modal || !frame || !fileInput) return;

        // Important: this view lives inside .main-content (which is shifted right by the admin sidebar
        // and may create a containing block). Move the modal to body so position:fixed covers the viewport,
        // instead of starting beside/behind the sidebar.
        if (modal.parentElement !== document.body) {
            document.body.appendChild(modal);
        }

        var frameReady = false;
        function sendTitle() {
            if (!frameReady || !frame.contentWindow) return;
            try {
                frame.contentWindow.postMessage({
                    type: 'blog-feature-image-maker:set-title',
                    title: titleInput ? titleInput.value : ''
                }, window.location.origin);
            } catch (error) {
                if (status) status.textContent = 'ব্লগের শিরোনাম পাঠানো যায়নি। নতুন ট্যাবে খুলে চেষ্টা করুন।';
            }
        }

        function checkFrameReady() {
            // The iframe may finish loading before this code registers its load listener.
            // Checking immediately prevents the loader overlay from hiding a ready generator.
            try {
                frameReady = !!(frame.contentDocument && frame.contentDocument.getElementById('cv'));
            } catch (error) {
                frameReady = false;
            }
            if (frameReady) {
                if (loading) loading.style.display = 'none';
                if (status) status.textContent = 'টুল প্রস্তুত। ছবি তৈরি করে “এই ছবিটি ব্লগে ব্যবহার করুন” চাপুন।';
                sendTitle();
                return true;
            }
            return false;
        }
        frame.addEventListener('load', function () {
            if (checkFrameReady()) return;
            if (loading) loading.style.display = 'none';
            if (status) status.textContent = 'Feature Image Maker ফাইলটি লোড হয়নি। নতুন ট্যাবে খুলুন অথবা public/admin/feature-image-maker.html ফাইলটি আছে কি না দেখুন।';
        });
        // Detect already-loaded iframe and show a useful fallback rather than leaving a stuck loader.
        if (!checkFrameReady()) {
            window.setTimeout(function () {
                if (checkFrameReady()) return;
                if (loading) loading.style.display = 'none';
                if (status) status.textContent = 'Feature Image Maker এখনও লোড হয়নি। নতুন ট্যাবে খুলুন বা public/admin/feature-image-maker.html ফাইলটি চেক করুন।';
            }, 3000);
        }

        if (window.jQuery) {
            window.jQuery(modal).on('show.bs.modal', function () {
                // Raise both modal and its Bootstrap backdrop above sidebar/topbar z-indexes.
                document.body.classList.add('feature-maker-modal-open');
                if (loading) loading.style.display = frameReady ? 'none' : 'block';
                if (status && !frameReady) status.textContent = 'Feature Image Maker লোড হচ্ছে…';
            });
            window.jQuery(modal).on('shown.bs.modal', sendTitle);
            window.jQuery(modal).on('hidden.bs.modal', function () {
                document.body.classList.remove('feature-maker-modal-open');
            });
        }

        window.addEventListener('message', function (event) {
            if (event.origin !== window.location.origin || !event.data || event.data.type !== 'blog-feature-image-maker:result') return;
            if (typeof event.data.dataUrl !== 'string' || !/^data:image\/(webp|png|jpeg);base64,/i.test(event.data.dataUrl)) {
                if (status) status.textContent = 'ইমেজ format যাচাই করা যায়নি। আবার তৈরি করুন।';
                return;
            }
            if (status) status.textContent = 'ছবি Blog Form-এ যুক্ত হচ্ছে…';
            // Decode directly instead of fetch(data:), which behaves inconsistently in some browsers.
            try {
                var parts = event.data.dataUrl.split(',');
                var mimeMatch = parts[0].match(/^data:(.*?);base64$/i);
                if (!mimeMatch) throw new Error('Image data is invalid');
                var binary = atob(parts[1]);
                var bytes = new Uint8Array(binary.length);
                for (var i = 0; i < binary.length; i++) bytes[i] = binary.charCodeAt(i);
                var blob = new Blob([bytes], { type: mimeMatch[1].toLowerCase() });
                if (!['image/webp', 'image/png', 'image/jpeg'].includes(blob.type)) throw new Error('Unsupported image format');
                if (blob.size > 2 * 1024 * 1024) throw new Error('ইমেজ 2MB-এর বেশি। আবার তৈরি করুন।');
                if (typeof DataTransfer === 'undefined' || typeof File === 'undefined') throw new Error('এই ব্রাউজারে সরাসরি upload field-এ ছবি বসানো যায় না। ছবিটি ডাউনলোড করে Featured Image upload করুন।');
                var extension = blob.type === 'image/webp' ? 'webp' : (blob.type === 'image/png' ? 'png' : 'jpg');
                var file = new File([blob], 'blog-feature-image.' + extension, { type: blob.type, lastModified: Date.now() });
                var transfer = new DataTransfer();
                transfer.items.add(file);
                fileInput.files = transfer.files;
                if (preview) preview.src = URL.createObjectURL(blob);
                if (previewWrapper) previewWrapper.style.display = 'block';
                if (altInput && !altInput.value.trim() && titleInput) altInput.value = titleInput.value.trim();
                if (status) status.textContent = 'ছবি সফলভাবে Blog Form-এ যুক্ত হয়েছে। Modal বন্ধ করে Preview দেখে তারপর Save Blog চাপুন।';
                if (window.jQuery) window.jQuery(modal).modal('hide');
            } catch (error) {
                if (status) status.textContent = error && error.message ? error.message : 'ছবি ফর্মে যুক্ত করা যায়নি। নতুন ট্যাবে খুলুন বা manual upload করুন।';
            }
        });
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initBlogFeatureMakerBridge, { once: true });
    } else {
        initBlogFeatureMakerBridge();
    }
})();
</script>
@endpush
