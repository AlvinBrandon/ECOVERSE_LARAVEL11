<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class UpdateSalesForecast extends Command
{
    protected $signature = 'ml:forecast-sales';
    protected $description = 'Update sales forecast using ARIMA model';

    public function handle()
    {
        $this->info('Starting sales forecast update...');

        try {
            // Ensure the ML storage directory exists
            if (!Storage::exists('ml')) {
                Storage::makeDirectory('ml');
            }

            // Run Python script
            $pythonPath = 'python'; // or 'python3' depending on your system
            $scriptPath = base_path('app/ML/Scripts/sales_forecaster.py');
            
            $command = "{$pythonPath} {$scriptPath} 2>&1";
            $output = shell_exec($command);

            if ($output === null || stripos($output, 'error') !== false) {
                throw new \Exception("Python script error: " . $output);
            }

            $this->info('Sales forecast updated successfully!');
            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Error updating sales forecast: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
