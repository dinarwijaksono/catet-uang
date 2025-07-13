<?php

namespace App\Http\Middleware;

use App\Service\UserService;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class MissingTokenMiddelware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userService = App::make(UserService::class);

        if (!is_null($request->header('api-token'))) {

            $apiToken = $userService->findByToken($request->header('api-token'));

            if (Carbon::parse($apiToken->expired_at)->diffInSeconds(now()) < 0) {
                Log::warning('token belum expired.', [
                    'token' => $request->header('api-token')
                ]);

                return response()->json([
                    'errors' => [
                        'general' => 'Token belum expired.'
                    ]
                ], 403);
            }
        }

        return $next($request);
    }
}
