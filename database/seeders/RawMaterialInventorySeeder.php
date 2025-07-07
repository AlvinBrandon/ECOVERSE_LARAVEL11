<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RawMaterial;
use App\Models\Inventory;

class RawMaterialInventorySeeder extends Seeder
{
    public function run()
    {
        $rawMaterials = [
            'Plastic Waste' => 100,
            'Organic Waste' => 80,
            'E-waste' => 50,
            'Metal Waste' => 70,
            'Glass' => 60,
            'Construction Remains' => 40,
        ];
        foreach ($rawMaterials as $name => $qty) {
            $material = RawMaterial::where('name', $name)->first();
            if ($material) {
                Inventory::firstOrCreate([
                    'raw_material_id' => $material->id,
                    'batch_id' => 'RM-2025-01',
                ], [
                    'quantity' => $qty,
                ]);
            }
        }
    }
}
