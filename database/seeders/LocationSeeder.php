<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            ['name' => 'Main Warehouse', 'description' => 'Primary storage facility for all products and raw materials'],
            ['name' => 'Retail Store - Kampala', 'description' => 'Retail outlet in Kampala city center'],
            ['name' => 'Retail Store - Entebbe', 'description' => 'Retail outlet in Entebbe'],
            ['name' => 'Processing Center', 'description' => 'Manufacturing and processing facility'],
            ['name' => 'Quality Control Lab', 'description' => 'Quality testing and control facility'],
            ['name' => 'Distribution Center', 'description' => 'Distribution hub for wholesale deliveries'],
            ['name' => 'Mobile Unit 1', 'description' => 'Mobile collection and delivery unit'],
            ['name' => 'Mobile Unit 2', 'description' => 'Mobile collection and delivery unit'],
        ];

        foreach ($locations as $location) {
            Location::firstOrCreate(['name' => $location['name']], $location);
        }
    }
}
