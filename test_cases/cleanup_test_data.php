<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ChatRoom;
use App\Models\ChatMessage;

echo "🧹 Cleaning up test data...\n";

// Delete test messages
$deletedMessages = ChatMessage::where('message', 'LIKE', '%TEST MESSAGE%')
    ->orWhere('message', 'LIKE', '%test message%')
    ->orWhere('message', 'LIKE', '%Hello! This is a test%')
    ->delete();

// Delete test rooms
$deletedRooms = ChatRoom::where('name', 'LIKE', '%TEST CHAT%')
    ->orWhere('name', 'LIKE', '%Test Group Chat%')
    ->delete();

echo "✅ Cleaned up {$deletedMessages} test messages and {$deletedRooms} test rooms\n";

// Final clean status
$totalRooms = ChatRoom::count();
$totalMessages = ChatMessage::count();

echo "📊 Clean system status:\n";
echo "   🏠 Remaining chat rooms: {$totalRooms}\n";
echo "   💬 Remaining messages: {$totalMessages}\n";
echo "✨ System is now clean and ready for production use!\n";
