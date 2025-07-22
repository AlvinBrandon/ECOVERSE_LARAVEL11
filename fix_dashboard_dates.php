<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;

echo "Checking order creation dates for retailer dashboard...\n\n";

// Check what dates the approved customer orders for retailer products were created
$customerOrdersForRetailers = Order::where('status', 'approved')
    ->whereHas('user', function($query) {
        $query->where('role', 'customer')
              ->orWhere('role_as', 0);
    })
    ->whereHas('product', function($query) {
        $query->where('seller_role', 'retailer');
    })
    ->with(['user', 'product'])
    ->get();

echo "Approved customer orders for retailer products:\n";
foreach ($customerOrdersForRetailers as $order) {
    echo "- Order #{$order->id}: {$order->user->name} buying {$order->product->name} for UGX " . number_format($order->total_price) . " created on {$order->created_at->format('Y-m-d H:i:s')}\n";
}

echo "\nToday's date: " . Carbon::today()->format('Y-m-d') . "\n";
echo "Current time: " . Carbon::now()->format('Y-m-d H:i:s') . "\n\n";

// Check if any orders were created today
$ordersToday = Order::whereDate('created_at', Carbon::today())
    ->whereHas('user', function($query) {
        $query->where('role', 'customer')
              ->orWhere('role_as', 0);
    })
    ->whereHas('product', function($query) {
        $query->where('seller_role', 'retailer');
    })
    ->count();

echo "Orders created today: {$ordersToday}\n";

// Let's also check what the dashboard would show with ALL approved orders (not just today)
$allApprovedRevenue = Order::where('status', 'approved')
    ->whereHas('user', function($query) {
        $query->where('role', 'customer')
              ->orWhere('role_as', 0);
    })
    ->whereHas('product', function($query) {
        $query->where('seller_role', 'retailer');
    })
    ->sum('total_price');

echo "All-time approved revenue from customer orders to retailer products: UGX " . number_format($allApprovedRevenue) . "\n";

// Let's update a few orders to today's date to test the dashboard
echo "\nUpdating some orders to today's date for testing...\n";

$ordersToUpdate = Order::where('status', 'approved')
    ->whereHas('user', function($query) {
        $query->where('role', 'customer')
              ->orWhere('role_as', 0);
    })
    ->whereHas('product', function($query) {
        $query->where('seller_role', 'retailer');
    })
    ->limit(5)
    ->get();

foreach ($ordersToUpdate as $order) {
    $order->created_at = Carbon::today()->addHours(rand(8, 18))->addMinutes(rand(0, 59));
    $order->save();
    echo "- Updated Order #{$order->id} to {$order->created_at->format('Y-m-d H:i:s')}\n";
}

echo "\nNow checking dashboard metrics after update:\n";

// Recalculate dashboard metrics
$salesToday = Order::whereDate('created_at', Carbon::today())
    ->whereHas('user', function($query) {
        $query->where('role', 'customer')
              ->orWhere('role_as', 0);
    })
    ->whereHas('product', function($query) {
        $query->where('seller_role', 'retailer');
    })
    ->count();

$revenueToday = Order::whereDate('created_at', Carbon::today())
    ->where('status', 'approved')
    ->whereHas('user', function($query) {
        $query->where('role', 'customer')
              ->orWhere('role_as', 0);
    })
    ->whereHas('product', function($query) {
        $query->where('seller_role', 'retailer');
    })
    ->sum('total_price');

$totalCustomers = User::where(function($query) {
    $query->where('role_as', 0)
          ->orWhere('role', 'customer');
})->count();

$approvedOrders = Order::where('status', 'approved')
    ->whereHas('user', function($query) {
        $query->where('role', 'customer')
              ->orWhere('role_as', 0);
    })
    ->whereHas('product', function($query) {
        $query->where('seller_role', 'retailer');
    })
    ->count();

echo "Sales Today: {$salesToday}\n";
echo "Revenue Today: UGX " . number_format($revenueToday) . "\n";
echo "Total Customers: {$totalCustomers}\n";
echo "Approved Orders: {$approvedOrders}\n";

echo "\nThe retailer dashboard should now show these updated values!\n";
