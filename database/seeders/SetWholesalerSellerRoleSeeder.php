<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SetWholesalerSellerRoleSeeder extends Seeder
{
    public function run()
    {
        // Set seller_role to 'wholesaler' for products purchased by a wholesaler (role_as = 5), regardless of seller
        $productIds = DB::table('orders')
            ->join('users as buyers', 'orders.user_id', '=', 'buyers.id')
            ->where('buyers.role_as', 5) // wholesaler
            ->pluck('orders.product_id')
            ->unique();

        DB::table('products')
            ->whereIn('id', $productIds)
            ->update(['seller_role' => 'wholesaler']);
    }
}
