<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('prescriptions')) {
            return;
        }

        $needsPath = !Schema::hasColumn('prescriptions', 'generated_pdf_path');
        $needsTimestamp = !Schema::hasColumn('prescriptions', 'generated_pdf_generated_at');

        if ($needsPath || $needsTimestamp) {
            Schema::table('prescriptions', function (Blueprint $table) use ($needsPath, $needsTimestamp) {
                if ($needsPath) {
                    $table->string('generated_pdf_path')->nullable();
                }
                if ($needsTimestamp) {
                    $table->timestamp('generated_pdf_generated_at')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        // Keep generated clinical documents and their metadata during rollback.
    }
};
