<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SetFactorySellerRoleSeeder extends Seeder
{
    public function run()
    {
        // Set seller_role to 'factory' for all products
        DB::table('products')->update(['seller_role' => 'factory']);
    }
}
