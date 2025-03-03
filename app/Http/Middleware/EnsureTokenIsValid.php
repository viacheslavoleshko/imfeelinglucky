<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->route('token');
        $user = User::where('url_token', $token)->first();

        if (!$user || $user->id !== auth()->user()->id) {
            return response(['message' => 'Invalid URL.'], Response::HTTP_FORBIDDEN);
        }

        if (now()->greaterThan($user->url_token_expires_at)) {
            return response(['message' => 'URL expired.'], Response::HTTP_FORBIDDEN);
        }
        return $next($request);
    }
}
