<?php
namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\Visit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class LogVisit
{
    public function handle($request, Closure $next)
    {
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();
        $user = Auth::user();
        $userId = $user ? $user->id : null;

        // Define the cache key based on the user type
        // If the user is logged in, use the user ID, else use IP address for guests
        $cacheKey = $userId ? "visit_user_{$userId}" : "visit_guest_{$ipAddress}";

        // Check if the visit was already logged in the last 24 hours
        if (!Cache::has($cacheKey)) {
            
            // Skip logging visits for admin users
            if ($user && $user->role === 'admin') {
                return $next($request);
            }

            // Log the visit in the database
            Visit::create([
                'user_id' => $userId,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
            ]);

            // Cache the visit to prevent re-logging for 24 hours
            Cache::put($cacheKey, true, now()->addDay());

            Log::info('Visit logged:', [
                'user_id' => $userId,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
            ]);
        } else {
            Log::info('Visit skipped due to recent activity.');
        }

        return $next($request);
    }
}