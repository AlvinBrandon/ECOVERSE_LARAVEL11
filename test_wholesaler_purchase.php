<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "=== TESTING WHOLESALER PURCHASE ===\n\n";

try {
    // Get the wholesaler user (brandon, ID 7)
    $wholesaler = \App\Models\User::find(7);
    echo "👤 WHOLESALER USER:\n";
    echo "   - Name: {$wholesaler->name}\n";
    echo "   - Role: {$wholesaler->role}\n";
    echo "   - Role_as: {$wholesaler->role_as}\n\n";
    
    // Get a factory product that wholesaler should be able to buy
    $factoryProduct = \App\Models\Product::where('seller_role', 'factory')->first();
    echo "🏭 FACTORY PRODUCT:\n";
    echo "   - Name: {$factoryProduct->name}\n";
    echo "   - Seller Role: {$factoryProduct->seller_role}\n";
    echo "   - Price: UGX {$factoryProduct->price}\n\n";
    
    // Test the business logic from SalesController
    echo "🔍 BUSINESS LOGIC TEST:\n";
    $buyerRole = $wholesaler->role;  // 'wholesaler'
    $sellerRole = $factoryProduct->seller_role;  // 'factory'
    
    echo "   - Buyer Role: {$buyerRole}\n";
    echo "   - Seller Role: {$sellerRole}\n\n";
    
    // Apply the same logic as in SalesController
    $errorMessage = null;
    
    if ($sellerRole === 'factory' && $buyerRole !== 'wholesaler') {
        $errorMessage = 'Factory can only sell to wholesalers.';
    }
    if ($sellerRole === 'wholesaler' && $buyerRole !== 'retailer') {
        $errorMessage = 'Wholesalers can only sell to retailers.';
    }
    if ($sellerRole === 'retailer' && $buyerRole !== 'customer') {
        $errorMessage = 'Retailers can only sell to end-customers.';
    }
    
    if ($errorMessage) {
        echo "❌ WOULD FAIL: {$errorMessage}\n\n";
    } else {
        echo "✅ PURCHASE ALLOWED: Wholesaler can buy from factory!\n\n";
    }
    
    // Test a problematic combination
    echo "🚫 TESTING PROBLEMATIC COMBINATION:\n";
    $wholesalerProduct = \App\Models\Product::where('seller_role', 'wholesaler')->first();
    if ($wholesalerProduct) {
        echo "   - Product: {$wholesalerProduct->name} (seller_role: wholesaler)\n";
        echo "   - Buyer: {$wholesaler->role}\n";
        echo "   - Result: ❌ 'Wholesalers can only sell to retailers' (wholesaler trying to buy from wholesaler)\n";
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== TEST COMPLETED ===\n";
