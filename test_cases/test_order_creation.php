<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "=== TESTING ORDER CREATION FIX ===\n\n";

try {
    // Get a test user (wholesaler)
    $user = \App\Models\User::where('role', 'wholesaler')->first();
    if (!$user) {
        echo "❌ No wholesaler user found\n";
        exit;
    }
    
    // Get a test product
    $product = \App\Models\Product::first();
    if (!$product) {
        echo "❌ No products found\n";
        exit;
    }
    
    echo "👤 Test User: {$user->name} (role: {$user->role})\n";
    echo "📦 Test Product: {$product->name} (price: {$product->price})\n";
    echo "💰 Quantity: 1\n\n";
    
    $total_price = $product->price * 1;
    $order_number = 'TEST-' . now()->format('Ymd') . '-' . strtoupper(uniqid());
    
    echo "🔧 Attempting to create order without total_amount column...\n";
    
    $order = \App\Models\Order::create([
        'user_id' => $user->id,
        'product_id' => $product->id,
        'quantity' => 1,
        'unit_price' => $product->price,
        'total_price' => $total_price,
        'address' => 'Test Address',
        'status' => 'pending',
        'delivery_method' => 'pickup',
        'order_number' => $order_number,
    ]);
    
    echo "✅ SUCCESS! Order created with ID: {$order->id}\n";
    echo "   - Order Number: {$order->order_number}\n";
    echo "   - Total Price: {$order->total_price}\n";
    echo "   - Status: {$order->status}\n\n";
    
    echo "🎯 The database error has been fixed!\n";
    echo "   - Removed 'total_amount' from Order::create() call\n";
    echo "   - Removed 'total_amount' from Order model fillable array\n";
    echo "   - Using only 'total_price' column which exists in database\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== ORDER CREATION TEST COMPLETED ===\n";
