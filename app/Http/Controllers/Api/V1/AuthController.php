<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Http\Requests\V1\Auth\RegisterRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $registerRequest)
    {
        $email = $registerRequest->input('email');
        $password = $registerRequest->input('password');

        $user = User::query()->create([
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $token = $user->createToken('api-v1');
        return response()->json([
            'data' => $token->plainTextToken
        ], 201);
    }

    public function login(LoginRequest $loginRequest)
    {
        $email = $loginRequest->input('email');
        $password = $loginRequest->input('password');

        $user = User::query()->where('email', $email)->first();

        if ($user and (Hash::check($password, $user->password))) {
            $token = $user->createToken('api-v1');
            return response()->json([
                'data' => $token->plainTextToken
            ], 200);
        }
        //else
        return response()->json([
            'msg' => 'email or password is wrong!'
        ], 422);
    }
}
