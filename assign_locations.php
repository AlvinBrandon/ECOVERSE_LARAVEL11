<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Get the Main Warehouse location ID
$mainWarehouse = \App\Models\Location::where('name', 'Main Warehouse')->first();

if ($mainWarehouse) {
    // Update all inventory records to be assigned to Main Warehouse
    $updated = \App\Models\Inventory::whereNull('location_id')->update(['location_id' => $mainWarehouse->id]);
    echo "Updated {$updated} inventory records to Main Warehouse (ID: {$mainWarehouse->id})" . PHP_EOL;
} else {
    echo "Main Warehouse location not found!" . PHP_EOL;
}
