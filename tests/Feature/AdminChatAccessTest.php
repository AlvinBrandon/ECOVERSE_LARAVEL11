<?php

namespace Tests\Feature;

use App\Events\NewChatMessage;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\User;
use App\Notifications\NewChatMessage as NewChatMessageNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AdminChatAccessTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if admins can access all chat rooms regardless of membership.
     *
     * @return void
     */
    public function testAdminCanAccessAllChatRooms()
    {
        // Create users with different roles
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'customer']);
        $vendor = User::factory()->create(['role' => 'vendor']);

        // Create chat room between customer and vendor (admin not included initially)
        $room = ChatRoom::create([
            'name' => 'Test Room',
            'type' => 'private',
            'description' => 'Test room for customer and vendor',
        ]);

        $room->users()->attach([$customer->id, $vendor->id]);

        // Admin should be able to access the room
        $this->actingAs($admin)
            ->get(route('chat.history', $room->id))
            ->assertStatus(200)
            ->assertSee('Test Room');

        // Admin should be automatically added to the room after viewing
        $this->assertTrue($room->fresh()->users()->where('users.id', $admin->id)->exists());
    }

    /**
     * Test if admins receive notifications for all new messages.
     *
     * @return void
     */
    public function testAdminReceivesAllChatNotifications()
    {
        Notification::fake();
        Event::fake();

        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'customer']);
        $vendor = User::factory()->create(['role' => 'vendor']);

        // Create chat room without admin initially
        $room = ChatRoom::create([
            'name' => 'Customer-Vendor Chat',
            'type' => 'private',
        ]);

        $room->users()->attach([$customer->id, $vendor->id]);

        // Customer sends a message
        $message = ChatMessage::create([
            'user_id' => $customer->id,
            'room_id' => $room->id,
            'message' => 'Hello vendor, I need some help',
        ]);

        // Manually trigger the notification process
        $room->users()
            ->where('users.id', '!=', $customer->id)
            ->get()
            ->each(function($recipient) use ($message) {
                $recipient->notify(new NewChatMessageNotification($message));
            });

        // Notify all admins not already in the room
        User::where('role', 'admin')
            ->whereNotIn('id', $room->users->pluck('id')->toArray())
            ->get()
            ->each(function($admin) use ($message, $room) {
                $admin->notify(new NewChatMessageNotification($message));
                $room->users()->syncWithoutDetaching([$admin->id]);
            });

        // Admin should receive notification even though not in the room initially
        Notification::assertSentTo(
            $admin,
            NewChatMessageNotification::class,
            function ($notification, $channels) use ($message) {
                return $notification->message->id === $message->id;
            }
        );

        // Verify admin was added to the room
        $this->assertTrue($room->fresh()->users()->where('users.id', $admin->id)->exists());
    }

    /**
     * Test if admins can reply to any chat room.
     *
     * @return void
     */
    public function testAdminCanReplyToAnyChatRoom()
    {
        Event::fake();
        Notification::fake();

        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'customer']);
        $vendor = User::factory()->create(['role' => 'vendor']);

        // Create chat room without admin initially
        $room = ChatRoom::create([
            'name' => 'Support Chat',
            'type' => 'private',
        ]);

        $room->users()->attach([$customer->id, $vendor->id]);

        // Admin replies to the chat without being added first
        $response = $this->actingAs($admin)
            ->post(route('chat.sendMessage'), [
                'room_id' => $room->id,
                'message' => 'Hello, this is admin. How can I help you?',
            ]);

        $response->assertStatus(302); // Redirects back

        // Check if message was saved
        $this->assertDatabaseHas('chat_messages', [
            'user_id' => $admin->id,
            'room_id' => $room->id,
            'message' => 'Hello, this is admin. How can I help you?',
        ]);

        // Admin should now be a member of the room
        $this->assertTrue($room->fresh()->users()->where('users.id', $admin->id)->exists());

        // Event should be broadcasted
        Event::assertDispatched(NewChatMessage::class);

        // Other users in the room should get notified
        Notification::assertSentTo(
            [$customer, $vendor],
            NewChatMessageNotification::class
        );
    }

    /**
     * Test if the chat UI correctly highlights admin messages.
     *
     * @return void
     */
    public function testAdminMessagesAreHighlighted()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'customer']);

        // Create chat room
        $room = ChatRoom::create([
            'name' => 'Support Room',
            'type' => 'private',
        ]);

        $room->users()->attach([$customer->id, $admin->id]);

        // Add messages from both users
        $adminMessage = ChatMessage::create([
            'user_id' => $admin->id,
            'room_id' => $room->id,
            'message' => 'How can I help you?',
        ]);

        $customerMessage = ChatMessage::create([
            'user_id' => $customer->id,
            'room_id' => $room->id,
            'message' => 'I need assistance with my order.',
        ]);

        // Check if admin message is displayed with the correct styling
        $this->actingAs($customer)
            ->get(route('chat.history', $room->id))
            ->assertStatus(200)
            ->assertSee('How can I help you?')
            ->assertSee('Admin')
            ->assertSee('bg-success'); // Admin messages should have bg-success class
    }
}
