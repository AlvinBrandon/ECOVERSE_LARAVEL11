<?php

namespace Tests\Feature;

use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChatSystemTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a user can view their chat rooms.
     *
     * @return void
     */
    public function test_user_can_view_chat_rooms()
    {
        // Create a user
        $user = User::factory()->create();
        
        // Create a chat room and attach user
        $room = ChatRoom::create([
            'name' => 'Test Room',
            'type' => 'private',
            'description' => 'Test Description'
        ]);
        
        $room->users()->attach($user->id);
        
        // Login as user
        $this->actingAs($user);
        
        // Visit chat index page
        $response = $this->get(route('chat.index'));
        
        // Assert success and check for room name
        $response->assertStatus(200);
        $response->assertSee('Test Room');
    }
    
    /**
     * Test that a user can start a new chat.
     *
     * @return void
     */
    public function test_user_can_start_new_chat()
    {
        // Create users
        $user1 = User::factory()->create(['role' => 'admin']);
        $user2 = User::factory()->create(['role' => 'customer']);
        
        // Login as user1
        $this->actingAs($user1);
        
        // Visit start chat page
        $response = $this->get(route('chat.start'));
        
        // Assert success
        $response->assertStatus(200);
        
        // Submit form to create chat room
        $response = $this->post(route('chat.create.room'), [
            'name' => 'New Test Chat',
            'type' => 'private',
            'user_ids' => [$user2->id],
            'description' => 'Initial message'
        ]);
        
        // Assert redirected to chat history
        $response->assertRedirect();
        
        // Assert room was created in the database
        $this->assertDatabaseHas('chat_rooms', [
            'name' => 'New Test Chat',
            'type' => 'private',
        ]);
        
        // Assert the relationship was created in the pivot table
        $room = ChatRoom::where('name', 'New Test Chat')->first();
        $this->assertDatabaseHas('chat_room_user', [
            'room_id' => $room->id,
            'user_id' => $user1->id
        ]);
        $this->assertDatabaseHas('chat_room_user', [
            'room_id' => $room->id,
            'user_id' => $user2->id
        ]);
        
        // Assert initial message was created
        $this->assertDatabaseHas('chat_messages', [
            'room_id' => $room->id,
            'user_id' => $user1->id,
            'message' => 'Initial message'
        ]);
    }
    
    /**
     * Test that a user can send a message.
     *
     * @return void
     */
    public function test_user_can_send_message()
    {
        // Create a user
        $user = User::factory()->create();
        
        // Create a chat room and attach user
        $room = ChatRoom::create([
            'name' => 'Message Test Room',
            'type' => 'private',
        ]);
        
        $room->users()->attach($user->id);
        
        // Login as user
        $this->actingAs($user);
        
        // Send a message
        $response = $this->post(route('chat.send'), [
            'room_id' => $room->id,
            'message' => 'Hello world!'
        ]);
        
        // Assert redirected back
        $response->assertRedirect();
        
        // Assert message exists in database
        $this->assertDatabaseHas('chat_messages', [
            'room_id' => $room->id,
            'user_id' => $user->id,
            'message' => 'Hello world!'
        ]);
    }
    
    /**
     * Test that a user can view chat history.
     *
     * @return void
     */
    public function test_user_can_view_chat_history()
    {
        // Create a user
        $user = User::factory()->create();
        
        // Create a chat room and attach user
        $room = ChatRoom::create([
            'name' => 'History Test Room',
            'type' => 'private',
        ]);
        
        $room->users()->attach($user->id);
        
        // Create some messages
        ChatMessage::create([
            'room_id' => $room->id,
            'user_id' => $user->id,
            'message' => 'Message 1'
        ]);
        
        ChatMessage::create([
            'room_id' => $room->id,
            'user_id' => $user->id,
            'message' => 'Message 2'
        ]);
        
        // Login as user
        $this->actingAs($user);
        
        // Visit chat history page
        $response = $this->get(route('chat.history', $room->id));
        
        // Assert success and check for messages
        $response->assertStatus(200);
        $response->assertSee('Message 1');
        $response->assertSee('Message 2');
    }
    
    /**
     * Test that unauthorized users cannot access chat rooms.
     *
     * @return void
     */
    public function test_unauthorized_users_cannot_access_chats()
    {
        // Create users
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        
        // Create a chat room and attach only user1
        $room = ChatRoom::create([
            'name' => 'Private Room',
            'type' => 'private',
        ]);
        
        $room->users()->attach($user1->id);
        
        // Login as user2 (who is not in the room)
        $this->actingAs($user2);
        
        // Try to visit chat history page
        $response = $this->get(route('chat.history', $room->id));
        
        // Assert forbidden
        $response->assertForbidden();
    }
}
