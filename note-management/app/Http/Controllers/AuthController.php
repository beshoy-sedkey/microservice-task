<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\AuthRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            // Attempt to verify the credentials and create a token for the user
            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            // Now return this token as part of the JSON response
            return response()->json(['token' => $token]);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

    }
}
