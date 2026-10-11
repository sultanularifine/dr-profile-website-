<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        // Basic Blog
        'title',
        'slug',

        // SEO
        'seo_title',
        'meta_description',
        'focus_keyword',
        'canonical_url',

        // Social SEO
        'og_title',
        'og_description',
        'og_image',

        // Blog Information
        'category',
        'category_slug',

        'published_at',
        'read_time',

        'icon',
        'image',

        'excerpt',

        // Content
        'tags',
        'content',

        // SEO Score
        'seo_score',

        // Publish
        'is_published',
    ];


    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'tags' => 'array',

        'published_at' => 'date',

        'is_published' => 'boolean',

        'seo_score' => 'integer',

    ];


    /*
    |--------------------------------------------------------------------------
    | ROUTE MODEL BINDING
    |--------------------------------------------------------------------------
    |
    | /blog/{blog}
    |
    | এখানে ID-এর পরিবর্তে slug ব্যবহার হবে।
    |
    */

    public function getRouteKeyName()
    {
        return 'slug';
    }


    /*
    |--------------------------------------------------------------------------
    | MODEL BOOT
    |--------------------------------------------------------------------------
    |
    | Automatically generate unique slug when creating blog.
    |
    */

    protected static function boot()
    {
        parent::boot();


        /*
        |--------------------------------------------------------------------------
        | CREATING
        |--------------------------------------------------------------------------
        */

        static::creating(function ($blog) {

            /*
            |--------------------------------------------------------------------------
            | Generate Slug
            |--------------------------------------------------------------------------
            */

            if (empty($blog->slug)) {

                $slug = Str::slug(
                    $blog->title
                );


                /*
                |--------------------------------------------------------------------------
                | Bengali title fallback
                |--------------------------------------------------------------------------
                |
                | Str::slug() Bengali title-এর ক্ষেত্রে
                | কখনো empty return করতে পারে।
                |
                */

                if (empty($slug)) {

                    $slug =
                        'blog-' .
                        time() .
                        '-' .
                        Str::lower(
                            Str::random(6)
                        );

                }


                /*
                |--------------------------------------------------------------------------
                | Make Unique Slug
                |--------------------------------------------------------------------------
                */

                $originalSlug =
                    $slug;

                $counter = 1;


                while (
                    static::where(
                        'slug',
                        $slug
                    )->exists()
                ) {

                    $slug =
                        $originalSlug .
                        '-' .
                        $counter;

                    $counter++;

                }


                $blog->slug =
                    $slug;

            }


            /*
            |--------------------------------------------------------------------------
            | SEO TITLE FALLBACK
            |--------------------------------------------------------------------------
            */

            if (
                empty($blog->seo_title)
            ) {

                $blog->seo_title =
                    $blog->title;

            }


            /*
            |--------------------------------------------------------------------------
            | META DESCRIPTION FALLBACK
            |--------------------------------------------------------------------------
            */

            if (
                empty($blog->meta_description)
            ) {

                $blog->meta_description =
                    $blog->excerpt;

            }


            /*
            |--------------------------------------------------------------------------
            | OG TITLE FALLBACK
            |--------------------------------------------------------------------------
            */

            if (
                empty($blog->og_title)
            ) {

                $blog->og_title =
                    $blog->seo_title;

            }


            /*
            |--------------------------------------------------------------------------
            | OG DESCRIPTION FALLBACK
            |--------------------------------------------------------------------------
            */

            if (
                empty($blog->og_description)
            ) {

                $blog->og_description =
                    $blog->meta_description;

            }


            /*
            |--------------------------------------------------------------------------
            | SEO SCORE
            |--------------------------------------------------------------------------
            */

            if (
                is_null($blog->seo_score)
            ) {

                $blog->seo_score = 0;

            }

        });


        /*
        |--------------------------------------------------------------------------
        | UPDATING
        |--------------------------------------------------------------------------
        */

        static::updating(function ($blog) {

            /*
            |--------------------------------------------------------------------------
            | SEO TITLE FALLBACK
            |--------------------------------------------------------------------------
            */

            if (
                empty($blog->seo_title)
            ) {

                $blog->seo_title =
                    $blog->title;

            }


            /*
            |--------------------------------------------------------------------------
            | META DESCRIPTION FALLBACK
            |--------------------------------------------------------------------------
            */

            if (
                empty($blog->meta_description)
            ) {

                $blog->meta_description =
                    $blog->excerpt;

            }


            /*
            |--------------------------------------------------------------------------
            | OG TITLE FALLBACK
            |--------------------------------------------------------------------------
            */

            if (
                empty($blog->og_title)
            ) {

                $blog->og_title =
                    $blog->seo_title;

            }


            /*
            |--------------------------------------------------------------------------
            | OG DESCRIPTION FALLBACK
            |--------------------------------------------------------------------------
            */

            if (
                empty($blog->og_description)
            ) {

                $blog->og_description =
                    $blog->meta_description;

            }

        });

    }
}