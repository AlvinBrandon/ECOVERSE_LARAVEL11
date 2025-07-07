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
        Schema::create('raw_materials', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('type')->nullable();
        $table->string('unit')->default('kg');
        $table->decimal('quantity', 12, 2)->default(0);
        $table->decimal('reorder_level', 12, 2)->default(0);
        $table->string('description')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_materials');
    }
};
