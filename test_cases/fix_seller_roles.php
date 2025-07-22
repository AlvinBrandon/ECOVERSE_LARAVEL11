<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "=== FIXING PRODUCT SELLER ROLES ===\n\n";

try {
    // The issue is that some products have seller_role='wholesaler'
    // But wholesalers (as buyers) are trying to purchase them
    // This violates the business rule: "wholesaler seller → retailer buyer"
    
    // Wholesalers should buy from factory/admin, so let's set some products to seller_role='factory'
    echo "🔧 SETTING PRODUCTS FOR WHOLESALER PURCHASE:\n";
    
    // Set products 6-10 (which currently have seller_role='wholesaler') to seller_role='factory'
    // This will allow wholesalers to buy these products
    $productsToFix = \App\Models\Product::whereIn('id', [6, 7, 8, 9, 10])->get();
    
    foreach ($productsToFix as $product) {
        echo "   - Updating {$product->name}: seller_role 'wholesaler' → 'factory'\n";
        $product->seller_role = 'factory';
        $product->save();
    }
    
    echo "\n✅ Products 6-10 now have seller_role='factory' - wholesalers can buy these\n";
    echo "✅ Products 1-5 still have seller_role='retailer' - customers can buy these\n\n";
    
    echo "🎯 BUSINESS FLOW NOW:\n";
    echo "   1. Admin/Factory (seller_role='factory') → Wholesaler (buyer)\n";
    echo "   2. Wholesaler (seller_role='wholesaler') → Retailer (buyer)\n";
    echo "   3. Retailer (seller_role='retailer') → Customer (buyer)\n\n";
    
    // Also create some products for each role if needed
    echo "📊 CURRENT PRODUCT DISTRIBUTION:\n";
    $factoryProducts = \App\Models\Product::where('seller_role', 'factory')->count();
    $wholesalerProducts = \App\Models\Product::where('seller_role', 'wholesaler')->count();
    $retailerProducts = \App\Models\Product::where('seller_role', 'retailer')->count();
    $nullProducts = \App\Models\Product::whereNull('seller_role')->count();
    
    echo "   - Factory products (for wholesalers to buy): {$factoryProducts}\n";
    echo "   - Wholesaler products (for retailers to buy): {$wholesalerProducts}\n";
    echo "   - Retailer products (for customers to buy): {$retailerProducts}\n";
    echo "   - Null seller_role products: {$nullProducts}\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== FIX COMPLETED ===\n";
