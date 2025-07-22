<?php
// Test retailer dashboard metrics after customer order approval

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Testing retailer dashboard metrics...\n\n";

// Before approval - check pending customer orders for retailer products
$pendingBefore = \App\Models\Order::where('status', 'pending')
    ->whereHas('user', function($query) {
        $query->where('role', 'customer')
              ->orWhere('role_as', 0);
    })
    ->whereHas('product', function($query) {
        $query->where('seller_role', 'retailer');
    })
    ->count();

$approvedBefore = \App\Models\Order::where('status', 'approved')
    ->whereHas('user', function($query) {
        $query->where('role', 'customer')
              ->orWhere('role_as', 0);
    })
    ->whereHas('product', function($query) {
        $query->where('seller_role', 'retailer');
    })
    ->count();

echo "BEFORE approval:\n";
echo "- Pending customer orders for retailers: $pendingBefore\n";
echo "- Approved customer orders for retailers: $approvedBefore\n\n";

// Find a pending customer order for a retailer product to approve
$testOrder = \App\Models\Order::where('status', 'pending')
    ->whereHas('user', function($query) {
        $query->where('role', 'customer')
              ->orWhere('role_as', 0);
    })
    ->whereHas('product', function($query) {
        $query->where('seller_role', 'retailer');
    })
    ->first();

if ($testOrder) {
    echo "Found test order #$testOrder->id to approve...\n";
    echo "- User: " . ($testOrder->user->role ?? 'role_as:' . $testOrder->user->role_as) . "\n";
    echo "- Product seller: " . $testOrder->product->seller_role . "\n";
    echo "- Current status: $testOrder->status\n\n";
    
    // Simulate approval (what the RetailerCustomerOrderController::verify would do)
    $testOrder->status = 'approved';
    $testOrder->save();
    
    echo "Order approved!\n\n";
} else {
    echo "No pending customer orders for retailer products found to test with.\n";
    
    // Check what orders exist
    $allOrders = \App\Models\Order::with(['user', 'product'])->get();
    echo "All orders in system:\n";
    foreach($allOrders as $order) {
        $userRole = $order->user ? ($order->user->role ?? 'role_as:' . $order->user->role_as) : 'no user';
        $productSeller = $order->product ? $order->product->seller_role : 'no product';
        echo "- Order #$order->id: $userRole buying from $productSeller [$order->status]\n";
    }
    echo "\n";
}

// After approval - check metrics again
$pendingAfter = \App\Models\Order::where('status', 'pending')
    ->whereHas('user', function($query) {
        $query->where('role', 'customer')
              ->orWhere('role_as', 0);
    })
    ->whereHas('product', function($query) {
        $query->where('seller_role', 'retailer');
    })
    ->count();

$approvedAfter = \App\Models\Order::where('status', 'approved')
    ->whereHas('user', function($query) {
        $query->where('role', 'customer')
              ->orWhere('role_as', 0);
    })
    ->whereHas('product', function($query) {
        $query->where('seller_role', 'retailer');
    })
    ->count();

$revenueToday = \App\Models\Order::whereDate('created_at', today())
    ->where('status', 'approved')
    ->whereHas('user', function($query) {
        $query->where('role', 'customer')
              ->orWhere('role_as', 0);
    })
    ->whereHas('product', function($query) {
        $query->where('seller_role', 'retailer');
    })
    ->sum('total_price');

echo "AFTER approval:\n";
echo "- Pending customer orders for retailers: $pendingAfter\n";
echo "- Approved customer orders for retailers: $approvedAfter\n";
echo "- Revenue today from customer orders: UGX " . number_format($revenueToday) . "\n\n";

echo "Changes:\n";
echo "- Pending: $pendingBefore → $pendingAfter (" . ($pendingAfter - $pendingBefore) . ")\n";
echo "- Approved: $approvedBefore → $approvedAfter (" . ($approvedAfter - $approvedBefore) . ")\n";

echo "\nRetailer dashboard should now show these updated values!\n";
