<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Blog Listing
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Blog::query()
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->orderByDesc('id');


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim($request->search);


            if ($search !== '') {

                $query->where(function ($q) use ($search) {

                    $q->where(
                        'title',
                        'like',
                        '%' . $search . '%'
                    )

                    ->orWhere(
                        'excerpt',
                        'like',
                        '%' . $search . '%'
                    )

                    ->orWhere(
                        'category',
                        'like',
                        '%' . $search . '%'
                    );

                });

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Category Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('category')) {

            $query->where(
                'category_slug',
                $request->category
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Blogs
        |--------------------------------------------------------------------------
        */

        $blogs = $query
            ->paginate(9)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        $categories = Blog::query()
            ->where('is_published', true)
            ->select(
                'category',
                'category_slug'
            )
            ->selectRaw(
                'COUNT(*) as total'
            )
            ->groupBy(
                'category',
                'category_slug'
            )
            ->orderBy('category')
            ->get();


        return view(
            'frontend.pages.blog',
            compact(
                'blogs',
                'categories'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Single Blog
    |--------------------------------------------------------------------------
    */

    public function show(Blog $blog)
    {
        /*
        |--------------------------------------------------------------------------
        | Only Published Blog
        |--------------------------------------------------------------------------
        */

        abort_if(
            !$blog->is_published,
            404
        );


        /*
        |--------------------------------------------------------------------------
        | Related Blogs
        |--------------------------------------------------------------------------
        */

        $relatedBlogs = Blog::query()
            ->where('is_published', true)

            ->where(
                'id',
                '!=',
                $blog->id
            )

            ->where(
                'category_slug',
                $blog->category_slug
            )

            ->orderByDesc('published_at')
            ->orderByDesc('id')

            ->take(3)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | যদি একই category-তে ৩টি না থাকে
        |--------------------------------------------------------------------------
        */

        if ($relatedBlogs->count() < 3) {

            $remaining = Blog::query()
                ->where('is_published', true)

                ->where(
                    'id',
                    '!=',
                    $blog->id
                )

                ->whereNotIn(
                    'id',
                    $relatedBlogs
                        ->pluck('id')
                        ->toArray()
                )

                ->orderByDesc('published_at')
                ->orderByDesc('id')

                ->take(
                    3 - $relatedBlogs->count()
                )

                ->get();


            $relatedBlogs = $relatedBlogs
                ->concat($remaining);
        }


        /*
        |--------------------------------------------------------------------------
        | Sidebar Categories
        |--------------------------------------------------------------------------
        */

        $categories = Blog::query()
            ->where('is_published', true)

            ->select(
                'category',
                'category_slug'
            )

            ->selectRaw(
                'COUNT(*) as total'
            )

            ->groupBy(
                'category',
                'category_slug'
            )

            ->orderBy('category')

            ->get();


        return view(
            'frontend.pages.blog-view',
            compact(
                'blog',
                'relatedBlogs',
                'categories'
            )
        );
    }
}