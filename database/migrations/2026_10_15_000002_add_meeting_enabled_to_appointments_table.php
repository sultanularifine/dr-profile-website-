<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('appointments') && !Schema::hasColumn('appointments', 'meeting_enabled')) {
            Schema::table('appointments', function (Blueprint $table) {
                $table->boolean('meeting_enabled')->default(false);
            });
        }
    }

    public function down(): void
    {
        // Keep the access-control flag to avoid breaking existing consultations on rollback.
    }
};
