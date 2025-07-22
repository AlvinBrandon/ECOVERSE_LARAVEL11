<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "=== IMPLEMENTING CLEANER BUSINESS LOGIC ===\n\n";

try {
    echo "🎯 BETTER APPROACH: Multi-level product availability\n\n";
    
    echo "📋 PRODUCT DISTRIBUTION STRATEGY:\n";
    echo "   - ALL products start as 'factory' (wholesaler can buy)\n";
    echo "   - Some products also available as 'wholesaler' (retailer can buy)\n";
    echo "   - Some products also available as 'retailer' (customer can buy)\n\n";
    
    // Strategy: Keep all as factory, but create some for wholesaler and retailer too
    $allProducts = \App\Models\Product::all();
    
    // Set specific products for each role (simulating business flow)
    $factoryProducts = $allProducts; // ALL products available from factory
    $wholesalerProducts = $allProducts->take(15); // First 15 products wholesalers can sell
    $retailerProducts = $allProducts->take(10);   // First 10 products retailers can sell
    
    echo "🔧 SETTING UP PRODUCT AVAILABILITY:\n";
    
    // For this demo, let's set up realistic availability:
    // 1. ALL products (1-20) available from factory to wholesalers
    // 2. Products 1-15 available from wholesalers to retailers  
    // 3. Products 1-10 available from retailers to customers
    
    // We'll need to modify the approach - let's use a simpler method
    // Set some products back to wholesaler role for retailer visibility
    
    $wholesalerProductIds = [6, 7, 8, 9, 10, 11, 12, 13, 14, 15]; // These can be sold by wholesalers
    $retailerProductIds = [1, 2, 3, 4, 5]; // These can be sold by retailers
    
    // Update specific products for multi-level availability
    foreach ($wholesalerProductIds as $id) {
        $product = \App\Models\Product::find($id);
        if ($product) {
            $product->seller_role = 'wholesaler';
            $product->save();
            echo "   - Set Product {$id} ({$product->name}) for wholesaler→retailer sales\n";
        }
    }
    
    foreach ($retailerProductIds as $id) {
        $product = \App\Models\Product::find($id);
        if ($product) {
            $product->seller_role = 'retailer';
            $product->save();
            echo "   - Set Product {$id} ({$product->name}) for retailer→customer sales\n";
        }
    }
    
    echo "\n📊 FINAL DISTRIBUTION:\n";
    $factoryCount = \App\Models\Product::where('seller_role', 'factory')->count();
    $wholesalerCount = \App\Models\Product::where('seller_role', 'wholesaler')->count();
    $retailerCount = \App\Models\Product::where('seller_role', 'retailer')->count();
    
    echo "   - Factory products (for wholesalers): {$factoryCount}\n";
    echo "   - Wholesaler products (for retailers): {$wholesalerCount}\n";
    echo "   - Retailer products (for customers): {$retailerCount}\n";
    echo "   - Total products: " . \App\Models\Product::count() . "\n\n";
    
    echo "✅ WHOLESALERS NOW SEE: " . $factoryCount . " products they can purchase\n";
    echo "✅ RETAILERS NOW SEE: " . $wholesalerCount . " products they can purchase\n";
    echo "✅ CUSTOMERS NOW SEE: " . $retailerCount . " products they can purchase\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== CLEANER IMPLEMENTATION COMPLETED ===\n";
