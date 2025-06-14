<?php

namespace App\Business\Services;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthService
{
    public function register(array $data): User
    {
        return User::create([
            'name' => $data["name"],
            'email' => $data["email"],
            'password' => bcrypt($data["password"])
        ]);
    }

    public function login(array $credentials): ?string
    {
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return null;
            }
            return $token;
        } catch (JWTException) {
            throw new \Exception("No se pudo generar el token.");
        }
    }

    public function logout(): void
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }

    public function refresh(): string
    {
        return JWTAuth::refresh(JWTAuth::getToken());
    }
}