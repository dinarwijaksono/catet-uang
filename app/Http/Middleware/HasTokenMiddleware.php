<?php

namespace App\Http\Middleware;

use App\Service\UserService;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class HasTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userService = App::make(UserService::class);

        $apiToken = $userService->findByToken($request->header('api-token'));

        if (!$apiToken) {
            Log::warning('token tidak valid', [
                'token' => $request->header('api-token')
            ]);

            return response()->json([
                'errors' => [
                    'general' => 'Token tidak valid.'
                ]
            ], 403);
        }

        if (Carbon::parse($apiToken->expired_at)->diffInSeconds(now()) > 0) {
            Log::warning('token sudah expired.', [
                'token' => $request->header('api-token')
            ]);

            return response()->json([
                'errors' => [
                    'general' => 'Token sudah expired.'
                ]
            ], 403);
        }

        return $next($request);
    }
}
