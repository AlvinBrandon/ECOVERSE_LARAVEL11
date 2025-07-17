<?php
/**
 * Laravel Reverb Starter Script with Increased Memory Limit
 * 
 * This script starts the Laravel Reverb WebSocket server with an increased
 * memory limit to prevent "Allowed memory size exhausted" errors.
 */

// Set memory limit to 2GB
ini_set('memory_limit', '2048M');

// Get the application base path
$basePath = __DIR__;

// Define the artisan file path
$artisanPath = $basePath . '/artisan';

// Require the Composer autoloader
require $basePath . '/vendor/autoload.php';

// Load the Laravel application
$app = require_once $basePath . '/bootstrap/app.php';

// Get the Console Kernel instance
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Run the reverb:start command
$status = $kernel->handle(
    $input = new Symfony\Component\Console\Input\ArrayInput([
        'command' => 'reverb:start',
    ]),
    new Symfony\Component\Console\Output\ConsoleOutput
);

// Terminate the application
$kernel->terminate($input, $status);

// Return the exit code
exit($status);
