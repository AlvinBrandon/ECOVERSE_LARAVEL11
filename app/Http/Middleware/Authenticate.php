<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next, ...$guards)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            // Clear any remaining session data
            if ($request->session()) {
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }
            
            // Redirect to login
            return redirect()->route('login');
        }
        
        // Add no-cache headers to prevent back button access
        $response = $next($request);
        
        return $response->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
                       ->header('Pragma', 'no-cache')
                       ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): string
    {
        return $request->expectsJson() ? null : route('login');
    }
}
