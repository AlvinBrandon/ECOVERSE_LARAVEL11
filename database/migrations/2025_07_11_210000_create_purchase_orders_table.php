<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('users');
            $table->foreignId('raw_material_id')->constrained('raw_materials');
            $table->integer('quantity');
            $table->decimal('price', 12, 2);
            $table->string('status')->default('pending'); // pending, delivered, complete, paid
            $table->string('invoice_path')->nullable();
            $table->foreignId('created_by')->constrained('users'); // admin who created
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('purchase_orders');
    }
};
