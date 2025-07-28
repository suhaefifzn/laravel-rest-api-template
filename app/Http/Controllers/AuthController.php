<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Services\AuthService;
use App\Http\Requests\LoginRequest;
use App\DTOs\LoginData;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    public function login(LoginRequest $request)
    {
        $data = LoginData::fromRequest($request);
        return $this->authService->login($data);
    }

    public function logout()
    {
        return $this->authService->logout();
    }

    public function check()
    {
        return $this->authService->check();
    }
}
