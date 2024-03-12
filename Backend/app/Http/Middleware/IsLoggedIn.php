<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class IsLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!isset($request->token) || !$request->token) {
            return response()->json(["message" => "Unauthorize user"], 401);
        }

        $user = User::where('login_tokens', $request->token)->first();

        if(!$user) return response()->json(["message" => "Unauthorize user"], 401);

        return $next($request);
    }
}
