<?php
/**
 * EcoVerse Chat Test Script
 * This script simulates sending chat messages through the application
 */

// Bootstrap Laravel application
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use App\Events\NewChatMessage;
use Illuminate\Support\Facades\Event;

// Helper function to create a test message
function createTestMessage($roomId, $userId, $message = null) {
    // Create a message
    $chatMessage = new ChatMessage();
    $chatMessage->room_id = $roomId;
    $chatMessage->user_id = $userId;
    $chatMessage->message = $message ?? 'Test message from PHP CLI at ' . date('Y-m-d H:i:s');
    $chatMessage->save();
    
    // Broadcast message event
    event(new NewChatMessage($chatMessage));
    
    return $chatMessage;
}

// Test function to list available chat rooms
function listChatRooms() {
    echo "Available Chat Rooms:\n";
    echo "---------------------\n";
    
    $rooms = ChatRoom::with('users')->get();
    
    if ($rooms->isEmpty()) {
        echo "No chat rooms found.\n";
        return null;
    }
    
    foreach ($rooms as $room) {
        $userNames = $room->users->pluck('name')->join(', ');
        echo "Room #{$room->id}: {$room->name} - Users: {$userNames}\n";
    }
    
    return $rooms;
}

// Function to create a test room
function createTestRoom() {
    $room = new ChatRoom();
    $room->name = 'Test Room ' . uniqid();
    $room->save();
    
    // Add some users to the room
    $users = User::take(2)->get();
    $room->users()->attach($users->pluck('id'));
    
    echo "Created test room: {$room->name} with users: {$users->pluck('name')->join(', ')}\n";
    return $room;
}

// Main execution
echo "EcoVerse Chat Test\n";
echo "=================\n\n";

// List available rooms
$rooms = listChatRooms();

// Create a test room if none exists
$testRoom = null;
if ($rooms === null || $rooms->isEmpty()) {
    echo "\nNo rooms found. Creating a test room...\n";
    $testRoom = createTestRoom();
} else {
    $testRoom = $rooms->first();
}

// Get a user to send messages as
$user = User::first();
if (!$user) {
    echo "Error: No users found in the database.\n";
    exit(1);
}

echo "\nSending test messages...\n";

// Send a series of test messages
for ($i = 1; $i <= 3; $i++) {
    $message = createTestMessage(
        $testRoom->id, 
        $user->id, 
        "Test message #{$i} from {$user->name} at " . date('H:i:s')
    );
    echo "Sent message: {$message->message}\n";
    
    // Add a small delay to simulate real usage
    sleep(1);
}

echo "\nTest completed successfully!\n";
echo "Now check your browser to see if the messages appeared in real-time.\n";
echo "If they did not appear, verify that Reverb is running and your browser is connected.\n";
