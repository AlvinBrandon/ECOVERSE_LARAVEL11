<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Order;
use App\Services\EcoPointService;

echo "=== Eco Points Award System ===\n";

// Initialize the eco points service
$ecoPointService = new EcoPointService();

// Find users with orders but no eco points
$usersWithOrders = User::whereHas('orders')
    ->where('eco_points', 0)
    ->with('orders')
    ->get();

echo "Found " . $usersWithOrders->count() . " users with orders but no eco points.\n\n";

foreach ($usersWithOrders as $user) {
    echo "Processing user: {$user->name} (ID: {$user->id})\n";
    
    // Get their approved/completed orders
    $approvedOrders = $user->orders()->where('status', 'approved')->get();
    
    echo "  - Found {$approvedOrders->count()} approved orders\n";
    
    foreach ($approvedOrders as $order) {
        try {
            // Check if points were already awarded for this order
            $existingTransaction = \App\Models\EcoPointTransaction::where('user_id', $user->id)
                ->where('source', 'order')
                ->whereJsonContains('metadata->order_id', $order->id)
                ->first();
                
            if (!$existingTransaction) {
                $ecoPointService->awardOrderPoints($order);
                echo "  - Awarded eco points for order #{$order->id} (\${$order->total_price})\n";
            } else {
                echo "  - Order #{$order->id} already has eco points awarded\n";
            }
        } catch (Exception $e) {
            echo "  - Error awarding points for order #{$order->id}: " . $e->getMessage() . "\n";
        }
    }
    
    // Refresh user to get updated points
    $user->refresh();
    echo "  - Total eco points now: {$user->eco_points}\n\n";
}

// Also award profile completion points to users who haven't received them
echo "=== Awarding Profile Completion Points ===\n";
$usersForProfileBonus = User::whereNotNull('phone')
    ->whereNotNull('location')
    ->get();

foreach ($usersForProfileBonus as $user) {
    try {
        $ecoPointService->awardProfileCompletionPoints($user);
        echo "Awarded profile completion points to {$user->name}\n";
    } catch (Exception $e) {
        echo "Profile completion points already awarded to {$user->name}\n";
    }
}

echo "\n=== Summary ===\n";
$totalUsers = User::where('eco_points', '>', 0)->count();
$totalPoints = User::sum('eco_points');
echo "Total users with eco points: {$totalUsers}\n";
echo "Total eco points distributed: {$totalPoints}\n";

echo "\nEco points system is now active! 🌱\n";
