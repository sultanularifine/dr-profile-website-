<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('appointment_status_histories')) {
            return;
        }

        Schema::create('appointment_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->restrictOnDelete();
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('old_status', 40)->nullable();
            $table->string('new_status', 40);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['appointment_id', 'created_at']);
        });
    }

    public function down(): void
    {
        // Deliberately preserve appointment audit history during rollback.
    }
};
