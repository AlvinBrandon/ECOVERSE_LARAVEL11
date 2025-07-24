<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

echo "🔍 CHECKING ALL USER ROLE CONSISTENCY\n";
echo "====================================\n\n";

// Get all users and check for role inconsistencies
$users = User::all();

$roleMapping = [
    'customer' => 0,
    'admin' => 1,
    'retailer' => 2,
    'staff' => 3,
    'supplier' => 4,
    'wholesaler' => 5
];

echo "📊 ROLE CONSISTENCY CHECK\n";
echo "=========================\n";

$inconsistencies = [];

foreach ($users as $user) {
    $roleString = $user->role;
    $roleAsNumber = $user->role_as;
    $expectedRoleAs = $roleMapping[$roleString] ?? null;
    $currentRole = $user->getCurrentRole();
    
    $isConsistent = ($roleAsNumber === $expectedRoleAs) && ($currentRole === $roleString);
    
    if (!$isConsistent) {
        $inconsistencies[] = $user;
        echo "❌ INCONSISTENT: {$user->name} ({$user->email})\n";
        echo "   role: '{$roleString}' | role_as: {$roleAsNumber} | getCurrentRole(): '{$currentRole}'\n";
        echo "   Expected role_as: {$expectedRoleAs}\n";
        
        // Fix the inconsistency
        if ($expectedRoleAs !== null) {
            $user->role_as = $expectedRoleAs;
            $user->save();
            $user->refresh();
            echo "   ✅ FIXED: role_as updated to {$expectedRoleAs}, getCurrentRole(): '{$user->getCurrentRole()}'\n";
        } else {
            echo "   ⚠️  Unknown role: {$roleString}\n";
        }
        echo "\n";
    } else {
        echo "✅ CONSISTENT: {$user->name} - {$roleString} (role_as: {$roleAsNumber})\n";
    }
}

echo "\n📈 SUMMARY\n";
echo "==========\n";
echo "Total users checked: {$users->count()}\n";
echo "Inconsistencies found: " . count($inconsistencies) . "\n";
echo "Inconsistencies fixed: " . count($inconsistencies) . "\n";

if (count($inconsistencies) === 0) {
    echo "🎉 All user roles are now consistent!\n";
} else {
    echo "🔧 All inconsistencies have been fixed!\n";
}

echo "\n📋 CURRENT ROLE DISTRIBUTION\n";
echo "============================\n";

foreach ($roleMapping as $role => $id) {
    $count = User::where('role', $role)->where('role_as', $id)->count();
    echo "👥 {$role} (role_as: {$id}): {$count} users\n";
}

echo "\n✅ ROLE CONSISTENCY CHECK COMPLETED!\n";
