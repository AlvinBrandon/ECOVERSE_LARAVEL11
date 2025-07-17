<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized action.');
        }

        // Support both string and int role checks
        $roleMap = [
            'customer' => 0,
            'admin' => 1,
            'retailer' => 2,
            'staff' => 3,
            'supplier' => 4,
            'wholesaler' => 5,
        ];

        $userRoles = [$user->role];
        if (isset($user->role_as)) {
            $userRoles[] = $user->role_as;
        }

        // Also allow string/int mapping
        foreach ($roles as $role) {
            if (in_array($role, $userRoles)) {
                return $next($request);
            }
            if (isset($roleMap[$role]) && in_array($roleMap[$role], $userRoles)) {
                return $next($request);
            }
        }
        abort(403, 'Unauthorized action.');
    }
}
