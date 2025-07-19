<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$inventories = \App\Models\Inventory::all();
echo "Inventories Count: " . $inventories->count() . PHP_EOL;

$inventoriesWithoutLocation = \App\Models\Inventory::whereNull('location_id')->count();
echo "Inventories without location: " . $inventoriesWithoutLocation . PHP_EOL;

$inventoriesWithLocation = \App\Models\Inventory::whereNotNull('location_id')->count();
echo "Inventories with location: " . $inventoriesWithLocation . PHP_EOL;
