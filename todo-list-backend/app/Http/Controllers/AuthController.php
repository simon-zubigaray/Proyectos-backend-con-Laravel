<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Business\Services\AuthService;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(UserRequest $request)
    {
        $validatedData = $request->validated();
        $this->authService->register($validatedData);
        return response()->json(["message" => "Usuario registrado correctamente."], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request)
    {
        $validatedData = $request->validated();
        $token = $this->authService->login($validatedData);

        if (!$token) {
            return response()->json(['error' => "Usuario o Contraseña inválida."], Response::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            "token" => $token,
            "token_type" => 'bearer',
            "expires_in" => auth()->factory()->getTTL()
        ]);
    }

    public function who()
    {
        $user = auth()->user();
        return response()->json($user);
    }

    public function logout()
    {
        try {
            $this->authService->logout();
            return response()->json(["message" => "Sesión cerrada correctamente"]);
        } catch (JWTException $e) {
            return response()->json(['error' => "Token inválido."], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function refresh()
    {
        try {
            $newToken = $this->authService->refresh();
            return $this->respondWithToken($newToken);
        } catch (JWTException $e) {
            return response()->json(["error" => "Error al refrescar el token"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
