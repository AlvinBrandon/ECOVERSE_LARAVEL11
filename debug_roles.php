<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "=== ROLE AND PRODUCT DEBUG ===\n\n";

try {
    // Check products and their seller_role
    $products = \App\Models\Product::select('id', 'name', 'seller_role')->take(10)->get();
    echo "📦 PRODUCTS AND THEIR SELLER ROLES:\n";
    foreach ($products as $product) {
        echo "   - ID {$product->id}: {$product->name} (seller_role: " . ($product->seller_role ?? 'NULL') . ")\n";
    }
    
    // Check users and their roles
    echo "\n👥 USERS AND THEIR ROLES:\n";
    $users = \App\Models\User::select('id', 'name', 'email', 'role', 'role_as')->take(10)->get();
    foreach ($users as $user) {
        echo "   - ID {$user->id}: {$user->name} ({$user->email}) - role: {$user->role}, role_as: {$user->role_as}\n";
    }
    
    // Check if there's a user ID 10 (brandon/wholesaler)
    $brandon = \App\Models\User::find(10);
    if ($brandon) {
        echo "\n🔍 USER ID 10 (Brandon):\n";
        echo "   - Name: {$brandon->name}\n";
        echo "   - Email: {$brandon->email}\n";
        echo "   - Role: {$brandon->role}\n";
        echo "   - Role_as: {$brandon->role_as}\n";
    }
    
    echo "\n=== BUSINESS LOGIC ANALYSIS ===\n";
    echo "The error 'Wholesalers can only sell to retailers' occurs when:\n";
    echo "1. User role = 'wholesaler' (buyer role)\n";
    echo "2. Product seller_role = 'wholesaler' (seller role)\n";
    echo "3. But the logic expects: wholesaler (seller) → retailer (buyer)\n\n";
    
    echo "SOLUTION: Wholesalers should buy from products with seller_role='factory' or NULL\n";
    echo "Products with seller_role='wholesaler' should only be visible to retailers.\n\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "=== DEBUG COMPLETED ===\n";
