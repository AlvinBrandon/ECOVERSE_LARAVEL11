<?php

namespace Tests\Feature;

use App\Events\NewChatMessage;
use App\Events\UserOnlineStatus;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ChatBroadcastTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a NewChatMessage event is dispatched when sending a message.
     *
     * @return void
     */
    public function test_new_chat_message_event_is_dispatched()
    {
        Event::fake([NewChatMessage::class]);
        
        // Create a user
        $user = User::factory()->create();
        
        // Create a chat room and attach user
        $room = ChatRoom::create([
            'name' => 'Event Test Room',
            'type' => 'private',
        ]);
        
        $room->users()->attach($user->id);
        
        // Login as user
        $this->actingAs($user);
        
        // Send a message
        $this->post(route('chat.send'), [
            'room_id' => $room->id,
            'message' => 'Testing events!'
        ]);
        
        // Assert event was dispatched
        Event::assertDispatched(NewChatMessage::class, function ($event) {
            return $event->message->message === 'Testing events!';
        });
    }
    
    /**
     * Test that user online status event is dispatched.
     *
     * @return void
     */
    public function test_user_online_status_event_is_dispatched()
    {
        Event::fake([UserOnlineStatus::class]);
        
        // Create a user
        $user = User::factory()->create();
        
        // Login as user
        $this->actingAs($user);
        
        // Update status
        $this->post(route('chat.status.update'), [
            'status' => 'online'
        ]);
        
        // Assert event was dispatched
        Event::assertDispatched(UserOnlineStatus::class, function ($event) use ($user) {
            return $event->user->id === $user->id && $event->status === 'online';
        });
    }
    
    /**
     * Test that notifications are created when a message is sent.
     *
     * @return void
     */
    public function test_notifications_are_created_for_chat_messages()
    {
        // Create users
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        
        // Create a chat room and attach both users
        $room = ChatRoom::create([
            'name' => 'Notification Test Room',
            'type' => 'private',
        ]);
        
        $room->users()->attach([$user1->id, $user2->id]);
        
        // Login as user1
        $this->actingAs($user1);
        
        // Send a message
        $this->post(route('chat.send'), [
            'room_id' => $room->id,
            'message' => 'Testing notifications!'
        ]);
        
        // Assert notification was created for user2
        $this->assertDatabaseHas('notifications', [
            'notifiable_type' => 'App\\Models\\User',
            'notifiable_id' => $user2->id,
            'type' => 'App\\Notifications\\NewChatMessage',
        ]);
    }
}
