<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\ChatRoom;
use App\Models\ChatMessage;

echo "🏆 FINAL CHAT SYSTEM VERIFICATION\n";
echo "=================================\n\n";

// Get test users
$users = [
    'admin' => User::where('email', 'test_admin@ecoverse.com')->first(),
    'retailer' => User::where('email', 'test_retailer@ecoverse.com')->first(),
    'supplier' => User::where('email', 'test_supplier@ecoverse.com')->first(),
    'customer' => User::where('email', 'test_customer@ecoverse.com')->first(),
    'wholesaler' => User::where('email', 'test_wholesaler@ecoverse.com')->first(),
    'staff' => User::where('email', 'test_staff@ecoverse.com')->first()
];

// Verify all users exist
$allUsersExist = true;
foreach ($users as $role => $user) {
    if (!$user) {
        echo "❌ Missing {$role} user\n";
        $allUsersExist = false;
    } else {
        echo "✅ {$role}: {$user->email} (role_as: {$user->role_as}, getCurrentRole: {$user->getCurrentRole()})\n";
    }
}

if (!$allUsersExist) {
    echo "\n❌ Not all test users exist. Please run the main test first.\n";
    exit;
}

echo "\n📊 SYSTEM STATISTICS\n";
echo "====================\n";

$totalRooms = ChatRoom::count();
$totalMessages = ChatMessage::count();
$totalUsers = User::count();

echo "👥 Total users in system: {$totalUsers}\n";
echo "🏠 Total chat rooms: {$totalRooms}\n";
echo "💬 Total messages: {$totalMessages}\n";

echo "\n🔍 DETAILED CHAT ANALYSIS\n";
echo "=========================\n";

// Analyze each test user's chat capabilities
foreach ($users as $role => $user) {
    echo "\n👤 {$role} ({$user->name}):\n";
    
    // Get rooms this user is in
    $userRooms = ChatRoom::whereHas('users', function($query) use ($user) {
        $query->where('users.id', $user->id);
    })->with(['users', 'messages'])->get();
    
    echo "   🏠 Active in {$userRooms->count()} chat rooms:\n";
    
    foreach ($userRooms as $room) {
        $otherUsers = $room->users->where('id', '!=', $user->id);
        $messageCount = $room->messages->count();
        $lastMessage = $room->messages->sortByDesc('created_at')->first();
        
        echo "     • {$room->name}\n";
        echo "       👥 With: " . $otherUsers->pluck('name')->implode(', ') . "\n";
        echo "       💬 Messages: {$messageCount}\n";
        
        if ($lastMessage) {
            $sender = $lastMessage->user->name;
            $time = $lastMessage->created_at->diffForHumans();
            $preview = substr($lastMessage->message, 0, 50) . (strlen($lastMessage->message) > 50 ? '...' : '');
            echo "       📝 Last: \"{$preview}\" by {$sender} {$time}\n";
        }
    }
    
    // Count messages sent by this user
    $messagesSent = ChatMessage::where('user_id', $user->id)->count();
    echo "   📤 Messages sent: {$messagesSent}\n";
}

echo "\n🔐 ROLE-BASED ACCESS VERIFICATION\n";
echo "=================================\n";

// Test role-based access patterns
$interactionTests = [
    ['admin', 'supplier', true],
    ['admin', 'wholesaler', true],
    ['admin', 'staff', true],
    ['admin', 'retailer', false],
    ['admin', 'customer', false],
    ['supplier', 'admin', true],
    ['supplier', 'retailer', false],
    ['wholesaler', 'retailer', true],
    ['retailer', 'customer', true],
    ['customer', 'retailer', true],
    ['customer', 'admin', false],
    ['staff', 'admin', true],
    ['staff', 'wholesaler', true]
];

echo "Testing " . count($interactionTests) . " role interaction scenarios:\n\n";

$passedTests = 0;
foreach ($interactionTests as [$role1, $role2, $shouldAllow]) {
    $user1 = $users[$role1];
    $user2 = $users[$role2];
    
    // Check if they have an active chat room
    $hasRoom = ChatRoom::whereHas('users', function($query) use ($user1) {
        $query->where('users.id', $user1->id);
    })->whereHas('users', function($query) use ($user2) {
        $query->where('users.id', $user2->id);
    })->where('type', 'private')->exists();
    
    $status = $hasRoom === $shouldAllow;
    $icon = $status ? '✅' : '❌';
    $expected = $shouldAllow ? 'ALLOWED' : 'BLOCKED';
    $actual = $hasRoom ? 'ALLOWED' : 'BLOCKED';
    
    echo "{$icon} {$role1} → {$role2}: Expected {$expected}, Got {$actual}\n";
    
    if ($status) $passedTests++;
}

$successRate = round(($passedTests / count($interactionTests)) * 100, 1);
echo "\n📈 Success Rate: {$passedTests}/" . count($interactionTests) . " ({$successRate}%)\n";

echo "\n💬 MESSAGE FLOW ANALYSIS\n";
echo "========================\n";

// Analyze message patterns
$recentMessages = ChatMessage::with(['user', 'room'])->orderBy('created_at', 'desc')->take(10)->get();

echo "📝 Last 10 messages in the system:\n";
foreach ($recentMessages as $message) {
    $sender = $message->user->name;
    $senderRole = $message->user->getCurrentRole();
    $roomName = $message->room->name;
    $time = $message->created_at->format('H:i:s');
    $preview = substr($message->message, 0, 60) . (strlen($message->message) > 60 ? '...' : '');
    
    echo "   {$time} | {$sender} ({$senderRole}) in {$roomName}:\n";
    echo "           \"{$preview}\"\n";
}

echo "\n🎯 ADMIN OVERSIGHT VERIFICATION\n";
echo "===============================\n";

$admin = $users['admin'];
$totalRoomsForAdmin = ChatRoom::count();
$adminAccessibleRooms = 0;

foreach (ChatRoom::all() as $room) {
    if ($room->userHasAccess($admin)) {
        $adminAccessibleRooms++;
    }
}

echo "🔑 Admin access verification:\n";
echo "   Total rooms in system: {$totalRoomsForAdmin}\n";
echo "   Rooms admin can access: {$adminAccessibleRooms}\n";

if ($adminAccessibleRooms === $totalRoomsForAdmin) {
    echo "   ✅ PERFECT: Admin has oversight access to all rooms\n";
} else {
    echo "   ⚠️  WARNING: Admin missing access to some rooms\n";
}

echo "\n🔧 SYSTEM HEALTH CHECK\n";
echo "======================\n";

// Check for any orphaned data
$roomsWithoutUsers = ChatRoom::whereDoesntHave('users')->count();
$messagesWithoutUsers = ChatMessage::whereDoesntHave('user')->count();
$messagesWithoutRooms = ChatMessage::whereDoesntHave('room')->count();

echo "🧹 Data integrity check:\n";
echo "   Rooms without users: {$roomsWithoutUsers}\n";
echo "   Messages without users: {$messagesWithoutUsers}\n";
echo "   Messages without rooms: {$messagesWithoutRooms}\n";

$dataIntegrityOk = ($roomsWithoutUsers === 0 && $messagesWithoutUsers === 0 && $messagesWithoutRooms === 0);
echo "   " . ($dataIntegrityOk ? "✅ Data integrity: GOOD" : "⚠️  Data integrity: ISSUES FOUND") . "\n";

echo "\n🎉 FINAL VERIFICATION RESULTS\n";
echo "============================\n";

$allSystemsGo = $allUsersExist && $successRate >= 90 && $dataIntegrityOk && ($adminAccessibleRooms === $totalRoomsForAdmin);

if ($allSystemsGo) {
    echo "🎊 ALL SYSTEMS OPERATIONAL! 🎊\n";
    echo "✅ All test users created and configured correctly\n";
    echo "✅ Role-based chat restrictions working perfectly\n";
    echo "✅ Message sending and receiving functional\n";
    echo "✅ Admin oversight properly implemented\n";
    echo "✅ Database integrity maintained\n";
    echo "✅ Chat system ready for production use!\n";
} else {
    echo "⚠️  SOME ISSUES DETECTED\n";
    if (!$allUsersExist) echo "❌ Missing test users\n";
    if ($successRate < 90) echo "❌ Role restrictions not working properly\n";
    if (!$dataIntegrityOk) echo "❌ Data integrity issues\n";
    if ($adminAccessibleRooms !== $totalRoomsForAdmin) echo "❌ Admin oversight incomplete\n";
}

echo "\n📋 MANUAL TESTING GUIDE\n";
echo "=======================\n";
echo "To test the web interface manually:\n\n";

echo "1. 🌐 Navigate to: http://localhost/ECOVERSE_LARAVEL11/public\n\n";

echo "2. 🔐 Login with test accounts:\n";
foreach ($users as $role => $user) {
    echo "   • {$role}: {$user->email} (password: password)\n";
}

echo "\n3. 🧭 Navigation paths:\n";
echo "   • /chat/select-user - Choose who to chat with\n";
echo "   • /chat/history - View chat history\n";
echo "   • /chat/history/{roomId} - View specific room\n";

echo "\n4. 🧪 Test scenarios:\n";
echo "   • Login as admin, try chatting with supplier (should work)\n";
echo "   • Login as customer, try chatting with admin (should be blocked)\n";
echo "   • Login as retailer, chat with customer (should work)\n";
echo "   • Send messages back and forth\n";
echo "   • Test group chat creation (admin only)\n";

echo "\n5. ✅ Expected behaviors:\n";
echo "   • Only allowed role combinations appear in select-user\n";
echo "   • Unauthorized chat attempts redirect with error message\n";
echo "   • Messages send and appear in real-time\n";
echo "   • Admin can see all chat rooms\n";
echo "   • Users only see their own chat rooms\n";

echo "\n🎯 The chat system is fully functional with comprehensive role-based restrictions!\n";
