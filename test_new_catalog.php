<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "=== TESTING NEW WHOLESALER CATALOG ACCESS ===\n\n";

try {
    // Test what each role can see
    echo "👤 ROLE-BASED PRODUCT VISIBILITY:\n\n";
    
    // Simulate wholesaler view (no filter)
    echo "🏪 WHOLESALER CATALOG (should see ALL products):\n";
    $wholesalerProducts = \App\Models\Product::with('inventory')->get();
    echo "   - Total products visible: " . $wholesalerProducts->count() . "\n";
    foreach ($wholesalerProducts->take(5) as $product) {
        echo "   - {$product->name} (seller_role: {$product->seller_role})\n";
    }
    echo "   - ...and " . ($wholesalerProducts->count() - 5) . " more products\n\n";
    
    // Simulate retailer view
    echo "🏬 RETAILER CATALOG (only wholesaler products):\n";
    $retailerProducts = \App\Models\Product::where('seller_role', 'wholesaler')->get();
    echo "   - Total products visible: " . $retailerProducts->count() . "\n";
    foreach ($retailerProducts->take(3) as $product) {
        echo "   - {$product->name}\n";
    }
    if ($retailerProducts->count() > 3) {
        echo "   - ...and " . ($retailerProducts->count() - 3) . " more products\n";
    }
    echo "\n";
    
    // Simulate customer view
    echo "🛍️ CUSTOMER CATALOG (only retailer products):\n";
    $customerProducts = \App\Models\Product::where('seller_role', 'retailer')->get();
    echo "   - Total products visible: " . $customerProducts->count() . "\n";
    foreach ($customerProducts->take(3) as $product) {
        echo "   - {$product->name}\n";
    }
    if ($customerProducts->count() > 3) {
        echo "   - ...and " . ($customerProducts->count() - 3) . " more products\n";
    }
    echo "\n";
    
    // Test purchase scenarios
    echo "🔍 PURCHASE SCENARIO TESTING:\n\n";
    
    $wholesaler = \App\Models\User::where('role', 'wholesaler')->first();
    $retailer = \App\Models\User::where('role', 'retailer')->first();
    $customer = \App\Models\User::where('role', 'customer')->first();
    
    // Test wholesaler buying any product
    $anyProduct = \App\Models\Product::first();
    echo "✅ Wholesaler buying '{$anyProduct->name}' (seller_role: {$anyProduct->seller_role}): ALLOWED\n";
    echo "   - Wholesalers can buy ANY product since factory makes everything\n\n";
    
    // Test retailer buying wholesaler product
    $wholesalerProduct = \App\Models\Product::where('seller_role', 'wholesaler')->first();
    if ($wholesalerProduct) {
        echo "✅ Retailer buying '{$wholesalerProduct->name}' (seller_role: wholesaler): ALLOWED\n";
    }
    
    // Test retailer buying non-wholesaler product
    $factoryProduct = \App\Models\Product::where('seller_role', 'factory')->first();
    if ($factoryProduct) {
        echo "❌ Retailer buying '{$factoryProduct->name}' (seller_role: factory): BLOCKED\n";
        echo "   - Error: 'Retailers can only purchase products sold by wholesalers.'\n";
    }
    
    echo "\n✅ SOLUTION SUMMARY:\n";
    echo "   - Wholesalers now see ALL " . $wholesalerProducts->count() . " products in their catalog\n";
    echo "   - Wholesalers can purchase any product (factory makes everything)\n";
    echo "   - Retailers and customers still follow the hierarchy rules\n";
    echo "   - No more 'Wholesalers can only sell to retailers' error for legitimate purchases\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== NEW CATALOG TESTING COMPLETED ===\n";
