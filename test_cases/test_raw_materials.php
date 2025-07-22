<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$rawMaterials = \App\Models\RawMaterial::all();
echo "Raw Materials Count: " . $rawMaterials->count() . PHP_EOL;

foreach ($rawMaterials as $material) {
    echo "- ID: {$material->id}, Name: {$material->name}, Type: {$material->type}" . PHP_EOL;
}
