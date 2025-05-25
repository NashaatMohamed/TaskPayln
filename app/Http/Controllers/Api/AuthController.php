<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\UpdateUserRequest;
use App\Http\Resources\AuthResource;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{

    public function __construct(protected AuthService $authService){}


    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $auth = $this->authService->register($request);
            return $this->dataResponse(msg: ("Register_successfully"), data: AuthResource::make($auth));
        } catch (\Exception $e) {
            return $this->errorResponse(msg: $e->getMessage(),code: 400);
        }
    }
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $auth = $this->authService->login($request);
            return $this->dataResponse(msg: ("Login_successfully"), data: AuthResource::make($auth));
        } catch (\Exception $e) {
            return $this->errorResponse(msg: $e->getMessage(),code: 400);
        }
    }

    public function logout(): JsonResponse
    {
        $auth = auth()->user();
        $this->authService->logout($auth);
        return $this->successResponse(msg: ("Logout_successfully"));
    }

    public function getUser(): JsonResponse
    {
        $auth = auth()->user();
        return $this->dataResponse(msg: ("Get_user_successfully"), data: UserResource::make($auth));
    }

    public function updateUser(UpdateUserRequest $request): JsonResponse
    {
        $data = $request->validated();
        $auth = auth()->user();
        $auth->update($data);
        return $this->dataResponse(msg: ("Update_user_successfully"), data: UserResource::make($auth));
    }

}
