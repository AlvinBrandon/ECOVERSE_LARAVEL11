<?php

// Test admin verification process for a specific order
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

echo "=== Testing Admin Verification Process ===\n\n";

// Find a pending wholesaler order
$pendingOrder = Order::with(['user', 'product'])
    ->where('status', 'pending')
    ->whereHas('user', function($query) {
        $query->where('role', 'wholesaler')
              ->orWhere('role_as', 5);
    })
    ->first();

if (!$pendingOrder) {
    echo "No pending wholesaler orders found to test!\n";
    exit;
}

echo "Testing with Order #{$pendingOrder->id}:\n";
echo "- Product: {$pendingOrder->product->name}\n";
echo "- Quantity: {$pendingOrder->quantity}\n";
echo "- User: {$pendingOrder->user->name} (role: {$pendingOrder->user->role})\n";
echo "- Current Status: {$pendingOrder->status}\n\n";

// Check current inventory
$product = $pendingOrder->product;
$inventory = $product->inventories()->first();

if ($inventory) {
    echo "Current inventory: {$inventory->quantity} units\n";
    echo "Required quantity: {$pendingOrder->quantity} units\n";
    
    if ($inventory->quantity >= $pendingOrder->quantity) {
        echo "✓ Sufficient stock available\n\n";
        
        // Simulate the verification process
        echo "Simulating verification process...\n";
        
        // Calculate what would happen
        $newQuantity = $inventory->quantity - $pendingOrder->quantity;
        echo "Inventory would be reduced to: {$newQuantity} units\n";
        echo "Product seller_role would be set to: wholesaler\n";
        echo "Order status would be set to: approved\n\n";
        
        echo "The verification should work successfully!\n";
        echo "If it's not working, there might be a frontend/form submission issue.\n";
        
    } else {
        echo "✗ INSUFFICIENT STOCK!\n";
        echo "This order would fail verification due to insufficient inventory.\n";
        echo "The admin verification page should show an error message.\n\n";
    }
} else {
    echo "✗ NO INVENTORY RECORD FOUND!\n";
    echo "This would cause the verification to fail.\n";
    echo "The controller would try to create a new inventory with 0 quantity.\n\n";
}

// Check if there are any other issues
echo "Checking for potential issues:\n";

// Check if user role is properly set
if ($pendingOrder->user->role === 'wholesaler' || $pendingOrder->user->role_as == 5) {
    echo "✓ User role is correctly identified as wholesaler\n";
} else {
    echo "✗ User role issue - not properly identified as wholesaler\n";
}

// Check if product exists
if ($pendingOrder->product) {
    echo "✓ Product exists and is accessible\n";
} else {
    echo "✗ Product not found or not accessible\n";
}

echo "\n=== End Test ===\n";
