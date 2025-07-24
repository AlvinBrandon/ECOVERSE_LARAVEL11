<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\JavaVendorVerificationService;
use Illuminate\Support\Facades\Cache;

class CheckJavaServerAvailability
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cache the server status for 5 minutes to avoid constant checks
        $cacheKey = 'java_server_status';
        $cacheTime = 300; // 5 minutes
        
        $serverStatus = Cache::remember($cacheKey, $cacheTime, function () {
            $javaService = new JavaVendorVerificationService();
            return $javaService->testConnection();
        });
        
        if (!$serverStatus['success']) {
            return response()->json([
                'error' => 'Document verification service is currently unavailable. Please try again later.',
                'message' => 'The document verification system is temporarily down for maintenance.',
                'retry_after' => 300 // seconds
            ], 503);
        }
        
        return $next($request);
    }
}
