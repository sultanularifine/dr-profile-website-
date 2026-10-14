<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('blogs') && !Schema::hasColumn('blogs', 'image_alt')) {
            Schema::table('blogs', function (Blueprint $table) {
                $table->string('image_alt', 255)->nullable();
            });
        }
    }

    public function down(): void
    {
        // Preserve editorial metadata during rollback.
    }
};
