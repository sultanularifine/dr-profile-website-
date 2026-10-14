<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('appointment_payments')) {
            return;
        }

        Schema::create('appointment_payments', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 40)->unique();
            $table->foreignId('appointment_id')->constrained()->restrictOnDelete();
            $table->foreignId('patient_id')->constrained('users')->restrictOnDelete();
            $table->string('method', 40);
            $table->decimal('amount', 10, 2);
            $table->string('transaction_reference', 255)->nullable();
            $table->string('proof_path')->nullable();
            $table->string('proof_original_name', 255)->nullable();
            $table->string('proof_mime', 120)->nullable();
            $table->unsignedBigInteger('proof_size')->nullable();
            $table->string('status', 30)->default('pending'); // pending, verified, rejected, refunded
            $table->text('patient_note')->nullable();
            $table->text('review_note')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
            $table->index(['appointment_id', 'status']);
            $table->index(['patient_id', 'created_at']);
        });
    }

    public function down(): void
    {
        // Payment audit data is intentionally retained during routine rollback.
    }
};
