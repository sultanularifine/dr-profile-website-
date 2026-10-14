<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('appointments')) {
            return;
        }

        Schema::table('appointments', function (Blueprint $table) {
            if (!Schema::hasColumn('appointments', 'meeting_manual_override')) {
                $table->boolean('meeting_manual_override')->default(false);
            }
            if (!Schema::hasColumn('appointments', 'meeting_override_by')) {
                $table->foreignId('meeting_override_by')->nullable()->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('appointments', 'meeting_override_at')) {
                $table->timestamp('meeting_override_at')->nullable();
            }
            if (!Schema::hasColumn('appointments', 'meeting_override_reason')) {
                $table->text('meeting_override_reason')->nullable();
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('appointments')) {
            return;
        }

        if (Schema::hasColumn('appointments', 'meeting_override_by')) {
            Schema::table('appointments', function (Blueprint $table) {
                $table->dropForeign(['meeting_override_by']);
            });
        }

        $columns = array_values(array_filter([
            'meeting_manual_override',
            'meeting_override_by',
            'meeting_override_at',
            'meeting_override_reason',
        ], fn ($column) => Schema::hasColumn('appointments', $column)));

        if ($columns) {
            Schema::table('appointments', function (Blueprint $table) use ($columns) {
                $table->dropColumn($columns);
            });
        }
    }
};
