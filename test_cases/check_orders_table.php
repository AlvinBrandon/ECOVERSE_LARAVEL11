<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "=== CHECKING ORDERS TABLE STRUCTURE ===\n\n";

try {
    // Check if orders table exists
    if (Schema::hasTable('orders')) {
        echo "✅ Orders table exists\n\n";
        
        // Get columns
        $columns = Schema::getColumnListing('orders');
        echo "📋 Current columns in orders table:\n";
        foreach ($columns as $column) {
            echo "   - {$column}\n";
        }
        
        echo "\n🔍 Checking for missing columns:\n";
        $requiredColumns = ['total_amount', 'total_price', 'address', 'delivery_method'];
        
        foreach ($requiredColumns as $column) {
            if (Schema::hasColumn('orders', $column)) {
                echo "   ✅ {$column} - EXISTS\n";
            } else {
                echo "   ❌ {$column} - MISSING\n";
            }
        }
        
        // Show table structure with data types
        echo "\n📊 Detailed table structure:\n";
        $tableInfo = DB::select("DESCRIBE orders");
        foreach ($tableInfo as $column) {
            echo "   - {$column->Field}: {$column->Type} ({$column->Null}, default: {$column->Default})\n";
        }
        
    } else {
        echo "❌ Orders table does not exist!\n";
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== TABLE CHECK COMPLETED ===\n";
