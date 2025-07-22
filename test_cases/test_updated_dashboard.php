<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Carbon\Carbon;

echo "Testing updated retailer dashboard metrics...\n\n";

// Test the updated dashboard logic (last 7 days instead of today only)
$salesToday = Order::where('created_at', '>=', now()->subDays(7))
    ->whereHas('user', function($query) {
        $query->where('role', 'customer')
              ->orWhere('role_as', 0);
    })
    ->whereHas('product', function($query) {
        $query->where('seller_role', 'retailer');
    })
    ->count();

$revenueToday = Order::where('created_at', '>=', now()->subDays(7))
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

$lowStockItems = Product::where('seller_role', 'retailer')
    ->whereHas('inventories', function($query) {
        $query->where('quantity', '<', 10);
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

echo "Updated Dashboard Metrics:\n";
echo "===========================\n";
echo "Recent Sales (7 days): {$salesToday}\n";
echo "Recent Revenue (7 days): UGX " . number_format($revenueToday) . "\n";
echo "Total Customers: {$totalCustomers}\n";
echo "Low Stock Items: {$lowStockItems}\n";
echo "Approved Orders: {$approvedOrders}\n\n";

echo "The retailer dashboard should now show these values instead of zeros!\n";
echo "Refresh your dashboard page to see the updated metrics.\n";
