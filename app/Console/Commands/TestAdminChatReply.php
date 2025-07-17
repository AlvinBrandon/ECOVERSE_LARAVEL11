<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use App\Events\NewChatMessage;
use Illuminate\Support\Facades\DB;

class TestAdminChatReply extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat:test-admin-reply';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test admin reply functionality for chat system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting admin reply test...');

        // Check if we have admin and non-admin users
        $admin = User::where('role', 'admin')->first();
        $nonAdmin = User::where('role', '!=', 'admin')->first();

        if (!$admin) {
            $this->error('No admin user found. Please create an admin user first.');
            return 1;
        }

        if (!$nonAdmin) {
            $this->error('No non-admin user found. Please create a non-admin user first.');
            return 1;
        }

        $this->info("Using admin user: {$admin->name} (ID: {$admin->id})");
        $this->info("Using non-admin user: {$nonAdmin->name} (ID: {$nonAdmin->id})");

        // Create a test chat room
        DB::beginTransaction();
        try {
            $room = ChatRoom::create([
                'name' => 'Test Admin Reply Room - ' . now()->format('Y-m-d H:i:s'),
                'type' => 'private',
                'description' => 'Test room created by Artisan command',
            ]);

            // Add the non-admin user to the room
            $room->users()->attach($nonAdmin->id);

            $this->info("Created test chat room: {$room->name} (ID: {$room->id})");

            // Create a message from the non-admin user
            $nonAdminMessage = ChatMessage::create([
                'user_id' => $nonAdmin->id,
                'room_id' => $room->id,
                'message' => 'This is a test message from a non-admin user.',
            ]);

            $this->info("Created non-admin message: {$nonAdminMessage->message}");

            // Create a message from the admin user (this should auto-add the admin to the room)
            $adminMessage = ChatMessage::create([
                'user_id' => $admin->id,
                'room_id' => $room->id,
                'message' => 'This is a test admin reply message.',
            ]);

            // Broadcast the admin message
            broadcast(new NewChatMessage($adminMessage));

            $this->info("Created and broadcast admin reply: {$adminMessage->message}");

            // Check if admin was added to the room
            if ($room->users()->where('users.id', $admin->id)->exists()) {
                $this->info("✓ Admin was successfully added to the chat room.");
            } else {
                // Add admin to the room if not already added
                $room->users()->attach($admin->id);
                $this->warn("Admin was not automatically added to the room. Adding now.");
            }

            // Verify the messages exist in the database
            $messages = ChatMessage::where('room_id', $room->id)->count();
            $this->info("Room has {$messages} messages in total.");

            DB::commit();
            $this->info('Test completed successfully!');

            // Show URL to view the test chat
            $url = url("/chat/history/{$room->id}");
            $this->info("You can view this test chat at: {$url}");

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Test failed: {$e->getMessage()}");
            return 1;
        }

        return 0;
    }
}
