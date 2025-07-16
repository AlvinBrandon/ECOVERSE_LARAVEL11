<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StartReverbServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reverb:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the Laravel Reverb WebSocket server';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting Laravel Reverb WebSocket server...');
        $this->info('Press Ctrl+C to stop the server.');
        
        $this->call('reverb:start');
        
        return Command::SUCCESS;
    }
}
