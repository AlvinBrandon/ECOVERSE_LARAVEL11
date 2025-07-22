<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Order;

echo "=== Debugging Retailer Orders ===\n\n";

// Find retailer john
$retailer = User::where('name', 'john')->where('role', 'retailer')->first();

if (!$retailer) {
    echo "ERROR: Retailer 'john' not found!\n";
    exit;
}

echo "Found retailer: {$retailer->name} (ID: {$retailer->id})\n\n";

// Get all orders by this retailer
$orders = Order::where('user_id', $retailer->id)->with('product')->get();

echo "Total orders by retailer: {$orders->count()}\n\n";

if ($orders->isEmpty()) {
    echo "NO ORDERS FOUND! The retailer hasn't made any purchases yet.\n";
    echo "This is why the inventory shows 0 purchased quantities.\n\n";
    echo "To test the system, the retailer needs to:\n";
    echo "1. Browse products from wholesalers\n";
    echo "2. Add them to cart\n";
    echo "3. Place orders\n";
    echo "4. Have those orders approved\n";
    exit;
}

echo "All orders:\n";
echo "===========\n";
foreach ($orders as $order) {
    echo "Order #{$order->id}: {$order->quantity} x {$order->product->name}\n";
    echo "  Seller: {$order->product->seller_role}\n";
    echo "  Status: {$order->status}\n";
    echo "  Created: {$order->created_at}\n\n";
}

// Check specifically for wholesaler orders
$wholesalerOrders = $orders->filter(function($order) {
    return $order->product->seller_role === 'wholesaler';
});

echo "Wholesaler orders: {$wholesalerOrders->count()}\n";
echo "====================\n";

if ($wholesalerOrders->isEmpty()) {
    echo "NO ORDERS FROM WHOLESALERS!\n";
    echo "The retailer needs to purchase products from wholesalers to see inventory.\n";
} else {
    foreach ($wholesalerOrders as $order) {
        echo "Order #{$order->id}: {$order->quantity} x {$order->product->name} - {$order->status}\n";
    }
    
    // Check approved wholesaler orders
    $approvedWholesalerOrders = $wholesalerOrders->filter(function($order) {
        return $order->status === 'approved';
    });
    
    echo "\nApproved wholesaler orders: {$approvedWholesalerOrders->count()}\n";
    if ($approvedWholesalerOrders->isEmpty()) {
        echo "No approved wholesaler orders! Orders need to be approved to show in inventory.\n";
    }
}

echo "\n=== End Debug ===\n";
