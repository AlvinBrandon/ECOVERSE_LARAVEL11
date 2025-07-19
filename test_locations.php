<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$locations = \App\Models\Location::all();
echo "Locations Count: " . $locations->count() . PHP_EOL;

foreach ($locations as $location) {
    echo "- ID: {$location->id}, Name: {$location->name}" . PHP_EOL;
}
