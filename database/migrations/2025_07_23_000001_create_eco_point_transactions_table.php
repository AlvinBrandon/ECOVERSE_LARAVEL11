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
        Schema::create('eco_point_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // 'earned', 'redeemed', 'bonus', 'penalty'
            $table->integer('points'); // positive for earned, negative for redeemed
            $table->string('source'); // 'order', 'referral', 'profile_completion', 'review', etc.
            $table->text('description');
            $table->json('metadata')->nullable(); // additional data like order_id, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eco_point_transactions');
    }
};
