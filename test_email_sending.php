<?php

// Test sending verification email
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "=== Testing Email Verification Sending ===\n\n";

// Find an unverified user
$user = User::whereNull('email_verified_at')->first();

if (!$user) {
    echo "Creating unverified test user...\n";
    $user = User::create([
        'name' => 'Test Verification User',
        'email' => 'verification-test@example.com',
        'password' => bcrypt('password123'),
        'role' => 'customer'
    ]);
    echo "✓ Test user created: {$user->email}\n";
} else {
    echo "✓ Found unverified user: {$user->email}\n";
}

echo "\nTesting email verification notification...\n";

try {
    // This should now work without errors
    $user->sendEmailVerificationNotification();
    echo "✓ Email verification notification sent successfully!\n";
    echo "✓ Check storage/logs/laravel.log for email content\n";
} catch (Exception $e) {
    echo "✗ Error sending verification email: " . $e->getMessage() . "\n";
}

echo "\n=== Test Complete ===\n";
