<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$suppliers = \App\Models\User::where('role', 'supplier')->get();
echo "Suppliers Count: " . $suppliers->count() . PHP_EOL;

foreach ($suppliers as $supplier) {
    echo "- ID: {$supplier->id}, Name: {$supplier->name}, Email: {$supplier->email}" . PHP_EOL;
}
