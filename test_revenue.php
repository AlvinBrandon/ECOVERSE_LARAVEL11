<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing revenue calculation...\n";

// Test the approved orders revenue calculation
$totalRevenue = Order::join('users', 'orders.user_id', '=', 'users.id')
    ->join('products', 'orders.product_id', '=', 'products.id')
    ->where(function($q) {
        $q->where('users.role', 'retailer')
          ->orWhere('users.role_as', 2);
    })
    ->where('orders.status', 'approved')
    ->sum('orders.total_price');

echo "Total Revenue from approved orders: UGX " . number_format($totalRevenue) . "\n";

// Show count of approved orders
$approvedCount = Order::join('users', 'orders.user_id', '=', 'users.id')
    ->join('products', 'orders.product_id', '=', 'products.id')
    ->where(function($q) {
        $q->where('users.role', 'retailer')
          ->orWhere('users.role_as', 2);
    })
    ->where('orders.status', 'approved')
    ->count();

echo "Number of approved orders: " . $approvedCount . "\n";

// Show some sample approved orders
$sampleOrders = Order::join('users', 'orders.user_id', '=', 'users.id')
    ->join('products', 'orders.product_id', '=', 'products.id')
    ->where(function($q) {
        $q->where('users.role', 'retailer')
          ->orWhere('users.role_as', 2);
    })
    ->where('orders.status', 'approved')
    ->select('orders.id', 'orders.total_price', 'users.name', 'products.name as product_name')
    ->limit(5)
    ->get();

echo "\nSample approved orders:\n";
foreach ($sampleOrders as $order) {
    echo "Order #{$order->id}: {$order->name} - {$order->product_name} - UGX " . number_format($order->total_price) . "\n";
}
