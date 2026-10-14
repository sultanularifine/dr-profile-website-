<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('doctor_profiles')) {
            return;
        }

        $columns = [
            'doctor_id' => fn (Blueprint $table) => $table->string('doctor_id')->nullable(),
            'gender' => fn (Blueprint $table) => $table->string('gender', 50)->nullable(),
            'professional_memberships' => fn (Blueprint $table) => $table->json('professional_memberships')->nullable(),
            'awards' => fn (Blueprint $table) => $table->json('awards')->nullable(),
            'publications' => fn (Blueprint $table) => $table->json('publications')->nullable(),
            'languages' => fn (Blueprint $table) => $table->json('languages')->nullable(),
            'services' => fn (Blueprint $table) => $table->json('services')->nullable(),
            'is_featured' => fn (Blueprint $table) => $table->boolean('is_featured')->default(false),
            'verification_status' => fn (Blueprint $table) => $table->string('verification_status', 40)->default('unverified'),
        ];

        foreach ($columns as $name => $addColumn) {
            if (!Schema::hasColumn('doctor_profiles', $name)) {
                Schema::table('doctor_profiles', $addColumn);
            }
        }
    }

    public function down(): void
    {
        // Keep profile data intact during rollback; columns are intentionally not dropped.
    }
};
