<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Order;
use App\Models\User;

echo "Testing Wholesaler Dashboard Metrics:\n";
echo "=====================================\n";

// Test 1: Get all retailer users
echo "1. All retailer users:\n";
$retailers = User::where('role', 'retailer')->orWhere('role_as', 2)->get();
foreach($retailers as $retailer) {
    echo "   - ID: {$retailer->id}, Name: {$retailer->name}, Role: {$retailer->role}, Role_as: {$retailer->role_as}\n";
}
echo "   Total retailers: " . $retailers->count() . "\n\n";

// Test 2: Get all orders from retailers
echo "2. All orders from retailers:\n";
$retailOrders = Order::join('users', 'orders.user_id', '=', 'users.id')
    ->where(function($q) {
        $q->where('users.role', 'retailer')
          ->orWhere('users.role_as', 2);
    })
    ->select('orders.*', 'users.name as user_name', 'users.role', 'users.role_as')
    ->get();

foreach($retailOrders as $order) {
    echo "   - Order #{$order->id}: User {$order->user_name} (role: {$order->role}, role_as: {$order->role_as}), Status: {$order->status}, Total: {$order->total_price}\n";
}
echo "   Total retail orders: " . $retailOrders->count() . "\n\n";

// Test 3: Calculate metrics
echo "3. Calculated metrics:\n";

$bulkOrders = Order::join('users', 'orders.user_id', '=', 'users.id')
    ->where(function($q) {
        $q->where('users.role', 'retailer')
          ->orWhere('users.role_as', 2);
    })
    ->count();
echo "   - Bulk Orders: {$bulkOrders}\n";

$activeRetailers = Order::join('users', 'orders.user_id', '=', 'users.id')
    ->where(function($q) {
        $q->where('users.role', 'retailer')
          ->orWhere('users.role_as', 2);
    })
    ->distinct('orders.user_id')
    ->count('orders.user_id');
echo "   - Active Retailers: {$activeRetailers}\n";

$pendingVerifications = Order::join('users', 'orders.user_id', '=', 'users.id')
    ->where(function($q) {
        $q->where('users.role', 'retailer')
          ->orWhere('users.role_as', 2);
    })
    ->where('orders.status', 'pending')
    ->count();
echo "   - Pending Verifications: {$pendingVerifications}\n";

$monthlyRevenue = Order::join('users', 'orders.user_id', '=', 'users.id')
    ->where(function($q) {
        $q->where('users.role', 'retailer')
          ->orWhere('users.role_as', 2);
    })
    ->where('orders.status', 'approved')
    ->whereMonth('orders.created_at', now()->month)
    ->whereYear('orders.created_at', now()->year)
    ->sum('orders.total_price');
echo "   - Monthly Revenue: " . number_format($monthlyRevenue) . " UGX\n";

echo "\nDone!\n";
