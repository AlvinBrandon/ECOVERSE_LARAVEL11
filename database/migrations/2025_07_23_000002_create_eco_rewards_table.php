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
        Schema::create('eco_rewards', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "5% Discount Voucher"
            $table->text('description');
            $table->integer('points_required'); // Points needed to redeem
            $table->enum('type', ['discount_percentage', 'discount_fixed', 'free_shipping', 'product_voucher']);
            $table->decimal('value', 8, 2)->nullable(); // Discount amount or percentage
            $table->integer('stock')->default(-1); // -1 for unlimited, positive number for limited
            $table->boolean('is_active')->default(true);
            $table->json('conditions')->nullable(); // Additional conditions like minimum order value
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eco_rewards');
    }
};
