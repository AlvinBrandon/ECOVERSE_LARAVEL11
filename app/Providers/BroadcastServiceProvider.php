<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Load broadcast routes file
        Broadcast::routes();

        // Required for proper channel authentication
        require base_path('routes/channels.php');
    }
}
