<?php

namespace App\Domain\Auth\Services;

use App\Domain\User\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function login(string $email, string $password, string $deviceName = 'web')
    {
        $user = User::where('email', $email)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['As credenciais fornecidas estão incorretas.'],
            ]);
        }

        // Revoke old tokens if you want single session per device,
        // or just let them pile up (Sanctum default behavior is allow multiple)
        // $user->tokens()->where('name', $deviceName)->delete();

        // Create new token with expiration
        // Sanctum by default doesn't expire tokens unless configured in sanctum.php
        // However, we can use expiration capability if configured

        $token = $user->createToken($deviceName);

        return [
            'access_token' => $token->plainTextToken,
            'token_type' => 'Bearer',
            'user' => $user,
        ];
    }

    public function logout($user)
    {
        // Revoke current token
        $user->currentAccessToken()->delete();
    }

    public function me($user)
    {
        return $user;
    }

    public function refresh($user)
    {
        // Delete current token
        $user->currentAccessToken()->delete();

        // Create new token
        $token = $user->createToken('web_refreshed');

        return [
            'access_token' => $token->plainTextToken,
            'token_type' => 'Bearer',
            'user' => $user,
        ];
    }
}
