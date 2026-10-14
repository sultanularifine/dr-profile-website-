<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('appointments')) {
            return;
        }

        Schema::table('appointments', function (Blueprint $table) {
            if (!Schema::hasColumn('appointments', 'booking_source')) {
                $table->string('booking_source', 30)->default('patient')->after('appointment_code');
            }
            if (!Schema::hasColumn('appointments', 'created_by')) {
                $table->foreignId('created_by')->nullable()->after('patient_id')->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('appointments', 'fee_waived')) {
                $table->boolean('fee_waived')->default(false)->after('fee');
            }
            if (!Schema::hasColumn('appointments', 'fee_waiver_reason')) {
                $table->text('fee_waiver_reason')->nullable()->after('fee_waived');
            }
        });
    }

    public function down(): void
    {
        // Keep clinical/booking records intact during rollback. Added columns are intentionally retained.
    }
};
