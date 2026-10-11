<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {

            $table->id();

            // =========================
            // Blog Basic Information
            // =========================
            $table->string('title');
            $table->string('slug')->unique();

            // =========================
            // SEO Information
            // =========================
            $table->string('seo_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('focus_keyword')->nullable();
            $table->string('canonical_url')->nullable();

            // =========================
            // Open Graph / Social SEO
            // =========================
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();

            // SEO Score: 0 - 100
            $table->unsignedTinyInteger('seo_score')->default(0);

            // =========================
            // Category
            // =========================
            $table->string('category');
            $table->string('category_slug');

            // =========================
            // Publishing Information
            // =========================
            $table->date('published_at')->nullable();
            $table->string('read_time')->nullable();

            // =========================
            // Blog Icon & Image
            // =========================
            $table->string('icon')->nullable();
            $table->string('image')->nullable();

            // =========================
            // Short Summary
            // =========================
            $table->text('excerpt')->nullable();

            // =========================
            // Blog Tags
            // =========================
            $table->json('tags')->nullable();

            // =========================
            // Full Blog Content
            // =========================
            $table->longText('content');

            // =========================
            // Publish Status
            // =========================
            $table->boolean('is_published')->default(true);

            // =========================
            // Timestamps
            // =========================
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};