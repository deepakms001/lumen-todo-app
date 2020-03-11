<?php

namespace App\Operations\Auth;

use App\Models\User;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Signin
{
    public function run(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if (!$user) {
            throw new Exception('Email ID not registered with us.', 404);
        }
        if (Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'status' => 'success',
                'message' => 'Token generated successfully',
                'token' => $this->generateToken($user)
            ], 200);
        }
        throw new Exception('Email or password is wrong.', 401);
    }

    /**
     * Create a new token.
     * 
     * @param  \App\User   $user
     * @return string
     */
    private function generateToken(User $user)
    {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'user_type' => $user->user_type,
            'email' => $user->email,
            'iat' => time(), // Time when JWT was issued. 
            'exp' => time() + 60 * 60 // Expiration time
        ];
        return JWT::encode($payload, env('JWT_SECRET'));
    }
}
