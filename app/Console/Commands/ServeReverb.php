<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class ServeReverb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reverb:high-memory 
                            {--host=0.0.0.0 : The host address to serve the application on} 
                            {--port=8080 : The port to serve the application on} 
                            {--memory=2048M : Memory limit for PHP}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the Laravel Reverb WebSocket server with increased memory limit';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Set memory limit for current process
        $memoryLimit = $this->option('memory');
        ini_set('memory_limit', $memoryLimit);
        
        $this->info("Starting Laravel Reverb WebSocket server with {$memoryLimit} memory");
        $this->info("Host: {$this->option('host')}");
        $this->info("Port: {$this->option('port')}");
        
        // Start Reverb server
        $this->info('------------------------------------------');
        
        // Check if running in Windows
        $isWindows = PHP_OS_FAMILY === 'Windows';
        
        if ($isWindows) {
            // For Windows, try to use start-reverb.php script
            if (file_exists(base_path('start-reverb.php'))) {
                $this->info('Using start-reverb.php script for Windows');
                $process = Process::fromShellCommandline('php -d memory_limit=' . $memoryLimit . ' start-reverb.php');
                $process->setTimeout(null);
                $process->setTty(false);
            } else {
                // Fallback to direct command
                $this->info('Using direct command for Windows');
                $process = new Process([
                    'php', 
                    '-d', 'memory_limit=' . $memoryLimit,
                    'artisan',
                    'reverb:start',
                ]);
                $process->setTimeout(null);
                $process->setTty(false);
            }
        } else {
            // For Unix systems
            $process = new Process([
                'php', 
                '-d', 'memory_limit=' . $memoryLimit,
                'artisan',
                'reverb:start',
            ]);
            $process->setTimeout(null);
            $process->setTty(true);
        }
        
        try {
            $process->run(function ($type, $buffer) {
                $this->output->write($buffer);
            });
            
            if (!$process->isSuccessful()) {
                $this->error('Failed to start Reverb: ' . $process->getErrorOutput());
                $this->info('Trying alternative method...');
                
                // Try an alternative method
                if ($isWindows) {
                    $this->info('Using PowerShell to start Reverb with high memory');
                    $command = 'powershell -Command "php -d memory_limit=' . $memoryLimit . ' artisan reverb:start"';
                    $process = Process::fromShellCommandline($command);
                    $process->setTimeout(null);
                    $process->run(function ($type, $buffer) {
                        $this->output->write($buffer);
                    });
                }
            }
            
        } catch (\Exception $e) {
            $this->error('Failed to start Reverb: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
