<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

echo "Testing Wholesaler Dashboard Method Directly:\n";
echo "=============================================\n";

// Simulate being logged in as wholesaler (user ID 7 - brandon)
$wholesaler = User::find(7);
if (!$wholesaler) {
    echo "Wholesaler user not found!\n";
    exit;
}

echo "Wholesaler found: {$wholesaler->name} (ID: {$wholesaler->id}, Role: {$wholesaler->role}, Role_as: {$wholesaler->role_as})\n\n";

// Manually set the authenticated user
Auth::login($wholesaler);

echo "Calculating metrics manually:\n";

try {
    // Calculate bulk orders (orders from retailers)
    $bulkOrders = Order::join('users', 'orders.user_id', '=', 'users.id')
        ->where(function($q) {
            $q->where('users.role', 'retailer')
              ->orWhere('users.role_as', 2);
        })
        ->count();
    echo "✓ Bulk Orders: {$bulkOrders}\n";
    
    // Calculate active retailers
    $activeRetailers = Order::join('users', 'orders.user_id', '=', 'users.id')
        ->where(function($q) {
            $q->where('users.role', 'retailer')
              ->orWhere('users.role_as', 2);
        })
        ->distinct('orders.user_id')
        ->count('orders.user_id');
    echo "✓ Active Retailers: {$activeRetailers}\n";
    
    // Calculate pending verifications
    $pendingVerifications = Order::join('users', 'orders.user_id', '=', 'users.id')
        ->where(function($q) {
            $q->where('users.role', 'retailer')
              ->orWhere('users.role_as', 2);
        })
        ->where('orders.status', 'pending')
        ->count();
    echo "✓ Pending Verifications: {$pendingVerifications}\n";
    
    // Calculate monthly revenue
    $monthlyRevenue = Order::join('users', 'orders.user_id', '=', 'users.id')
        ->where(function($q) {
            $q->where('users.role', 'retailer')
              ->orWhere('users.role_as', 2);
        })
        ->where('orders.status', 'approved')
        ->whereMonth('orders.created_at', now()->month)
        ->whereYear('orders.created_at', now()->year)
        ->sum('orders.total_price');
    echo "✓ Monthly Revenue: " . number_format($monthlyRevenue) . " UGX\n";
    
    echo "\nAll calculations completed successfully!\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

// Now test the actual DashboardController method
echo "\nTesting DashboardController method:\n";
echo "===================================\n";

try {
    $controller = new \App\Http\Controllers\DashboardController();
    
    // Use reflection to call the private method
    $reflection = new \ReflectionClass($controller);
    $method = $reflection->getMethod('wholesalerDashboard');
    $method->setAccessible(true);
    
    $result = $method->invoke($controller);
    echo "✓ DashboardController method executed successfully\n";
    echo "✓ Result type: " . get_class($result) . "\n";
    
} catch (\Exception $e) {
    echo "❌ DashboardController Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\nDone!\n";
