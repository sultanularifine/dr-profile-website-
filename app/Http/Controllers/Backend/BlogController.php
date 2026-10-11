<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $blogs = Blog::latest()->get();

        return view(
            'backend.blogs.index',
            compact('blogs')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('backend.blogs.create');
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([

            'title' => [
                'required',
                'string',
                'max:255'
            ],

            'seo_title' => [
                'nullable',
                'string',
                'max:255'
            ],

            'category' => [
                'required',
                'string',
                'max:100'
            ],

            'category_slug' => [
                'required',
                'string',
                'max:100'
            ],

            'published_at' => [
                'nullable',
                'date'
            ],

            'read_time' => [
                'nullable',
                'string',
                'max:50'
            ],

            'icon' => [
                'nullable',
                'string',
                'max:100'
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],

            'excerpt' => [
                'nullable',
                'string',
                'max:500'
            ],

            'meta_description' => [
                'nullable',
                'string',
                'max:500'
            ],

            'focus_keyword' => [
                'nullable',
                'string',
                'max:255'
            ],

            'canonical_url' => [
                'nullable',
                'url',
                'max:500'
            ],

            'og_title' => [
                'nullable',
                'string',
                'max:255'
            ],

            'og_description' => [
                'nullable',
                'string',
                'max:500'
            ],

            'tags' => [
                'nullable',
                'array'
            ],

            'tags.*' => [
                'nullable',
                'string',
                'max:100'
            ],

            'content' => [
                'required',
                'string'
            ],

            'seo_score' => [
                'nullable',
                'integer',
                'min:0',
                'max:100'
            ],

            'is_published' => [
                'nullable',
                'boolean'
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | TAGS
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['tags'])) {

            $validated['tags'] = collect(
                $validated['tags']
            )
                ->map(
                    fn($tag) => trim($tag)
                )
                ->filter()
                ->values()
                ->toArray();
        } else {

            $validated['tags'] = [];
        }


        /*
        |--------------------------------------------------------------------------
        | SLUG
        |--------------------------------------------------------------------------
        */

        $validated['slug'] =
            Str::slug(
                $validated['title']
            );


        if (empty($validated['slug'])) {

            $validated['slug'] =
                'blog-' .
                time() .
                '-' .
                Str::lower(
                    Str::random(6)
                );
        }


        $originalSlug =
            $validated['slug'];

        $counter = 1;


        while (
            Blog::where(
                'slug',
                $validated['slug']
            )->exists()
        ) {

            $validated['slug'] =
                $originalSlug .
                '-' .
                $counter;

            $counter++;
        }


        /*
        |--------------------------------------------------------------------------
        | SEO FALLBACKS
        |--------------------------------------------------------------------------
        */

        if (
            empty($validated['seo_title'])
        ) {

            $validated['seo_title'] =
                $validated['title'];
        }


        if (
            empty($validated['meta_description'])
        ) {

            $validated['meta_description'] =
                $validated['excerpt'] ?? '';
        }


        if (
            empty($validated['og_title'])
        ) {

            $validated['og_title'] =
                $validated['seo_title'];
        }


        if (
            empty($validated['og_description'])
        ) {

            $validated['og_description'] =
                $validated['meta_description'];
        }


        /*
        |--------------------------------------------------------------------------
        | IMAGE UPLOAD
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $image =
                $request->file('image');


            $uploadPath =
                public_path(
                    'frontend/images/blog'
                );


            if (
                !File::exists($uploadPath)
            ) {

                File::makeDirectory(
                    $uploadPath,
                    0755,
                    true
                );
            }


            $imageName =
                time() .
                '_' .
                Str::random(10) .
                '.' .
                $image->getClientOriginalExtension();


            $image->move(
                $uploadPath,
                $imageName
            );


            $validated['image'] =
                'frontend/images/blog/' .
                $imageName;
        }


        /*
        |--------------------------------------------------------------------------
        | OG IMAGE
        |--------------------------------------------------------------------------
        */

        if (
            empty($validated['og_image']) &&
            !empty($validated['image'])
        ) {

            $validated['og_image'] =
                $validated['image'];
        }


        /*
        |--------------------------------------------------------------------------
        | PUBLISHED
        |--------------------------------------------------------------------------
        */

        $validated['is_published'] =
            $request->boolean(
                'is_published'
            );


        /*
        |--------------------------------------------------------------------------
        | SEO SCORE
        |--------------------------------------------------------------------------
        */

        $validated['seo_score'] =
            (int) (
                $validated['seo_score'] ?? 0
            );


        /*
        |--------------------------------------------------------------------------
        | CREATE
        |--------------------------------------------------------------------------
        */

        Blog::create($validated);


        return redirect()
            ->route(
                'backend.blogs.index'
            )
            ->with(
                'success',
                'Blog সফলভাবে তৈরি হয়েছে।'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show(Blog $blog)
    {
        return view(
            'backend.blogs.show',
            compact('blog')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(Blog $blog)
    {
        return view(
            'backend.blogs.edit',
            compact('blog')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Blog $blog
    ) {

        $validated = $request->validate([

            'title' => [
                'required',
                'string',
                'max:255'
            ],

            'seo_title' => [
                'nullable',
                'string',
                'max:255'
            ],

            'category' => [
                'required',
                'string',
                'max:100'
            ],

            'category_slug' => [
                'required',
                'string',
                'max:100'
            ],

            'published_at' => [
                'nullable',
                'date'
            ],

            'read_time' => [
                'nullable',
                'string',
                'max:50'
            ],

            'icon' => [
                'nullable',
                'string',
                'max:100'
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],

            'excerpt' => [
                'nullable',
                'string',
                'max:500'
            ],

            'meta_description' => [
                'nullable',
                'string',
                'max:500'
            ],

            'focus_keyword' => [
                'nullable',
                'string',
                'max:255'
            ],

            'canonical_url' => [
                'nullable',
                'url',
                'max:500'
            ],

            'og_title' => [
                'nullable',
                'string',
                'max:255'
            ],

            'og_description' => [
                'nullable',
                'string',
                'max:500'
            ],

            'tags' => [
                'nullable',
                'array'
            ],

            'tags.*' => [
                'nullable',
                'string',
                'max:100'
            ],

            'content' => [
                'required',
                'string'
            ],

            'seo_score' => [
                'nullable',
                'integer',
                'min:0',
                'max:100'
            ],

            'is_published' => [
                'nullable',
                'boolean'
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | TAGS
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['tags'])) {

            $validated['tags'] = collect(
                $validated['tags']
            )
                ->map(
                    fn($tag) => trim($tag)
                )
                ->filter()
                ->values()
                ->toArray();
        } else {

            $validated['tags'] = [];
        }


        /*
        |--------------------------------------------------------------------------
        | SLUG
        |--------------------------------------------------------------------------
        */

        $slug =
            Str::slug(
                $validated['title']
            );


        if (empty($slug)) {

            $slug =
                'blog-' .
                time() .
                '-' .
                Str::lower(
                    Str::random(6)
                );
        }


        $originalSlug = $slug;

        $counter = 1;


        while (
            Blog::where(
                'slug',
                $slug
            )
            ->where(
                'id',
                '!=',
                $blog->id
            )
            ->exists()
        ) {

            $slug =
                $originalSlug .
                '-' .
                $counter;

            $counter++;
        }


        $validated['slug'] =
            $slug;


        /*
        |--------------------------------------------------------------------------
        | SEO FALLBACKS
        |--------------------------------------------------------------------------
        */

        if (
            empty($validated['seo_title'])
        ) {

            $validated['seo_title'] =
                $validated['title'];
        }


        if (
            empty($validated['meta_description'])
        ) {

            $validated['meta_description'] =
                $validated['excerpt'] ?? '';
        }


        if (
            empty($validated['og_title'])
        ) {

            $validated['og_title'] =
                $validated['seo_title'];
        }


        if (
            empty($validated['og_description'])
        ) {

            $validated['og_description'] =
                $validated['meta_description'];
        }


        /*
        |--------------------------------------------------------------------------
        | IMAGE UPDATE
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $image =
                $request->file('image');


            $uploadPath =
                public_path(
                    'frontend/images/blog'
                );


            if (
                !File::exists($uploadPath)
            ) {

                File::makeDirectory(
                    $uploadPath,
                    0755,
                    true
                );
            }


            $imageName =
                time() .
                '_' .
                Str::random(10) .
                '.' .
                $image->getClientOriginalExtension();


            $image->move(
                $uploadPath,
                $imageName
            );


            $oldImage =
                $blog->image;


            $validated['image'] =
                'frontend/images/blog/' .
                $imageName;


            $validated['og_image'] =
                $validated['image'];


            $blog->update(
                $validated
            );


            if (
                !empty($oldImage) &&
                File::exists(
                    public_path($oldImage)
                )
            ) {

                File::delete(
                    public_path($oldImage)
                );
            }
        } else {

            if (
                empty($validated['og_image']) &&
                !empty($blog->image)
            ) {

                $validated['og_image'] =
                    $blog->image;
            }


            $blog->update(
                $validated
            );
        }


        return redirect()
            ->route(
                'backend.blogs.index'
            )
            ->with(
                'success',
                'Blog সফলভাবে আপডেট হয়েছে।'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(Blog $blog)
    {
        if (
            !empty($blog->image) &&
            File::exists(
                public_path(
                    $blog->image
                )
            )
        ) {

            File::delete(
                public_path(
                    $blog->image
                )
            );
        }


        $blog->delete();


        return redirect()
            ->route(
                'backend.blogs.index'
            )
            ->with(
                'success',
                'Blog এবং এর Image সফলভাবে ডিলিট হয়েছে।'
            );
    }
}
