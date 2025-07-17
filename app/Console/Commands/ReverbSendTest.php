<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Broadcast;

class ReverbSendTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reverb:send-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test message through Reverb to verify WebSocket functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Sending test message via Reverb...');
        
        try {
            // Send a message on the public test channel
            Broadcast::channel('test-channel', function ($user) {
                return true; // Allow anyone to listen to this channel
            });
            
            // Broadcast a test event on the public channel
            broadcast(new \App\Events\TestMessage([
                'message' => 'This is a test message from Reverb!',
                'timestamp' => now()->toIso8601String(),
                'server_id' => uniqid('server_')
            ]))->toOthers();
            
            $this->info('Test message sent successfully!');
            $this->info('Check browser console for "test.message" event on "test-channel"');
            
            return 0;
        } catch (\Exception $e) {
            $this->error('Failed to send test message: ' . $e->getMessage());
            return 1;
        }
    }
}
