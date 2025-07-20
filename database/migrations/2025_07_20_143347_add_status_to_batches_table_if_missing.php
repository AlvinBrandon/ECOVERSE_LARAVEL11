<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            if (!Schema::hasColumn('batches', 'batch_number')) {
                $table->string('batch_number')->nullable();
            }
            if (!Schema::hasColumn('batches', 'unit_cost')) {
                $table->decimal('unit_cost', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('batches', 'manufacturing_date')) {
                $table->date('manufacturing_date')->nullable();
            }
            if (!Schema::hasColumn('batches', 'status')) {
                $table->string('status')->default('active');
            }
        });

        // Update existing batch_number values to ensure uniqueness
        DB::statement("UPDATE batches SET batch_number = CONCAT('BATCH-', id) WHERE batch_number IS NULL OR batch_number = ''");
        
        // Now add the unique constraint
        Schema::table('batches', function (Blueprint $table) {
            if (Schema::hasColumn('batches', 'batch_number')) {
                $table->unique('batch_number');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            if (Schema::hasColumn('batches', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('batches', 'batch_number')) {
                $table->dropColumn('batch_number');
            }
            if (Schema::hasColumn('batches', 'unit_cost')) {
                $table->dropColumn('unit_cost');
            }
            if (Schema::hasColumn('batches', 'manufacturing_date')) {
                $table->dropColumn('manufacturing_date');
            }
        });
    }
};
