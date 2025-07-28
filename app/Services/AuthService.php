<?php

namespace App\Services;

use App\DTOs\LoginData;
use App\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\RateLimiter;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Carbon;

class AuthService
{
    public function login(LoginData $data): JsonResponse
    {
        $throttleKey = 'auth:attempts:' . $data->ip;

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return ApiResponse::fail(
                'Too many login attempts. Please try again later in '
                    . $seconds . ' seconds',
                null,
                429
            );
        }

        $credentials = [
            'username' => $data->username,
            'password' => $data->password
        ];
        $token = auth()->attempt($credentials);

        if (!$token) {
            RateLimiter::hit($throttleKey);
            return ApiResponse::fail('Oops, your credentials does not match our records', null, 404);
        }

        RateLimiter::clear($throttleKey);

        return ApiResponse::success([
            'token' => [
                'accessToken' => $token,
                'tokenType' => 'Bearer',
                'expiresIn' => auth()->factory()->getTTL() . ' minutes'
            ]
        ]);
    }

    public function logout(): JsonResponse
    {
        JWTAuth::invalidate(true);
        auth()->logout();
        return ApiResponse::success(null, 'The access token has been successfully invalidated');
    }

    public function check(): JsonResponse
    {
        $token = JWTAuth::getToken()->get();
        $payload = JWTAuth::getPayload($token);

        return ApiResponse::success([
            'token' => [
                'accessToken' => $token,
                'issuedAt' => Carbon::createFromTimestamp($payload->get('iat'))->toDateTimeString(),
                'expiresAt' => Carbon::createFromTimestamp($payload->get('exp'))->toDateTimeString(),
                'ttlMinutes' => ($payload->get('exp') - $payload->get('iat')) / 60
            ]
        ]);
    }
}
