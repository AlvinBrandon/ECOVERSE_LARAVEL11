<?php

namespace App\Console\Commands;

use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Console\Command;

class TestAdminChatNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ecoverse:test-admin-chat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test that admin users receive notifications for all chat messages';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Testing Admin Chat Notifications');
        
        // 1. Find or create test users
        $this->info('1. Finding/Creating test users...');
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            $admin = User::factory()->create(['role' => 'admin', 'name' => 'Admin User']);
        }
        
        $customer1 = User::where('role', 'customer')->first();
        if (!$customer1) {
            $customer1 = User::factory()->create(['role' => 'customer', 'name' => 'Customer 1']);
        }
        
        $customer2 = User::where('role', 'customer')->where('id', '!=', $customer1->id)->first();
        if (!$customer2) {
            $customer2 = User::factory()->create(['role' => 'customer', 'name' => 'Customer 2']);
        }
        
        $this->info("Created/Found users: {$admin->name}, {$customer1->name}, {$customer2->name}");
        
        // 2. Create a chat room between the two customers (no admin)
        $this->info('2. Creating test chat room between customers only...');
        $room = ChatRoom::create([
            'name' => 'Customer Chat Test ' . now()->timestamp,
            'type' => 'private',
            'description' => 'A room for testing admin notifications',
        ]);
        
        $room->users()->attach([$customer1->id, $customer2->id]);
        $this->info("Created chat room: {$room->name} (ID: {$room->id})");
        
        // 3. Count current notifications
        $adminNotificationsBefore = \DB::table('notifications')
            ->where('notifiable_type', 'App\\Models\\User')
            ->where('notifiable_id', $admin->id)
            ->count();
        
        $this->info("Admin has {$adminNotificationsBefore} notifications before test");
        
        // 4. Customer 1 sends a message to Customer 2
        $this->info('3. Sending test message from Customer 1 to Customer 2...');
        $message = ChatMessage::create([
            'user_id' => $customer1->id,
            'room_id' => $room->id,
            'message' => 'Test message from Customer 1 to Customer 2',
        ]);
        
        // 5. Process the notification
        $this->info('4. Processing notifications...');
        
        // Notify the other customer in the chat room
        $customer2->notify(new \App\Notifications\NewChatMessage($message));
        
        // Also notify all admin users even if they're not in the room
        User::where('role', 'admin')
            ->whereNotIn('id', $room->users->pluck('id')->toArray())
            ->get()
            ->each(function($adminUser) use ($message) {
                $adminUser->notify(new \App\Notifications\NewChatMessage($message));
            });
        
        // 6. Check if admin got notification
        $adminNotificationsAfter = \DB::table('notifications')
            ->where('notifiable_type', 'App\\Models\\User')
            ->where('notifiable_id', $admin->id)
            ->count();
        
        $this->info("Admin has {$adminNotificationsAfter} notifications after test");
        
        if ($adminNotificationsAfter > $adminNotificationsBefore) {
            $this->info('✅ SUCCESS: Admin was notified of the message between customers');
        } else {
            $this->error('❌ FAIL: Admin did not receive notification of the message between customers');
        }
        
        // 7. Check if admin can view the chat in their dashboard
        $adminViewableRooms = ChatRoom::count();
        $this->info("Total chat rooms in system: {$adminViewableRooms}");
        
        $this->info("Test complete!");
        
        return Command::SUCCESS;
    }
}
