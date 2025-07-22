<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

// Check if raw_material_id column exists
$columns = DB::select("SHOW COLUMNS FROM inventories");
echo "Inventories table columns:\n";
foreach ($columns as $column) {
    echo "- {$column->Field} ({$column->Type})\n";
}

echo "\nDoes raw_material_id exist? " . (Schema::hasColumn('inventories', 'raw_material_id') ? 'YES' : 'NO') . "\n";
