<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSeo extends Model
{
    protected $table = 'page_seo';

    protected $fillable = [
        'page_key', 'seo_title', 'meta_description', 'canonical_url',
        'robots_index', 'robots_follow', 'og_title', 'og_description',
        'og_image', 'twitter_card', 'sitemap_include',
    ];

    protected $casts = [
        'robots_index' => 'boolean',
        'robots_follow' => 'boolean',
        'sitemap_include' => 'boolean',
    ];
}
