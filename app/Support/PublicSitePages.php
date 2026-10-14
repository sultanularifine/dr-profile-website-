<?php

namespace App\Support;

/**
 * Single source of truth for public CMS/SEO page keys and their existing routes.
 * Dynamic blog detail URLs keep their per-post SEO fields.
 */
class PublicSitePages
{
    public static function all(): array
    {
        return [
            'home' => ['label' => 'Home', 'path' => '/', 'route' => 'home'],
            'about' => ['label' => 'About', 'path' => '/about', 'route' => 'about'],
            'services' => ['label' => 'Services', 'path' => '/services', 'route' => 'services'],
            'blog' => ['label' => 'Blog', 'path' => '/blog', 'route' => 'blog'],
            'testimonials' => ['label' => 'Testimonials', 'path' => '/testimonials', 'route' => 'testimonials'],
            'faq' => ['label' => 'FAQ', 'path' => '/faq', 'route' => 'faq'],
            'contact' => ['label' => 'Contact', 'path' => '/contact', 'route' => 'contact'],
            'appointment' => ['label' => 'Appointment', 'path' => '/appointment', 'route' => 'appointment'],
        ];
    }

    public static function keyForRoute(?string $routeName): ?string
    {
        foreach (self::all() as $key => $page) {
            if ($page['route'] === $routeName) {
                return $key;
            }
        }
        return null;
    }
}
