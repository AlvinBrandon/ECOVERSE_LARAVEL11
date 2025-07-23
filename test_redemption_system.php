<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\EcoReward;
use App\Services\EcoPointService;

echo "=== Eco Points Redemption System Test ===\n";

$ecoPointService = new EcoPointService();

// Get a user with lots of points
$user = User::where('eco_points', '>', 0)->orderBy('eco_points', 'desc')->first();

if (!$user) {
    echo "No users with eco points found.\n";
    exit;
}

echo "Testing with user: {$user->name}\n";
echo "Current eco points: {$user->eco_points}\n";
echo "Redeemable points: " . $ecoPointService->getRedeemablePoints($user) . "\n\n";

// Show available rewards
echo "=== Available Rewards ===\n";
$availableRewards = $ecoPointService->getAvailableRewards($user);

foreach ($availableRewards as $reward) {
    echo "- {$reward->name}: {$reward->points_required} points ({$reward->formatted_value})\n";
    echo "  Description: {$reward->description}\n\n";
}

// Show all rewards in system
echo "=== All Rewards in System ===\n";
$allRewards = EcoReward::all();
foreach ($allRewards as $reward) {
    $canAfford = $user->eco_points >= $reward->points_required ? "✅" : "❌";
    echo "{$canAfford} {$reward->name}: {$reward->points_required} points ({$reward->formatted_value})\n";
}

echo "\n=== Redemption Logic ===\n";
echo "Points become 'ready to redeem' when:\n";
echo "1. User has at least 100 points (minimum threshold)\n";
echo "2. There are available rewards they can afford\n";
echo "3. Rewards are active and in stock\n\n";

echo "Current status for {$user->name}:\n";
if ($user->eco_points >= 100) {
    echo "✅ Has minimum 100 points\n";
    echo "✅ Can redeem {$availableRewards->count()} different rewards\n";
    echo "💰 Points ready to redeem: " . $ecoPointService->getRedeemablePoints($user) . "\n";
} else {
    echo "❌ Needs " . (100 - $user->eco_points) . " more points to start redeeming\n";
}
