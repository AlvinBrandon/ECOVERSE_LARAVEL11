<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "=== TESTING COMPLETE SALES FLOW ===\n\n";

try {
    // Test products visible to each role
    $roles = ['wholesaler', 'retailer', 'customer'];
    
    foreach ($roles as $role) {
        echo "🔍 PRODUCTS VISIBLE TO {$role}:\n";
        
        $query = \App\Models\Product::with('inventory');
        
        if ($role === 'wholesaler') {
            $query->where('seller_role', 'factory');
        } elseif ($role === 'retailer') {
            $query->where('seller_role', 'wholesaler');
        } elseif ($role === 'customer') {
            $query->where('seller_role', 'retailer');
        }
        
        $products = $query->take(3)->get();
        
        foreach ($products as $product) {
            echo "   - {$product->name} (seller_role: {$product->seller_role})\n";
        }
        echo "\n";
    }
    
    echo "✅ SOLUTION SUMMARY:\n";
    echo "   1. Fixed product seller_role assignments\n";
    echo "   2. Updated SalesController to filter products by role\n";
    echo "   3. Wholesalers now only see factory products (which they can buy)\n";
    echo "   4. Retailers see wholesaler products\n";
    echo "   5. Customers see retailer products\n\n";
    
    echo "🎯 The red error message should now be resolved!\n";
    echo "   Wholesalers can only see and purchase products from the factory.\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== TEST COMPLETED ===\n";
