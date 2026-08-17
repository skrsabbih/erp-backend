<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // only handle the request for auth routes
    public function __construct(protected AuthService $authService){}

    // handle the register request
    public function register(RegisterRequest $request): JsonResponse
    {
        // user validation and create user
        $validation = $request->validated();
        $user = $this->authService->register($validation);

        // return success response
        return response()->json([
            'message' => 'User registered successfully',
            'user' => new UserResource($user['user']),
            'token' => $user['token'],
        ], 201);
    }

    // handle the logic request
    public function login(LoginRequest $request): JsonResponse
    {
        // user validation and login
        $validation = $request->validated();
        $user = $this->authService->login($validation);

        // return success response
        return response()->json([
            'message' => 'User logged in successfully',
            'user' => new UserResource($user['user']),
            'token' => $user['token'],
        ], 200);
    }

    // handle the logout request
    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());
        return response()->json([
            'message' => 'User Logout Successfully',
        ]);
    }

    // handle the me request
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'User Identify Successfully',
            'user' => new UserResource($request->user()),
        ]);
    }

}


