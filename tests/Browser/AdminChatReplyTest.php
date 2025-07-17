<?php

namespace Tests\Browser;

use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminChatReplyTest extends DuskTestCase
{
    /**
     * A test to verify admin chat reply functionality.
     *
     * @return void
     */
    public function testAdminCanReplyToAnyChat()
    {
        // Create test users
        $admin = User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'test.admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);
        
        $customer = User::factory()->create([
            'name' => 'Test Customer',
            'email' => 'test.customer@example.com',
            'password' => bcrypt('password'),
            'role' => 'customer'
        ]);
        
        // Create a chat room with only the customer initially
        $room = ChatRoom::create([
            'name' => 'Browser Test Chat Room',
            'type' => 'private',
            'description' => 'Created for browser testing'
        ]);
        
        $room->users()->attach($customer->id);
        
        // Customer creates initial message
        ChatMessage::create([
            'user_id' => $customer->id,
            'room_id' => $room->id,
            'message' => 'This is a test message from customer'
        ]);
        
        // Admin logs in and accesses the chat room
        $this->browse(function (Browser $browser) use ($admin, $room) {
            $browser->visit('/sign-in')
                ->type('email', $admin->email)
                ->type('password', 'password')
                ->press('Sign In')
                ->assertPathIs('/dashboard')
                
                // Navigate to chat history
                ->visit('/chat/history/' . $room->id)
                ->assertSee('Browser Test Chat Room')
                ->assertSee('This is a test message from customer')
                
                // Admin sends a reply
                ->type('#message-input', 'This is an admin reply message')
                ->press('Send')
                
                // Verify the message appears in the chat
                ->assertSee('This is an admin reply message')
                ->assertSee('Admin');
        });
        
        // Customer logs in and sees admin's response
        $this->browse(function (Browser $browser) use ($customer, $room) {
            $browser->visit('/sign-in')
                ->type('email', $customer->email)
                ->type('password', 'password')
                ->press('Sign In')
                ->assertPathIs('/dashboard')
                
                // Navigate to chat history
                ->visit('/chat/history/' . $room->id)
                ->assertSee('Browser Test Chat Room')
                ->assertSee('This is a test message from customer')
                ->assertSee('This is an admin reply message')
                ->assertSee('Admin');
        });
        
        // Cleanup
        $room->delete();
        $admin->delete();
        $customer->delete();
    }
}
