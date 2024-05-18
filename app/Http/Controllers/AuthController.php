<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $rules = [
            'email' => ["required", "email", "max:255"],
            "password" => [
                "required",
                "string",
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()
                ->json($validator->errors());
        }

        $credentials = $request->only("email", "password", "name");

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return response()->json(["error" => "Unauthorized"], 401);
    }

    private function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function logout()
    {
        try {
            auth()->logout();
        } catch (JWTException $JWTException) {
            throw $JWTException;
        }

        return response()->json(["message" => "User logged out successfully"]);
    }

    public function refresh()
    {
        try {
            if (!$token = auth()->getToken()) {
                throw new NotFoundHttpException("Token does not exist");
            }

            return $this->respondWithToken(auth()->refresh($token));
        } catch (JWTException $JWTException) {
            throw $JWTException;
        }
    }

    public function guard()
    {
        return Auth::guard();
    }

    public function me()
    {
        return response()->json($this->guard()->user());
    }
} 
