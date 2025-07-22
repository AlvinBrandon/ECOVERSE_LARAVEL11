<?php

// Test the fixed verification process for Paperboard cartons
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

echo "=== Testing Fixed Paperboard Cartons Verification ===\n\n";

// Find the paperboard cartons order
$order = Order::with(['user', 'product'])
    ->where('product_id', 3) // Paperboard cartons ID
    ->where('quantity', 607)
    ->where('status', 'pending')
    ->first();

if (!$order) {
    echo "Paperboard cartons order (607 units) not found!\n";
    exit;
}

echo "Order to test:\n";
echo "- Order ID: {$order->id}\n";
echo "- Product: {$order->product->name}\n";
echo "- Quantity: {$order->quantity}\n";
echo "- User: {$order->user->name}\n\n";

// Check total inventory before verification
$totalStock = $order->product->inventories()->sum('quantity');
echo "Total inventory before verification: {$totalStock} units\n\n";

// Get individual inventory records
$inventories = $order->product->inventories()->get();
echo "Individual inventory records:\n";
foreach ($inventories as $inv) {
    echo "- Inventory #{$inv->id}: {$inv->quantity} units (batch: {$inv->batch_id})\n";
}
echo "\n";

// Simulate admin login
$admin = User::where('role', 'admin')->first();
Auth::login($admin);

try {
    // Test the verification
    $controller = new App\Http\Controllers\SalesApprovalController();
    
    // Simulate request data
    request()->merge([
        'delivery_status' => 'dispatched',
        'tracking_code' => 'TEST-FIXED-' . $order->id,
        'dispatch_log' => 'Testing fixed inventory calculation'
    ]);
    
    echo "Calling verification method with fixed logic...\n";
    $result = $controller->verify($order->id);
    
    // Check the result
    $order->refresh();
    $newTotalStock = $order->product->inventories()->sum('quantity');
    
    echo "Verification completed!\n";
    echo "- Order status: {$order->status}\n";
    echo "- Total inventory after: {$newTotalStock} units\n";
    echo "- Stock deducted: " . ($totalStock - $newTotalStock) . " units\n\n";
    
    if ($order->status === 'approved') {
        echo "✓ SUCCESS: Order verified successfully!\n";
        echo "The inventory calculation fix is working correctly.\n";
        
        // Show updated inventory breakdown
        $inventories = $order->product->inventories()->get();
        echo "\nUpdated inventory records:\n";
        foreach ($inventories as $inv) {
            echo "- Inventory #{$inv->id}: {$inv->quantity} units (batch: {$inv->batch_id})\n";
        }
    } else {
        echo "✗ FAILED: Order not approved\n";
    }
    
} catch (Exception $e) {
    echo "ERROR during verification: " . $e->getMessage() . "\n";
}

echo "\n=== Test Complete ===\n";
