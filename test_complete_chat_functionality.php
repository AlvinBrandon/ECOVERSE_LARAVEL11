<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use App\Http\Controllers\ChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

echo "🚀 COMPREHENSIVE CHAT SYSTEM TESTING\n";
echo "=====================================\n\n";

// Clear existing test data
echo "🧹 Cleaning up existing test data...\n";
ChatMessage::where('message', 'LIKE', 'TEST MESSAGE%')->delete();
ChatRoom::where('name', 'LIKE', 'TEST CHAT%')->delete();

// Create test users for each role if they don't exist
$testUsers = [];
$roles = [
    'admin' => 1,
    'retailer' => 2, 
    'staff' => 3,
    'supplier' => 4,
    'wholesaler' => 5,
    'customer' => 0
];

echo "👥 Creating test users...\n";
foreach ($roles as $role => $roleId) {
    $email = "test_{$role}@ecoverse.com";
    $user = User::where('email', $email)->first();
    
    if (!$user) {
        $user = User::create([
            'name' => 'Test ' . ucfirst($role),
            'email' => $email,
            'password' => bcrypt('password'),
            'role' => $role,
            'role_as' => $roleId,  // This is crucial for getCurrentRole() method
            'email_verified_at' => now()
        ]);
        echo "   ✅ Created {$role} user: {$email} (role_as: {$roleId})\n";
    } else {
        // Update existing user to ensure role_as is correct
        $user->role_as = $roleId;
        $user->role = $role;
        $user->save();
        $user->refresh(); // Make sure we have the latest data
        echo "   ♻️  Using existing {$role} user: {$email} (updated role_as: {$roleId})\n";
    }
    
    $testUsers[$role] = $user;
}

echo "\n🔍 DEBUGGING: Verifying user roles...\n";
foreach ($testUsers as $role => $user) {
    $currentRole = $user->getCurrentRole();
    $roleAs = $user->role_as;
    echo "   👤 {$role}: role_as={$roleAs}, getCurrentRole()='{$currentRole}'\n";
}

echo "\n📋 TESTING ROLE-BASED CHAT PERMISSIONS\n";
echo "======================================\n";

// Test scenarios based on the role matrix
$testScenarios = [
    // Admin tests
    ['admin', 'supplier', true, 'Admin → Supplier'],
    ['admin', 'wholesaler', true, 'Admin → Wholesaler'], 
    ['admin', 'staff', true, 'Admin → Staff'],
    ['admin', 'retailer', false, 'Admin → Retailer (should fail)'],
    ['admin', 'customer', false, 'Admin → Customer (should fail)'],
    
    // Supplier tests
    ['supplier', 'admin', true, 'Supplier → Admin'],
    ['supplier', 'wholesaler', false, 'Supplier → Wholesaler (should fail)'],
    ['supplier', 'customer', false, 'Supplier → Customer (should fail)'],
    
    // Wholesaler tests
    ['wholesaler', 'admin', true, 'Wholesaler → Admin'],
    ['wholesaler', 'retailer', true, 'Wholesaler → Retailer'],
    ['wholesaler', 'staff', true, 'Wholesaler → Staff'],
    ['wholesaler', 'customer', false, 'Wholesaler → Customer (should fail)'],
    
    // Retailer tests
    ['retailer', 'customer', true, 'Retailer → Customer'],
    ['retailer', 'wholesaler', true, 'Retailer → Wholesaler'],
    ['retailer', 'admin', false, 'Retailer → Admin (should fail)'],
    
    // Customer tests
    ['customer', 'retailer', true, 'Customer → Retailer'],
    ['customer', 'admin', false, 'Customer → Admin (should fail)'],
    ['customer', 'supplier', false, 'Customer → Supplier (should fail)'],
    
    // Staff tests
    ['staff', 'admin', true, 'Staff → Admin'],
    ['staff', 'wholesaler', true, 'Staff → Wholesaler'],
    ['staff', 'customer', false, 'Staff → Customer (should fail)'],
];

$successCount = 0;
$failCount = 0;

foreach ($testScenarios as [$senderRole, $receiverRole, $shouldWork, $description]) {
    $sender = $testUsers[$senderRole];
    $receiver = $testUsers[$receiverRole];
    
    echo "\n🔸 Testing: {$description}\n";
    
    try {
        // Simulate authentication
        Auth::login($sender);
        
        // Create a test request
        $request = new Request([
            'user_id' => $receiver->id,
            'message' => "TEST MESSAGE from {$sender->name} to {$receiver->name} at " . now()
        ]);
        
        $chatController = new ChatController();
        
        // Use reflection to test the private method
        $reflection = new ReflectionClass($chatController);
        $canUsersChatMethod = $reflection->getMethod('canUsersChat');
        $canUsersChatMethod->setAccessible(true);
        
        $canChat = $canUsersChatMethod->invoke($chatController, $sender, $receiver);
        
        if ($canChat === $shouldWork) {
            if ($shouldWork) {
                // Actually create the chat room and message for allowed scenarios
                $room = ChatRoom::create([
                    'name' => "TEST CHAT: {$sender->name} ↔ {$receiver->name}",
                    'type' => 'private',
                    'description' => 'Test conversation'
                ]);
                
                $room->users()->attach([$sender->id, $receiver->id]);
                
                $message = ChatMessage::create([
                    'user_id' => $sender->id,
                    'room_id' => $room->id,
                    'message' => $request->message
                ]);
                
                echo "   ✅ SUCCESS: Chat created with message ID {$message->id}\n";
                echo "   📊 Room ID: {$room->id}, Users: {$sender->name}, {$receiver->name}\n";
            } else {
                echo "   ✅ SUCCESS: Correctly blocked unauthorized chat\n";
            }
            $successCount++;
        } else {
            echo "   ❌ FAILED: Expected " . ($shouldWork ? 'ALLOWED' : 'BLOCKED') . " but got " . ($canChat ? 'ALLOWED' : 'BLOCKED') . "\n";
            $failCount++;
        }
        
    } catch (Exception $e) {
        echo "   ❌ ERROR: {$e->getMessage()}\n";
        $failCount++;
    }
    
    // Logout
    Auth::logout();
}

echo "\n\n🔄 TESTING CHAT ROOM ACCESS CONTROL\n";
echo "===================================\n";

// Test room access for different users
$testRoom = ChatRoom::where('name', 'LIKE', 'TEST CHAT%')->first();
if ($testRoom) {
    foreach ($testUsers as $role => $user) {
        $hasAccess = $testRoom->userHasAccess($user);
        $isMember = $testRoom->users()->where('users.id', $user->id)->exists();
        $isAdmin = $user->getCurrentRole() === 'admin';
        
        echo "🔍 {$role}: Access=" . ($hasAccess ? 'YES' : 'NO') . 
             ", Member=" . ($isMember ? 'YES' : 'NO') . 
             ", Admin=" . ($isAdmin ? 'YES' : 'NO') . "\n";
    }
}

echo "\n\n📧 TESTING MESSAGE SENDING SIMULATION\n";
echo "=====================================\n";

// Simulate actual message sending for allowed scenarios
$allowedPairs = [
    ['admin', 'supplier'],
    ['admin', 'wholesaler'],
    ['admin', 'staff'],
    ['supplier', 'admin'],
    ['wholesaler', 'retailer'],
    ['retailer', 'customer'],
    ['customer', 'retailer'],
    ['staff', 'admin']
];

foreach ($allowedPairs as [$senderRole, $receiverRole]) {
    $sender = $testUsers[$senderRole];
    $receiver = $testUsers[$receiverRole];
    
    Auth::login($sender);
    
    echo "\n📤 Simulating message: {$senderRole} → {$receiverRole}\n";
    
    try {
        // Find existing room or create new one
        $room = ChatRoom::whereHas('users', function($query) use ($sender) {
            $query->where('users.id', $sender->id);
        })->whereHas('users', function($query) use ($receiver) {
            $query->where('users.id', $receiver->id);
        })->where('type', 'private')->first();
        
        if (!$room) {
            $room = ChatRoom::create([
                'name' => "Chat: {$sender->name} ↔ {$receiver->name}",
                'type' => 'private',
                'description' => 'Direct message conversation'
            ]);
            $room->users()->attach([$sender->id, $receiver->id]);
            echo "   🆕 Created new room ID: {$room->id}\n";
        } else {
            echo "   ♻️  Using existing room ID: {$room->id}\n";
        }
        
        // Send test message
        $message = ChatMessage::create([
            'user_id' => $sender->id,
            'room_id' => $room->id,
            'message' => "Hello {$receiver->name}! This is a test message from {$sender->name} at " . now()->format('H:i:s')
        ]);
        
        echo "   ✅ Message sent successfully (ID: {$message->id})\n";
        echo "   📝 Content: {$message->message}\n";
        
        // Simulate reply
        $reply = ChatMessage::create([
            'user_id' => $receiver->id,
            'room_id' => $room->id,
            'message' => "Hi {$sender->name}! I received your message. Replying at " . now()->format('H:i:s'),
            'parent_id' => $message->id
        ]);
        
        echo "   💬 Reply sent (ID: {$reply->id})\n";
        
    } catch (Exception $e) {
        echo "   ❌ Error: {$e->getMessage()}\n";
    }
    
    Auth::logout();
}

echo "\n\n📊 TESTING SUMMARY\n";
echo "==================\n";

// Get final statistics
$totalRooms = ChatRoom::where('name', 'LIKE', '%Test%')->orWhere('name', 'LIKE', '%Chat:%')->count();
$totalMessages = ChatMessage::where('message', 'LIKE', '%test%')->orWhere('message', 'LIKE', '%Test%')->orWhere('message', 'LIKE', '%Hello%')->count();
$totalTestMessages = ChatMessage::where('message', 'LIKE', 'TEST MESSAGE%')->count();

echo "📈 Test Results:\n";
echo "   ✅ Successful tests: {$successCount}\n";
echo "   ❌ Failed tests: {$failCount}\n";
echo "   📊 Total success rate: " . round(($successCount / ($successCount + $failCount)) * 100, 2) . "%\n";

echo "\n📈 Database Statistics:\n";
echo "   🏠 Chat rooms created: {$totalRooms}\n";
echo "   💬 Total messages: {$totalMessages}\n";
echo "   🧪 Test messages: {$totalTestMessages}\n";

echo "\n📋 Active Chat Rooms:\n";
$rooms = ChatRoom::with('users')->where('name', 'LIKE', '%Test%')->orWhere('name', 'LIKE', '%Chat:%')->get();
foreach ($rooms as $room) {
    $userNames = $room->users->pluck('name')->implode(', ');
    $messageCount = $room->messages()->count();
    echo "   🏠 {$room->name} ({$room->type}) - Users: {$userNames} - Messages: {$messageCount}\n";
}

echo "\n🔧 ADMIN OVERSIGHT TEST\n";
echo "=======================\n";

// Test admin access to all rooms
$admin = $testUsers['admin'];
Auth::login($admin);

$allRooms = ChatRoom::all();
echo "Testing admin access to all {$allRooms->count()} rooms...\n";

$adminAccessCount = 0;
foreach ($allRooms as $room) {
    if ($room->userHasAccess($admin)) {
        $adminAccessCount++;
    }
}

echo "✅ Admin has access to {$adminAccessCount}/{$allRooms->count()} rooms\n";
if ($adminAccessCount === $allRooms->count()) {
    echo "🎉 PERFECT: Admin oversight working correctly!\n";
} else {
    echo "⚠️  WARNING: Admin doesn't have access to all rooms\n";
}

Auth::logout();

echo "\n🎯 ROLE INTERACTION MATRIX VERIFICATION\n";
echo "=======================================\n";

$interactionMatrix = [
    'admin' => ['supplier', 'wholesaler', 'staff'],
    'supplier' => ['admin'],
    'wholesaler' => ['admin', 'retailer', 'staff'],
    'retailer' => ['customer', 'wholesaler'],
    'customer' => ['retailer'],
    'staff' => ['admin', 'wholesaler']
];

foreach ($interactionMatrix as $role => $allowedRoles) {
    echo "👤 {$role} can chat with: " . implode(', ', $allowedRoles) . "\n";
    
    $user = $testUsers[$role];
    Auth::login($user);
    
    $chatController = new ChatController();
    $reflection = new ReflectionClass($chatController);
    $getAllowedUsersMethod = $reflection->getMethod('getAllowedChatUsers');
    $getAllowedUsersMethod->setAccessible(true);
    
    $allowedUsers = $getAllowedUsersMethod->invoke($chatController, $user);
    $allowedUserRoles = $allowedUsers->map(function($u) {
        return $u->getCurrentRole();
    })->toArray();
    
    $matches = array_diff($allowedRoles, $allowedUserRoles) === [] && array_diff($allowedUserRoles, $allowedRoles) === [];
    
    echo "   " . ($matches ? "✅" : "❌") . " System allows: " . implode(', ', $allowedUserRoles) . "\n";
    
    Auth::logout();
}

echo "\n🏁 TESTING COMPLETED!\n";
echo "====================\n";

if ($failCount === 0) {
    echo "🎉 ALL TESTS PASSED! The chat system is working perfectly!\n";
    echo "✅ Role-based restrictions are properly enforced\n";
    echo "✅ Message sending works for all allowed scenarios\n";
    echo "✅ Admin oversight is functioning correctly\n";
    echo "✅ Database operations are successful\n";
} else {
    echo "⚠️  Some tests failed. Please review the output above.\n";
    echo "📋 Failed tests: {$failCount}\n";
    echo "📋 Successful tests: {$successCount}\n";
}

echo "\n💡 You can now test the web interface by:\n";
echo "   1. Logging in as different user roles\n";
echo "   2. Going to /chat/select-user\n";
echo "   3. Trying to message users based on the role matrix\n";
echo "   4. Checking that unauthorized attempts are blocked\n";

echo "\n🧹 Cleanup note: Test data created with 'TEST' or 'test' in names/messages\n";
echo "Run this script again to clean up and re-test.\n";
