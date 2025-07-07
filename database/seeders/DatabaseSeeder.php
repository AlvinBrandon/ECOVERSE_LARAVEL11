<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory()->create([
        //    'name' => 'Admin',
        //    'email' => 'admin@material.com',
        //    'password' => Hash::make('secret')
        //]);
        // Remove old products and inventory
        // Disable foreign key checks for MySQL
        if (app()->environment('local') && \DB::getDriverName() === 'mysql') {
            \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }
        \DB::table('inventories')->truncate();
        \DB::table('products')->truncate();
        if (app()->environment('local') && \DB::getDriverName() === 'mysql') {
            \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
        // Seed new products and inventory
        Product::factory(20)->create()->each(function ($product) {
            Inventory::create([
                'product_id' => $product->id,
                'batch_id' => 'BATCH-' . rand(1000, 9999),
                'quantity' => rand(10, 100),
            ]);
        });
        $this->call(RawMaterialInventorySeeder::class);
        $this->call(UserSeeder::class);
    }
}
