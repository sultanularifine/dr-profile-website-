<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('site_settings')) {
            Schema::create('site_settings', function (Blueprint $table) {
                $table->id();
                $table->string('key', 120)->unique();
                $table->longText('value')->nullable();
                $table->longText('secret_value')->nullable();
                $table->boolean('is_secret')->default(false);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('page_seo')) {
            Schema::create('page_seo', function (Blueprint $table) {
                $table->id();
                $table->string('page_key', 80)->unique();
                $table->string('seo_title', 255)->nullable();
                $table->string('meta_description', 320)->nullable();
                $table->string('canonical_url', 2000)->nullable();
                $table->boolean('robots_index')->default(true);
                $table->boolean('robots_follow')->default(true);
                $table->string('og_title', 255)->nullable();
                $table->string('og_description', 320)->nullable();
                $table->string('og_image', 1000)->nullable();
                $table->string('twitter_card', 40)->default('summary_large_image');
                $table->boolean('sitemap_include')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('consent_records')) {
            Schema::create('consent_records', function (Blueprint $table) {
                $table->id();
                $table->char('visitor_hash', 64)->unique();
                $table->boolean('analytics')->default(false);
                $table->boolean('marketing')->default(false);
                $table->string('consent_version', 30)->default('1.0');
                $table->timestamp('consented_at')->nullable();
                $table->timestamp('withdrawn_at')->nullable();
                $table->timestamps();
                $table->index(['analytics', 'marketing']);
            });
        }
    }

    public function down(): void
    {
        // Settings and consent records are intentionally retained on rollback.
    }
};
