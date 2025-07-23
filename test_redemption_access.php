<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\EcoReward;
use App\Services\EcoPointService;

echo "🧪 Testing Eco-Points Redemption System...\n\n";

// Test 1: Check if rewards exist
echo "1️⃣ Checking available rewards:\n";
$rewards = EcoReward::where('is_active', true)->get();
echo "   Found " . $rewards->count() . " active rewards\n";
foreach ($rewards as $reward) {
    echo "   - {$reward->name}: {$reward->points_required} points ({$reward->value})\n";
}
echo "\n";

// Test 2: Check user with most points
echo "2️⃣ Finding user with most eco-points:\n";
$topUser = User::orderBy('eco_points', 'desc')->first();
if ($topUser) {
    echo "   User: {$topUser->name}\n";
    echo "   Points: " . number_format($topUser->eco_points) . "\n";
    echo "   Redeemable: " . ($topUser->eco_points >= 100 ? number_format($topUser->eco_points) : 0) . "\n";
} else {
    echo "   No users found\n";
}
echo "\n";

// Test 3: Check redemption capability
echo "3️⃣ Testing redemption capability:\n";
if ($topUser && $rewards->count() > 0) {
    $cheapestReward = $rewards->sortBy('points_required')->first();
    
    echo "   User {$topUser->name} has " . number_format($topUser->eco_points) . " points\n";
    echo "   Cheapest reward: {$cheapestReward->name} ({$cheapestReward->points_required} points)\n";
    
    if ($topUser->eco_points >= $cheapestReward->points_required) {
        echo "   ✅ User CAN redeem this reward\n";
        
        // Test the redemption service
        $ecoPointService = new EcoPointService();
        try {
            echo "   📝 Testing redemption process...\n";
            $voucher = $ecoPointService->redeemReward($topUser, $cheapestReward);
            echo "   ✅ Redemption successful!\n";
            echo "   📄 Voucher code: {$voucher->voucher_code}\n";
            echo "   🎯 Status: {$voucher->status}\n";
            
            // Refresh user points
            $topUser->refresh();
            echo "   💰 Remaining points: " . number_format($topUser->eco_points) . "\n";
            
        } catch (Exception $e) {
            echo "   ❌ Redemption failed: " . $e->getMessage() . "\n";
        }
    } else {
        echo "   ❌ User cannot redeem (insufficient points)\n";
    }
} else {
    echo "   ❌ Cannot test redemption (no users or rewards)\n";
}
echo "\n";

// Test 4: Redemption system URLs
echo "4️⃣ Available redemption URLs:\n";
echo "   🏪 Rewards Catalog: /eco-points/rewards\n";
echo "   📚 Redemption History: /eco-points/history\n";
echo "   💰 Points Balance API: /eco-points/balance\n";
echo "   🎫 Voucher Details: /eco-points/voucher/{code}\n";
echo "\n";

echo "✅ Redemption system test completed!\n";
echo "\n🎯 SUMMARY: How to Access Redemption System:\n";
echo "1. Profile Page → Click 'Eco Points' card → 'Browse Rewards' button\n";
echo "2. Direct URL: /eco-points/rewards\n";
echo "3. Profile Page → Quick Actions → 'Redeem Points' button\n";
echo "4. API endpoint: /eco-points/balance for current points\n";
