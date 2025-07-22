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
        Schema::table('inventories', function (Blueprint $table) {
            $table->foreignId('owner_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('owner_type')->default('factory'); // factory, retailer, wholesaler
            $table->decimal('retail_markup', 8, 2)->nullable(); // For retailer-specific pricing
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropForeign(['owner_id']);
            $table->dropColumn(['owner_id', 'owner_type', 'retail_markup']);
        });
    }
};
