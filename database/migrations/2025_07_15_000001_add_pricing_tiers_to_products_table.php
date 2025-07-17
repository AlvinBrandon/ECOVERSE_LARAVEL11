<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('wholesale_price', 12, 2)->nullable()->after('price');
            $table->decimal('retail_price', 12, 2)->nullable()->after('wholesale_price');
            $table->decimal('customer_price', 12, 2)->nullable()->after('retail_price');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['wholesale_price', 'retail_price', 'customer_price']);
        });
    }
};
