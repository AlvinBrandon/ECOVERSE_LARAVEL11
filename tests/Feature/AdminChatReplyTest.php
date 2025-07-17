<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;

class AdminChatReplyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that admin can view any chat room.
     *
     * @return void
     */
    public function testAdminCanViewAnyChatRoom()
    {
        // Create users
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'customer']);
        
        // Create a chat room
        $room = ChatRoom::create([
            'name' => 'Test Room',
            'type' => 'private',
            'description' => 'Test room for admin access',
        ]);
        
        // Add customer to the room but not the admin
        $room->users()->attach($customer->id);
        
        // Add a message from the customer
        $message = ChatMessage::create([
            'user_id' => $customer->id,
            'room_id' => $room->id,
            'message' => 'Test message from customer',
        ]);
        
        // Admin should be able to access the room
        $this->actingAs($admin)
            ->get(route('chat.history', $room->id))
            ->assertStatus(200)
            ->assertSee('Test message from customer');
    }
    
    /**
     * Test that admin can reply to any chat room.
     *
     * @return void
     */
    public function testAdminCanReplyToAnyChatRoom()
    {
        // Create users
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'customer']);
        
        // Create a chat room
        $room = ChatRoom::create([
            'name' => 'Test Room',
            'type' => 'private',
            'description' => 'Test room for admin replies',
        ]);
        
        // Add customer to the room but not the admin
        $room->users()->attach($customer->id);
        
        // Admin should be able to send a message to the room
        $response = $this->actingAs($admin)
            ->post(route('chat.sendMessage'), [
                'room_id' => $room->id,
                'message' => 'Admin reply message',
            ]);
            
        $response->assertStatus(302); // Redirect after successful post
        
        // Check that the message exists in the database
        $this->assertDatabaseHas('chat_messages', [
            'user_id' => $admin->id,
            'room_id' => $room->id,
            'message' => 'Admin reply message',
        ]);
        
        // Verify admin was added to the room
        $this->assertTrue($room->users()->where('users.id', $admin->id)->exists());
    }
    
    /**
     * Test that customer cannot access chat rooms they're not part of.
     *
     * @return void
     */
    public function testCustomerCannotAccessUnauthorizedRooms()
    {
        // Create users
        $customer1 = User::factory()->create(['role' => 'customer']);
        $customer2 = User::factory()->create(['role' => 'customer']);
        
        // Create a chat room
        $room = ChatRoom::create([
            'name' => 'Test Room',
            'type' => 'private',
            'description' => 'Private test room',
        ]);
        
        // Add only customer1 to the room
        $room->users()->attach($customer1->id);
        
        // Customer2 should not be able to access the room
        $this->actingAs($customer2)
            ->get(route('chat.history', $room->id))
            ->assertStatus(403); // Forbidden
    }
}
