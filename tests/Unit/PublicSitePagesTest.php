<?php

namespace Tests\Unit;

use App\Support\PublicSitePages;
use PHPUnit\Framework\TestCase;

class PublicSitePagesTest extends TestCase
{
    public function test_public_page_keys_and_routes_are_unique(): void
    {
        $pages = PublicSitePages::all();

        self::assertNotEmpty($pages);
        self::assertCount(count(array_unique(array_column($pages, 'route'))), $pages);
        self::assertCount(count(array_unique(array_column($pages, 'path'))), $pages);
    }

    public function test_route_mapping_returns_expected_page_key(): void
    {
        self::assertSame('home', PublicSitePages::keyForRoute('home'));
        self::assertSame('blog', PublicSitePages::keyForRoute('blog'));
        self::assertNull(PublicSitePages::keyForRoute('blog.view'));
        self::assertNull(PublicSitePages::keyForRoute(null));
    }
}
