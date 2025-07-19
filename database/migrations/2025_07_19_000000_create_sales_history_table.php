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
        Schema::create('sales_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity_sold');
            $table->decimal('price', 10, 2);
            $table->string('season')->nullable();
            $table->integer('stock_level');
            $table->boolean('promotion_active')->default(false);
            $table->date('sale_date');
            $table->timestamps();

            // Index for faster queries
            $table->index(['product_id', 'sale_date']);
            $table->index('season');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_history');
    }
}; 