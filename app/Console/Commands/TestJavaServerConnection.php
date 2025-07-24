<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\JavaVendorVerificationService;

class TestJavaServerConnection extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'java:test-connection';

    /**
     * The console command description.
     */
    protected $description = 'Test connection to Java document verification server';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Java server connection...');
        
        $javaService = new JavaVendorVerificationService();
        $result = $javaService->testConnection();
        
        if ($result['success']) {
            $this->info('✅ Successfully connected to Java server');
            $this->info('Status: ' . $result['status']);
            
            if (isset($result['server_info'])) {
                $this->info('Server Info:');
                $this->table(['Key', 'Value'], collect($result['server_info'])->map(function ($value, $key) {
                    return [$key, is_array($value) ? json_encode($value) : $value];
                })->toArray());
            }
        } else {
            $this->error('❌ Failed to connect to Java server');
            $this->error('Status: ' . $result['status']);
            $this->error('Error: ' . $result['error']);
            
            $this->newLine();
            $this->info('Configuration check:');
            $this->info('Java Server URL: ' . config('java_server.url'));
            $this->info('API Key configured: ' . (config('java_server.api_key') ? 'Yes' : 'No'));
            $this->info('Timeout: ' . config('java_server.timeout') . 's');
        }
    }
}
