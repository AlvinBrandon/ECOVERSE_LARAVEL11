<?php

namespace App\Console\Commands;

use App\Events\NewChatMessage;
use App\Events\UserOnlineStatus;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\User;
use App\Notifications\NewChatMessage as NewChatMessageNotification;
use Illuminate\Console\Command;

class TestChatFunction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ecoverse:test-chat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the chat functionality without running browser tests';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Testing EcoVerse Chat Functionality');
        
        // 1. Create test users
        $this->info('1. Creating test users...');
        $admin = User::where('role', 'admin')->first() ?: User::factory()->create(['role' => 'admin', 'name' => 'Admin User']);
        $customer = User::where('role', 'customer')->first() ?: User::factory()->create(['role' => 'customer', 'name' => 'Customer User']);
        $vendor = User::where('role', 'vendor')->first() ?: User::factory()->create(['role' => 'vendor', 'name' => 'Vendor User']);
        
        $this->info("Created/Found users: {$admin->name}, {$customer->name}, {$vendor->name}");
        
        // 2. Create a chat room
        $this->info('2. Creating test chat room...');
        $room = ChatRoom::create([
            'name' => 'Test Chat Room ' . now()->timestamp,
            'type' => 'group',
            'description' => 'A room for testing chat functionality',
        ]);
        
        $room->users()->attach([$admin->id, $customer->id, $vendor->id]);
        $this->info("Created chat room: {$room->name} (ID: {$room->id})");
        
        // 3. Send test messages
        $this->info('3. Sending test messages...');
        $messages = [
            ['user' => $admin, 'message' => 'Hello from Admin!'],
            ['user' => $customer, 'message' => 'Hello from Customer!'],
            ['user' => $vendor, 'message' => 'Hello from Vendor!'],
            ['user' => $admin, 'message' => 'Is everyone seeing this message?'],
        ];
        
        foreach ($messages as $messageData) {
            $message = ChatMessage::create([
                'user_id' => $messageData['user']->id,
                'room_id' => $room->id,
                'message' => $messageData['message'],
            ]);
            
            $this->info("Message from {$messageData['user']->name}: {$messageData['message']}");
            
            // Test broadcasting (this won't actually send, but it tests the event creation)
            try {
                event(new NewChatMessage($message));
                $this->info("- Broadcast event triggered");
            } catch (\Exception $e) {
                $this->error("- Failed to broadcast message: {$e->getMessage()}");
            }
            
            // Test notifications
            try {
                $room->users()
                    ->where('users.id', '!=', $messageData['user']->id)
                    ->get()
                    ->each(function($recipient) use ($message) {
                        $recipient->notify(new NewChatMessageNotification($message));
                    });
                $this->info("- Notifications sent to other users");
            } catch (\Exception $e) {
                $this->error("- Failed to send notifications: {$e->getMessage()}");
            }
        }
        
        // 4. Test user status
        $this->info('4. Testing user status events...');
        try {
            event(new UserOnlineStatus($admin, 'online'));
            $this->info("- User status event (online) triggered for {$admin->name}");
            
            event(new UserOnlineStatus($customer, 'offline'));
            $this->info("- User status event (offline) triggered for {$customer->name}");
        } catch (\Exception $e) {
            $this->error("- Failed to broadcast user status: {$e->getMessage()}");
        }
        
        // 5. Check database for messages
        $this->info('5. Verifying database records...');
        $messageCount = ChatMessage::where('room_id', $room->id)->count();
        $this->info("- Found {$messageCount} messages in the database (expected: " . count($messages) . ")");
        
        // 6. Check for notifications
        $notificationCount = \DB::table('notifications')->count();
        $this->info("- Found {$notificationCount} notifications in the database");
        
        $this->info('Chat functionality test complete!');
        
        return Command::SUCCESS;
    }
}
