<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SetRetailerSellerRoleSeeder extends Seeder
{
    public function run()
    {
        // Set seller_role to 'retailer' for products purchased by a retailer from a wholesaler
        $productIds = DB::table('orders')
            ->join('users as buyers', 'orders.user_id', '=', 'buyers.id')
            ->where('buyers.role', 'retailer')
            ->pluck('orders.product_id')
            ->unique();

        DB::table('products')
            ->whereIn('id', $productIds)
            ->update(['seller_role' => 'retailer']);
    }
}
