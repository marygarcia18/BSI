<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            // If using Laravel Sanctum, you don't typically need a separate JWT middleware
            // as Sanctum already handles token authentication
            // This is provided as a placeholder in case you want to implement custom JWT logic
            $user = Auth::guard('api')->user();
            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'Token invalid or expired'], 401);
        }

        return $next($request);
    }
}