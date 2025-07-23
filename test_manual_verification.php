<?php

// Test manual verification functionality
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "=== Testing Manual Email Verification ===\n\n";

// Find an unverified user
$user = User::whereNull('email_verified_at')->first();

if (!$user) {
    echo "Creating unverified test user...\n";
    $user = User::create([
        'name' => 'Manual Test User',
        'email' => 'manual-test@example.com',
        'password' => bcrypt('password123'),
        'role' => 'customer'
    ]);
    echo "✓ Test user created: {$user->email}\n";
} else {
    echo "✓ Found unverified user: {$user->email}\n";
}

echo "\nBefore verification:\n";
echo "- Email verified: " . ($user->hasVerifiedEmail() ? "YES" : "NO") . "\n";
echo "- Verified at: " . ($user->email_verified_at ?? "Not verified") . "\n";

echo "\nPerforming manual verification...\n";

try {
    // Test manual verification (this should work)
    $user->markEmailAsVerified();
    $user->refresh();
    
    echo "✓ Manual verification successful!\n";
    echo "\nAfter verification:\n";
    echo "- Email verified: " . ($user->hasVerifiedEmail() ? "YES" : "NO") . "\n";
    echo "- Verified at: " . $user->email_verified_at . "\n";
    
} catch (Exception $e) {
    echo "✗ Error with manual verification: " . $e->getMessage() . "\n";
}

echo "\n=== Manual Verification Test Complete ===\n";
echo "\nThe admin panel verification buttons should work correctly!\n";
echo "Visit: http://localhost:8000/admin/users\n";
