<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$orders = \App\Models\Order::where('user_id', 12)->get();

echo "Testing new order categorization logic:\n";
echo "Total orders found: " . $orders->count() . "\n\n";

$completedOrders = 0; 
$pendingOrders = 0;
$processingOrders = 0;

foreach($orders as $order) {
    $status = strtolower(trim($order->status));
    echo "Order ID: {$order->id}, Status: '{$order->status}' (normalized: '{$status}')\n";
    
    // Count completed orders (delivered orders)
    if (in_array($status, ['delivered', 'completed'])) {
        $completedOrders++;
        echo "  -> Counts as COMPLETED\n";
    }
    
    // Count pending orders (unverified orders)
    if (in_array($status, ['unverified', 'pending'])) {
        $pendingOrders++;
        echo "  -> Counts as PENDING\n";
    }
    
    // Count processing orders (dispatched, approved, processing, shipped)
    if (in_array($status, ['dispatched', 'approved', 'processing', 'shipped', 'shipping', 'confirmed'])) {
        $processingOrders++;
        echo "  -> Counts as PROCESSING\n";
    }
}

echo "\nFinal counts:\n";
echo "Completed Orders: {$completedOrders}\n";
echo "Pending Orders: {$pendingOrders}\n";
echo "Processing Orders: {$processingOrders}\n";
