<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('doctor_profiles')) {
            Schema::create('doctor_profiles', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                $table->string('full_name')->nullable();
                $table->string('professional_title')->nullable();
                $table->string('bmdc_registration')->nullable();
                $table->string('phone')->nullable();
                $table->string('public_email')->nullable();
                $table->text('biography')->nullable();
                $table->string('profile_photo')->nullable();
                $table->string('cover_image')->nullable();
                $table->json('qualifications')->nullable();
                $table->json('specializations')->nullable();
                $table->unsignedSmallInteger('years_experience')->nullable();
                $table->boolean('is_visible')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('chambers')) {
            Schema::create('chambers', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('hospital_name')->nullable();
                $table->string('department')->nullable();
                $table->text('address');
                $table->string('phone')->nullable();
                $table->string('maps_url', 1000)->nullable();
                $table->enum('consultation_type', ['offline', 'online', 'both'])->default('both');
                $table->decimal('consultation_fee', 10, 2)->default(0);
                $table->boolean('is_default')->default(false);
                $table->boolean('is_active')->default(true);
                $table->unsignedInteger('display_order')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('chamber_schedules')) {
            Schema::create('chamber_schedules', function (Blueprint $table) {
                $table->id();
                $table->foreignId('chamber_id')->constrained()->cascadeOnDelete();
                $table->unsignedTinyInteger('weekday');
                $table->time('starts_at');
                $table->time('ends_at');
                $table->unsignedSmallInteger('slot_minutes')->default(15);
                $table->unsignedSmallInteger('max_patients')->default(20);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                $table->index(['chamber_id', 'weekday', 'is_active']);
            });
        }

        if (!Schema::hasTable('appointments')) {
            Schema::create('appointments', function (Blueprint $table) {
                $table->id();
                $table->string('appointment_code', 40)->unique();
                $table->foreignId('patient_id')->constrained('users')->restrictOnDelete();
                $table->foreignId('chamber_id')->nullable()->constrained()->nullOnDelete();
                $table->enum('consultation_type', ['offline', 'online'])->default('offline');
                $table->dateTime('scheduled_at');
                $table->unsignedSmallInteger('duration_minutes')->default(15);
                $table->string('reason', 1000)->nullable();
                $table->enum('status', ['pending', 'confirmed', 'waiting', 'in_progress', 'completed', 'cancelled', 'rejected', 'no_show'])->default('pending');
                $table->decimal('fee', 10, 2)->default(0);
                $table->enum('payment_status', ['unpaid', 'pending', 'paid', 'refunded'])->default('unpaid');
                $table->string('meeting_provider')->nullable();
                $table->text('meeting_url')->nullable();
                $table->string('meeting_id')->nullable();
                $table->text('meeting_passcode')->nullable();
                $table->text('meeting_instructions')->nullable();
                $table->timestamp('consultation_started_at')->nullable();
                $table->timestamp('consultation_completed_at')->nullable();
                $table->text('admin_notes')->nullable();
                $table->timestamps();
                $table->index(['patient_id', 'scheduled_at']);
                $table->index(['status', 'scheduled_at']);
            });
        }

        if (!Schema::hasTable('prescriptions')) {
            Schema::create('prescriptions', function (Blueprint $table) {
                $table->id();
                $table->string('reference', 40)->unique();
                $table->foreignId('appointment_id')->constrained()->restrictOnDelete();
                $table->foreignId('patient_id')->constrained('users')->restrictOnDelete();
                $table->foreignId('author_id')->constrained('users')->restrictOnDelete();
                $table->enum('type', ['digital', 'handwritten'])->default('digital');
                $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
                $table->string('title')->nullable();
                $table->longText('chief_complaints')->nullable();
                $table->longText('examination_findings')->nullable();
                $table->longText('diagnosis')->nullable();
                $table->longText('investigation_advice')->nullable();
                $table->longText('general_advice')->nullable();
                $table->date('follow_up_date')->nullable();
                $table->string('private_file_path')->nullable();
                $table->string('original_filename')->nullable();
                $table->string('mime_type', 120)->nullable();
                $table->unsignedBigInteger('file_size')->nullable();
                $table->timestamp('published_at')->nullable();
                $table->timestamps();
                $table->index(['patient_id', 'status', 'published_at']);
                $table->index(['appointment_id', 'status']);
            });
        }

        if (!Schema::hasTable('prescription_items')) {
            Schema::create('prescription_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('prescription_id')->constrained()->cascadeOnDelete();
                $table->unsignedInteger('sort_order')->default(0);
                $table->string('medicine_name');
                $table->string('strength')->nullable();
                $table->string('dosage')->nullable();
                $table->string('route')->nullable();
                $table->string('frequency')->nullable();
                $table->string('duration')->nullable();
                $table->string('quantity')->nullable();
                $table->text('instructions')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        // Intentionally do not drop clinical tables automatically: prescription and appointment
        // records are sensitive records and should not be removed by a routine rollback.
    }
};
