<?php

namespace App\DTOs;

class LoginData
{
    public function __construct(
        public string $username,
        public string $password,
        public string $ip
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            username: $request->input('username'),
            password: $request->input('password'),
            ip: $request->ip()
        );
    }
}
