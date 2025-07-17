<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChatPollingTest extends TestCase
{
    use RefreshDatabase;
    
    protected $user;
    protected $room;
    
    public function setUp(): void
    {
        parent::setUp();
        
        // Create a test user
        $this->user = User::factory()->create([
            'role' => 'admin' // So we can test all functionality
        ]);
        
        // Create a test chat room
        $this->room = ChatRoom::create([
            'name' => 'Test Chat Room',
            'created_by' => $this->user->id
        ]);
        
        // Add user to the room
        $this->room->users()->attach($this->user->id);
        
        // Create some test messages
        ChatMessage::create([
            'chat_room_id' => $this->room->id,
            'user_id' => $this->user->id,
            'message' => 'Test message 1'
        ]);
        
        ChatMessage::create([
            'chat_room_id' => $this->room->id,
            'user_id' => $this->user->id,
            'message' => 'Test message 2'
        ]);
    }
    
    /**
     * Test getting messages
     */
    public function test_get_messages()
    {
        $response = $this->actingAs($this->user)
            ->get('/chat/poll/messages?room_id=' . $this->room->id . '&last_id=0');
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'messages',
                'last_id'
            ])
            ->assertJsonCount(2, 'messages');
    }
    
    /**
     * Test sending a message
     */
    public function test_send_message()
    {
        $response = $this->actingAs($this->user)
            ->post('/chat/poll/send', [
                'room_id' => $this->room->id,
                'message' => 'This is a test message'
            ]);
        
        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ])
            ->assertJsonStructure([
                'message' => [
                    'id', 
                    'message', 
                    'user_id', 
                    'username', 
                    'role', 
                    'created_at', 
                    'is_mine'
                ]
            ]);
            
        // Verify the message was saved to the database
        $this->assertDatabaseHas('chat_messages', [
            'chat_room_id' => $this->room->id,
            'user_id' => $this->user->id,
            'message' => 'This is a test message'
        ]);
    }
    
    /**
     * Test getting online users
     */
    public function test_get_online_users()
    {
        // Update user to be online
        $this->user->update([
            'last_active_at' => now()
        ]);
        
        $response = $this->actingAs($this->user)
            ->get('/chat/poll/online-users');
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'users'
            ]);
    }
    
    /**
     * Test setting typing status
     */
    public function test_set_typing_status()
    {
        $response = $this->actingAs($this->user)
            ->post('/chat/poll/typing', [
                'room_id' => $this->room->id,
                'is_typing' => true
            ]);
        
        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);
    }
    
    /**
     * Test getting typing users
     */
    public function test_get_typing_users()
    {
        $response = $this->actingAs($this->user)
            ->get('/chat/poll/typing-users?room_id=' . $this->room->id);
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'typing_users'
            ]);
    }
    
    /**
     * Test getting unread count
     */
    public function test_get_unread_count()
    {
        $response = $this->actingAs($this->user)
            ->get('/chat/poll/unread-count');
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'unread_count'
            ]);
    }
    
    /**
     * Test sending a message with invalid room ID
     */
    public function test_send_message_with_invalid_room()
    {
        $response = $this->actingAs($this->user)
            ->post('/chat/poll/send', [
                'room_id' => 9999, // Invalid ID
                'message' => 'This message should not be sent'
            ]);
        
        $response->assertStatus(422); // Validation error
    }
    
    /**
     * Test sending a message with parent reply
     */
    public function test_send_message_with_parent()
    {
        // Get first message to reply to
        $parentMessage = ChatMessage::where('chat_room_id', $this->room->id)->first();
        
        $response = $this->actingAs($this->user)
            ->post('/chat/poll/send', [
                'room_id' => $this->room->id,
                'message' => 'This is a reply to a message',
                'parent_id' => $parentMessage->id
            ]);
        
        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ])
            ->assertJsonPath('message.parent_id', $parentMessage->id);
            
        // Verify the message was saved with parent_id
        $this->assertDatabaseHas('chat_messages', [
            'chat_room_id' => $this->room->id,
            'user_id' => $this->user->id,
            'message' => 'This is a reply to a message',
            'parent_id' => $parentMessage->id
        ]);
    }
}
