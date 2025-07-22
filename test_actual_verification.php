<?php

// Test actual verification of a wholesaler order
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

echo "=== Testing Actual Order Verification ===\n\n";

// Find the first pending wholesaler order
$order = Order::with(['user', 'product'])
    ->where('status', 'pending')
    ->whereHas('user', function($query) {
        $query->where('role', 'wholesaler')
              ->orWhere('role_as', 5);
    })
    ->first();

if (!$order) {
    echo "No pending wholesaler orders found!\n";
    exit;
}

echo "Order to verify:\n";
echo "- Order ID: {$order->id}\n";
echo "- Product: {$order->product->name}\n";
echo "- Quantity: {$order->quantity}\n";
echo "- User: {$order->user->name}\n";
echo "- Current Status: {$order->status}\n\n";

// Check inventory before
$inventory = $order->product->inventories()->first();
echo "Inventory before verification: {$inventory->quantity} units\n\n";

// Simulate admin login for verification
$admin = User::where('role', 'admin')->first();
if ($admin) {
    Auth::login($admin);
    echo "Logged in as admin: {$admin->name}\n\n";
    
    try {
        // Call the verification method directly
        $controller = new App\Http\Controllers\SalesApprovalController();
        
        // Simulate request data
        request()->merge([
            'delivery_status' => 'dispatched',
            'tracking_code' => 'TEST-' . $order->id,
            'dispatch_log' => 'Test verification from debug script'
        ]);
        
        echo "Calling verification method...\n";
        $result = $controller->verify($order->id);
        
        // Check the result
        $order->refresh();
        $inventory->refresh();
        
        echo "Verification completed!\n";
        echo "- New order status: {$order->status}\n";
        echo "- New inventory quantity: {$inventory->quantity}\n";
        echo "- Product seller_role: {$order->product->seller_role}\n";
        
        if ($order->status === 'approved') {
            echo "✓ SUCCESS: Order verified successfully!\n";
        } else {
            echo "✗ FAILED: Order not approved\n";
        }
        
    } catch (Exception $e) {
        echo "ERROR during verification: " . $e->getMessage() . "\n";
    }
    
} else {
    echo "No admin user found!\n";
}

echo "\n=== Test Complete ===\n";
