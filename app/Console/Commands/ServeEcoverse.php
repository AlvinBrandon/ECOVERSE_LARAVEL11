<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class ServeEcoverse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ecoverse:serve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the Laravel development server and Vite server';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting EcoVerse development environment...');
        
        // Start Laravel server
        $laravelServer = new Process(['php', 'artisan', 'serve']);
        $laravelServer->setTty(true);
        $laravelServer->start();
        
        $this->info('Laravel development server started on http://127.0.0.1:8000');
        
        // Start Vite server
        $viteServer = new Process(['npm', 'run', 'dev']);
        $viteServer->setTty(true);
        $viteServer->start();
        
        $this->info('Vite development server started on http://localhost:5173');
        
        $this->info('All services are running. Press Ctrl+C to stop all servers.');
        
        // Wait for processes
        while ($laravelServer->isRunning() && $viteServer->isRunning()) {
            sleep(1);
        }
        
        // Clean up if any process stops
        if ($laravelServer->isRunning()) {
            $laravelServer->stop();
        }
        
        if ($viteServer->isRunning()) {
            $viteServer->stop();
        }
        
        return Command::SUCCESS;
    }
}
