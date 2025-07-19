<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // $table->string('delivery_method')->nullable(); // delivery, pickup
            $table->string('delivery_status')->default('pending'); // pending, dispatched, delivered, pickup_arranged
            $table->text('dispatch_log')->nullable();
            $table->string('tracking_code')->nullable();
            $table->string('delivery_partner')->nullable();
            $table->timestamp('delivery_confirmation')->nullable();
            $table->boolean('payment_on_delivery')->default(false);
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'delivery_method',
                'delivery_status',
                'dispatch_log',
                'tracking_code',
                'delivery_partner',
                'delivery_confirmation',
                'payment_on_delivery',
            ]);
        });
    }
};
