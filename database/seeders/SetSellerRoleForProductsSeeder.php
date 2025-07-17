<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SetSellerRoleForProductsSeeder extends Seeder
{
    public function run()
    {
        // Example: Set all products to 'wholesaler' as seller_role for retailer visibility
        DB::table('products')->update(['seller_role' => 'wholesaler']);
    }
}
