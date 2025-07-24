<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

echo "🔍 CHECKING TERRACOTTA USER ROLE\n";
echo "================================\n\n";

// Find terracotta user
$terracotta = User::where('name', 'terracotta')
    ->orWhere('email', 'LIKE', '%terracotta%')
    ->first();

if ($terracotta) {
    echo "Found user: {$terracotta->name}\n";
    echo "Email: {$terracotta->email}\n";
    echo "Current role: {$terracotta->role}\n";
    echo "Current role_as: {$terracotta->role_as}\n";
    echo "getCurrentRole(): {$terracotta->getCurrentRole()}\n\n";
    
    echo "🔧 UPDATING TERRACOTTA TO ADMIN ROLE\n";
    echo "====================================\n";
    
    // Update to admin role
    $terracotta->role = 'admin';
    $terracotta->role_as = 1;  // Admin role_as value
    $terracotta->save();
    
    // Refresh to get updated data
    $terracotta->refresh();
    
    echo "✅ Updated successfully!\n";
    echo "New role: {$terracotta->role}\n";
    echo "New role_as: {$terracotta->role_as}\n";
    echo "New getCurrentRole(): {$terracotta->getCurrentRole()}\n\n";
    
    echo "🔍 CHECKING ALL ADMIN USERS\n";
    echo "===========================\n";
    
    $admins = User::where('role', 'admin')->orWhere('role_as', 1)->get();
    foreach ($admins as $admin) {
        echo "👤 {$admin->name} ({$admin->email}) - role: {$admin->role}, role_as: {$admin->role_as}, getCurrentRole(): {$admin->getCurrentRole()}\n";
    }
    
} else {
    echo "❌ terracotta user not found!\n";
    
    echo "\n🔍 Searching for similar users...\n";
    $similarUsers = User::where('name', 'LIKE', '%terra%')
        ->orWhere('email', 'LIKE', '%terra%')
        ->get();
    
    if ($similarUsers->count() > 0) {
        echo "Found similar users:\n";
        foreach ($similarUsers as $user) {
            echo "   👤 {$user->name} ({$user->email}) - role: {$user->role}\n";
        }
    } else {
        echo "No similar users found.\n";
    }
}

echo "\n✅ ROLE FIX COMPLETED!\n";
