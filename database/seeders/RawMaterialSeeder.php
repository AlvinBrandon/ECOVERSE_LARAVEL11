<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RawMaterial;

class RawMaterialSeeder extends Seeder
{
    public function run()
    {
        $materials = [
            ['name' => 'Plastic Waste', 'type' => 'plastic waste', 'unit' => 'kg', 'quantity' => 0, 'reorder_level' => 10, 'description' => 'Recyclable plastic materials'],
            ['name' => 'Organic Waste', 'type' => 'organic waste', 'unit' => 'kg', 'quantity' => 0, 'reorder_level' => 10, 'description' => 'Compostable organic materials'],
            ['name' => 'E-waste', 'type' => 'e-waste', 'unit' => 'kg', 'quantity' => 0, 'reorder_level' => 10, 'description' => 'Electronic waste materials'],
            ['name' => 'Metal Waste', 'type' => 'metal waste', 'unit' => 'kg', 'quantity' => 0, 'reorder_level' => 10, 'description' => 'Scrap metal materials'],
            ['name' => 'Glass', 'type' => 'glass', 'unit' => 'kg', 'quantity' => 0, 'reorder_level' => 10, 'description' => 'Glass waste materials'],
            ['name' => 'Construction Remains', 'type' => 'construction remains', 'unit' => 'kg', 'quantity' => 0, 'reorder_level' => 10, 'description' => 'Construction and demolition waste'],
        ];
        foreach ($materials as $material) {
            RawMaterial::firstOrCreate(['name' => $material['name']], $material);
        }
    }
}
