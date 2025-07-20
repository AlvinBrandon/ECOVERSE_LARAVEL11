<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class RefreshUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Get fresh user data from database
            $freshUser = User::find($user->id);
            
            // If role changed, update the authenticated user instance
            if ($freshUser && ($user->role_as !== $freshUser->role_as || $user->role !== $freshUser->role)) {
                // Update the authenticated user with fresh data
                Auth::setUser($freshUser);
                
                // Clear role-based cache
                Cache::forget("user_role_{$user->id}");
                Cache::forget("user_permissions_{$user->id}");
                Cache::forget("user_dashboard_{$user->id}");
                
                // If this is a dashboard request and role changed, redirect to correct dashboard
                if ($request->routeIs('dashboard') && $user->role_as !== $freshUser->role_as) {
                    session()->flash('info', 'Your role has been updated. Redirecting to your new dashboard.');
                    return redirect()->route('dashboard');
                }
            }
        }
        
        return $next($request);
    }
}
