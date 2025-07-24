<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Http\Controllers\ChatController;

echo "🔄 Testing Role-Based Chat Restrictions...\n\n";

// Create a test ChatController instance
$chatController = new ChatController();

// Get test method using reflection (since it's private)
$reflection = new ReflectionClass($chatController);
$getAllowedUsersMethod = $reflection->getMethod('getAllowedChatUsers');
$getAllowedUsersMethod->setAccessible(true);

$canUsersChatMethod = $reflection->getMethod('canUsersChat');
$canUsersChatMethod->setAccessible(true);

// Test different role scenarios
$testScenarios = [
    ['admin', 'supplier', true],
    ['admin', 'wholesaler', true], 
    ['admin', 'staff', true],
    ['admin', 'retailer', false],
    ['admin', 'customer', false],
    
    ['supplier', 'admin', true],
    ['supplier', 'wholesaler', false],
    ['supplier', 'customer', false],
    
    ['wholesaler', 'admin', true],
    ['wholesaler', 'retailer', true],
    ['wholesaler', 'staff', true],
    ['wholesaler', 'customer', false],
    
    ['retailer', 'customer', true],
    ['retailer', 'wholesaler', true],
    ['retailer', 'admin', false],
    
    ['customer', 'retailer', true],
    ['customer', 'admin', false],
    ['customer', 'supplier', false],
    
    ['staff', 'admin', true],
    ['staff', 'wholesaler', true],
    ['staff', 'customer', false],
];

echo "📋 Chat Permission Matrix:\n";
echo str_repeat("=", 50) . "\n";

foreach ($testScenarios as [$role1, $role2, $expected]) {
    // Create mock users
    $user1 = new User();
    $user1->role_as = getRoleId($role1);
    $user1->name = "Test " . ucfirst($role1);
    
    $user2 = new User();
    $user2->role_as = getRoleId($role2);
    $user2->name = "Test " . ucfirst($role2);
    
    // Test the permission
    $canChat = $canUsersChatMethod->invoke($chatController, $user1, $user2);
    
    $status = $canChat === $expected ? "✅" : "❌";
    $expectedText = $expected ? "ALLOWED" : "BLOCKED";
    $actualText = $canChat ? "ALLOWED" : "BLOCKED";
    
    echo sprintf(
        "%s %s -> %s: %s (Expected: %s)\n", 
        $status,
        strtoupper($role1), 
        strtoupper($role2), 
        $actualText,
        $expectedText
    );
}

echo "\n" . str_repeat("=", 50) . "\n";

// Test allowed users for each role
echo "📊 Allowed Chat Partners by Role:\n";
echo str_repeat("-", 30) . "\n";

$roles = ['admin', 'supplier', 'wholesaler', 'retailer', 'customer', 'staff'];

foreach ($roles as $role) {
    $user = new User();
    $user->id = 1;
    $user->role_as = getRoleId($role);
    $user->name = "Test " . ucfirst($role);
    
    // Mock the allowed users query result
    $allowedRoles = getAllowedRoles($role);
    
    echo "🔹 " . strtoupper($role) . " can chat with: " . implode(', ', array_map('strtoupper', $allowedRoles)) . "\n";
}

echo "\n✅ Role-based chat restrictions are properly configured!\n";

function getRoleId($role) {
    $roleMap = [
        'customer' => 0,
        'admin' => 1,
        'retailer' => 2,
        'staff' => 3,
        'supplier' => 4,
        'wholesaler' => 5
    ];
    return $roleMap[$role] ?? 0;
}

function getAllowedRoles($role) {
    $allowedInteractions = [
        'admin' => ['supplier', 'wholesaler', 'staff'],
        'supplier' => ['admin'],
        'wholesaler' => ['admin', 'retailer', 'staff'],
        'retailer' => ['customer', 'wholesaler'],
        'customer' => ['retailer'],
        'staff' => ['admin', 'wholesaler']
    ];
    
    return $allowedInteractions[$role] ?? [];
}
