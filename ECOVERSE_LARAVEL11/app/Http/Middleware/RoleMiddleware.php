<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Get user role - check both 'role' and 'role_as' fields
        $userRole = $user->role ?? null;
        $userRoleAs = $user->role_as ?? null;
        
        // Convert role_as to role name for compatibility
        $roleMap = [
            0 => 'customer',
            1 => 'admin', 
            2 => 'supplier',
            3 => 'staff',
            4 => 'retailer',
            5 => 'wholesaler'
        ];
        
        $mappedRole = $roleMap[$userRoleAs] ?? $userRole;
        
        // Check if user has any of the required roles
        $hasRole = false;
        foreach ($roles as $role) {
            if ($mappedRole === $role || $userRole === $role) {
                $hasRole = true;
                break;
            }
        }
        
        if (!$hasRole) {
            // If user doesn't have required role, redirect to appropriate dashboard or show error
            if ($mappedRole === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($mappedRole === 'supplier') {
                return redirect()->route('supplier.dashboard');
            } else {
                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
} 