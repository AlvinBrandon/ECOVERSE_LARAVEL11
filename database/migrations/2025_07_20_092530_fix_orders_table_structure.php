<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add total_price column if it doesn't exist
            if (!Schema::hasColumn('orders', 'total_price')) {
                $table->decimal('total_price', 12, 2)->nullable()->after('unit_price');
            }
            
            // Add address column if it doesn't exist
            if (!Schema::hasColumn('orders', 'address')) {
                $table->string('address')->nullable()->after('total_price');
            }
            
            // Add delivery_method column if it doesn't exist
            if (!Schema::hasColumn('orders', 'delivery_method')) {
                $table->string('delivery_method')->nullable()->after('address');
            }
            
            // If total_amount column exists, make it nullable or drop it
            if (Schema::hasColumn('orders', 'total_amount')) {
                $table->decimal('total_amount', 12, 2)->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Reverse the changes if needed
            if (Schema::hasColumn('orders', 'delivery_method')) {
                $table->dropColumn('delivery_method');
            }
            if (Schema::hasColumn('orders', 'address')) {
                $table->dropColumn('address');
            }
            if (Schema::hasColumn('orders', 'total_price')) {
                $table->dropColumn('total_price');
            }
        });
    }
};
