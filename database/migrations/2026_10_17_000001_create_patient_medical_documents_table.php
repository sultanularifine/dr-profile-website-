<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void { if (Schema::hasTable('patient_medical_documents')) return; Schema::create('patient_medical_documents', function(Blueprint $table){ $table->id(); $table->foreignId('patient_id')->constrained('users')->cascadeOnDelete(); $table->foreignId('appointment_id')->nullable()->constrained()->nullOnDelete(); $table->foreignId('uploaded_by')->constrained('users')->restrictOnDelete(); $table->string('title',255); $table->string('document_type',60)->default('medical_report'); $table->string('private_file_path'); $table->string('original_filename',255); $table->string('mime_type',120)->nullable(); $table->unsignedBigInteger('file_size')->nullable(); $table->text('notes')->nullable(); $table->timestamps(); $table->index(['patient_id','created_at']); }); }
 public function down(): void { Schema::dropIfExists('patient_medical_documents'); }
};
