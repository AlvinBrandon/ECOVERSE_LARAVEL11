<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Check if user is admin - check both 'role' and 'role_as' fields
        $userRole = $user->role ?? null;
        $userRoleAs = $user->role_as ?? null;
        
        // User is admin if role is 'admin' or role_as is 1
        $isAdmin = ($userRole === 'admin') || ($userRoleAs === 1);
        
        if (!$isAdmin) {
            // Redirect to appropriate dashboard based on user role
            if ($userRoleAs === 2) {
                return redirect()->route('supplier.dashboard');
            } else {
                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
} 