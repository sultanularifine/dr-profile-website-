@extends('backend.layouts.app')

@section('title', 'Blogs Management')


{{-- =========================================================
    DATATABLE CSS
========================================================= --}}
@push('style')

    <link
        rel="stylesheet"
        href="{{ asset('backend/library/datatables/media/css/jquery.dataTables.min.css') }}"
    >

@endpush



@section('main')

<div class="main-content">

    <section class="section">


        {{-- =====================================================
            HEADER
        ====================================================== --}}
        <div class="section-header">

            <h1>
                Blogs Management
            </h1>


            <div class="section-header-breadcrumb">

                <div class="breadcrumb-item active">

                    <a href="{{ route('dashboard') }}">
                        Dashboard
                    </a>

                </div>


                <div class="breadcrumb-item">
                    Blogs
                </div>


                <div class="breadcrumb-item">
                    Blogs List
                </div>

            </div>

        </div>



        <div class="section-body">


            {{-- =====================================================
                SUCCESS MESSAGE
            ====================================================== --}}
            @if ($message = Session::get('success'))

                <div class="alert alert-success">

                    <p class="mb-0">
                        {{ $message }}
                    </p>

                </div>

            @endif



            {{-- =====================================================
                ERROR MESSAGE
            ====================================================== --}}
            @if ($message = Session::get('error'))

                <div class="alert alert-danger">

                    <p class="mb-0">
                        {{ $message }}
                    </p>

                </div>

            @endif



            {{-- =====================================================
                VALIDATION ERROR
            ====================================================== --}}
            @if ($errors->any())

                <div class="alert alert-danger">

                    <strong>
                        Please fix the following errors:
                    </strong>

                    <ul class="mb-0 mt-2">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif



            <div class="row">

                <div class="col-12">

                    <div class="card">


                        {{-- =================================================
                            CARD HEADER
                        ================================================== --}}
                        <div class="card-header">

                            <div class="card-left text-left my-1">

                                @can('blog-create')

                                    <a
                                        href="{{ route('backend.blogs.create') }}"
                                        class="btn btn-primary"
                                    >

                                        <i class="fas fa-plus mr-1"></i>

                                        Create New Blog

                                    </a>

                                @endcan

                            </div>

                        </div>



                        {{-- =================================================
                            CARD BODY
                        ================================================== --}}
                        <div class="card-body">


                            <div class="table-responsive">

                                <table
                                    class="table-striped table"
                                    id="blogs-table"
                                >


                                    {{-- =================================================
                                        TABLE HEAD
                                    ================================================== --}}
                                    <thead>

                                        <tr>

                                            <th
                                                class="text-center"
                                                width="60"
                                            >
                                                SL
                                            </th>


                                            <th width="90">
                                                Image
                                            </th>


                                            <th>
                                                Title
                                            </th>


                                            <th>
                                                Category
                                            </th>


                                            <th>
                                                Published
                                            </th>


                                            <th>
                                                Status
                                            </th>


                                            <th
                                                width="170"
                                                class="text-center"
                                            >
                                                Action
                                            </th>

                                        </tr>

                                    </thead>



                                    {{-- =================================================
                                        TABLE BODY
                                    ================================================== --}}
                                    <tbody>


                                        @foreach ($blogs as $blog)

                                            <tr>


                                                {{-- =========================================
                                                    SERIAL
                                                ========================================== --}}
                                                <td class="text-center"></td>



                                                {{-- =========================================
                                                    IMAGE
                                                ========================================== --}}
                                                <td>

                                                    @if ($blog->image)

                                                        <img
                                                            src="{{ asset($blog->image) }}"
                                                            alt="{{ $blog->title }}"
                                                            width="60"
                                                            height="45"
                                                            style="
                                                                object-fit: cover;
                                                                border-radius: 5px;
                                                            "
                                                        >

                                                    @else

                                                        <div
                                                            class="bg-primary text-white d-flex align-items-center justify-content-center"
                                                            style="
                                                                width:60px;
                                                                height:45px;
                                                                border-radius:5px;
                                                            "
                                                        >

                                                            <i
                                                                class="bi {{ $blog->icon ?? 'bi-heart-pulse' }}"
                                                                style="font-size:20px;"
                                                            ></i>

                                                        </div>

                                                    @endif

                                                </td>



                                                {{-- =========================================
                                                    TITLE
                                                ========================================== --}}
                                                <td>

                                                    <strong>
                                                        {{ $blog->title }}
                                                    </strong>


                                                    @if ($blog->excerpt)

                                                        <br>

                                                        <small class="text-muted">

                                                            {{ \Illuminate\Support\Str::limit($blog->excerpt, 70) }}

                                                        </small>

                                                    @endif

                                                </td>



                                                {{-- =========================================
                                                    CATEGORY
                                                ========================================== --}}
                                                <td>

                                                    @if ($blog->category)

                                                        <label class="badge badge-info">

                                                            {{ $blog->category }}

                                                        </label>

                                                    @else

                                                        <span class="text-muted">
                                                            N/A
                                                        </span>

                                                    @endif

                                                </td>



                                                {{-- =========================================
                                                    PUBLISHED DATE
                                                ========================================== --}}
                                                <td>

                                                    @if ($blog->published_at)

                                                        {{ $blog->published_at->format('d M Y') }}

                                                    @else

                                                        <span class="text-muted">
                                                            N/A
                                                        </span>

                                                    @endif

                                                </td>



                                                {{-- =========================================
                                                    STATUS
                                                ========================================== --}}
                                                <td>

                                                    @if ($blog->is_published)

                                                        <label class="badge badge-success">

                                                            Published

                                                        </label>

                                                    @else

                                                        <label class="badge badge-warning">

                                                            Draft

                                                        </label>

                                                    @endif

                                                </td>



                                                {{-- =========================================
                                                    ACTION
                                                ========================================== --}}
                                             <td>

    <div
        class="d-flex justify-content-center"
        style="gap:5px;"
    >

        {{-- ==============================
            SHOW
        =============================== --}}
        @can('blog-list')

            <a
                class="btn btn-info btn-sm"
                href="{{ route('backend.blogs.show', $blog) }}"
                title="Show"
            >
                <i class="fa-solid fa-eye"></i>
            </a>

        @endcan


        {{-- ==============================
            EDIT
        =============================== --}}
        @can('blog-edit')

            <a
                class="btn btn-primary btn-sm"
                href="{{ route('backend.blogs.edit', $blog) }}"
                title="Edit"
            >
                <i class="fas fa-pencil-alt"></i>
            </a>

        @endcan


        {{-- ==============================
            FRONTEND VIEW
        =============================== --}}
        @if($blog->is_published)

            <a
                class="btn btn-success btn-sm"
                href="{{ route('blog.view', $blog) }}"
                target="_blank"
                title="View on Website"
            >
                <i class="fas fa-external-link-alt"></i>
            </a>

        @endif


        {{-- ==============================
            DELETE
        =============================== --}}
        @can('blog-delete')

            <form
                action="{{ route('backend.blogs.destroy', $blog) }}"
                method="POST"
                style="display:inline;"
                class="delete-blog-form"
            >

                @csrf

                @method('DELETE')

                <button
                    type="submit"
                    class="btn btn-danger btn-sm delete-blog-btn"
                    title="Delete"
                >
                    <i class="fas fa-trash"></i>
                </button>

            </form>

        @endcan


    </div>

</td>

                                            </tr>

                                        @endforeach


                                    </tbody>

                                </table>

                            </div>


                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection



{{-- =========================================================
    DATATABLE JS
========================================================= --}}
@push('scripts')

    <script src="{{ asset('backend/library/datatables/media/js/jquery.dataTables.min.js') }}"></script>


    <script>

        $(document).ready(function () {


            /* =====================================================
               BLOG DATATABLE
            ====================================================== */

            var table = $('#blogs-table').DataTable({

                /*
                |--------------------------------------------------------------------------
                | Disable sorting on Image and Action
                |--------------------------------------------------------------------------
                */

                columnDefs: [

                    {
                        orderable: false,
                        targets: [0, 1, 6]
                    },

                    {
                        searchable: false,
                        targets: [0, 1, 6]
                    }

                ],


                /*
                |--------------------------------------------------------------------------
                | Default sorting
                |--------------------------------------------------------------------------
                */

                order: [
                    [4, 'desc']
                ],


                /*
                |--------------------------------------------------------------------------
                | Page length
                |--------------------------------------------------------------------------
                */

                pageLength: 10,


                /*
                |--------------------------------------------------------------------------
                | Available page lengths
                |--------------------------------------------------------------------------
                */

                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],


                /*
                |--------------------------------------------------------------------------
                | Language
                |--------------------------------------------------------------------------
                */

                language: {

                    search: "Search Blog:",

                    lengthMenu: "Show _MENU_ Blogs",

                    info: "Showing _START_ to _END_ of _TOTAL_ Blogs",

                    infoEmpty: "No Blogs available",

                    zeroRecords: "No matching Blogs found",

                    emptyTable: "No Blogs Found",

                    paginate: {

                        first: "First",

                        last: "Last",

                        next: "Next",

                        previous: "Previous"

                    }

                }

            });



            /* =====================================================
               DYNAMIC SERIAL NUMBER
            ====================================================== */

            table.on(
                'order.dt search.dt draw.dt',
                function () {

                    table
                        .column(0, {
                            search: 'applied',
                            order: 'applied'
                        })
                        .nodes()
                        .each(function (cell, i) {

                            cell.innerHTML = i + 1;

                        });

                }
            ).draw();



            /* =====================================================
               DELETE CONFIRMATION
            ====================================================== */

            $(document).on(
                'submit',
                '.delete-blog-form',
                function (event) {


                    var confirmed = confirm(
                        'আপনি কি নিশ্চিতভাবে এই Blog টি Delete করতে চান?\n\nএই কাজটি Undo করা যাবে না।'
                    );


                    if (!confirmed) {

                        event.preventDefault();

                        return false;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Prevent double click
                    |--------------------------------------------------------------------------
                    */

                    var button = $(this).find(
                        '.delete-blog-btn'
                    );


                    button.prop(
                        'disabled',
                        true
                    );


                    button.html(
                        '<i class="fas fa-spinner fa-spin"></i>'
                    );


                }
            );


        });

    </script>

@endpush