<?php
/**
 * Simple message sender for testing
 */

// Bootstrap Laravel application
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ChatMessage;
use App\Events\NewChatMessage;

// Create and send a message
$message = new ChatMessage();
$message->room_id = 1; // Use the room ID from the test
$message->user_id = 1; // Use admin or first user ID
$message->message = 'Test message from quick sender at ' . date('H:i:s');
$message->save();

// Broadcast the message
event(new NewChatMessage($message));

echo "Message sent to room #{$message->room_id}: {$message->message}\n";
