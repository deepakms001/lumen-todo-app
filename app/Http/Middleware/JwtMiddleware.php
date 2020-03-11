<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class JwtMiddleware {

    public function handle($request, Closure $next, $guard = null) {
        $token = $request->header('token');
        if (!$token) {
            return response()->json(['status' => 'failed', 'message' => 'Token not provided'], 401);
        }
        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch (ExpiredException $e) {
            return response()->json(['status' => 'failed', 'message' => 'Provided token is expired'], 400);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => 'Invalid token provided'], 400);
        }
        $user = User::find($credentials->sub);
        $request->auth = $user;
        return $next($request);
    }

}
