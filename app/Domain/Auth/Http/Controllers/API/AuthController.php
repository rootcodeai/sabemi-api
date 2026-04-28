<?php

namespace App\Domain\Auth\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Domain\Auth\Services\AuthService;
use App\Domain\Auth\Http\Requests\API\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Response;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Unauthenticated;

#[Group("Authentication", "APIs for managing user authentication")]
class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    #[Endpoint("Login", "Authenticate a user and return an access token.")]
    #[Unauthenticated]
    #[BodyParam("email", "string", "The user's email address.", example: "student@example.com")]
    #[BodyParam("password", "string", "The user's password.", example: "password")]
    #[BodyParam("device_name", "string", "The name of the device requesting the token.", required: false, example: "My iPhone")]
    #[Response([
        "access_token" => "1|mz2Q...",
        "token_type" => "Bearer",
        "user" => [
            "id" => 1,
            "name" => "Student User",
            "email" => "student@example.com",
            "role" => "student",
            "created_at" => "2023-10-01T12:00:00.000000Z",
            "updated_at" => "2023-10-01T12:00:00.000000Z"
        ]
    ], 200)]
    #[Response(["message" => "The given data was invalid.", "errors" => ["email" => ["The email field is required."]]], 422)]
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $this->authService->login(
            $request->email,
            $request->password,
            $request->device_name ?? 'web'
        );

        return response()->json($data);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());
        return response()->json(['message' => 'Logged out successfully']);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }

    public function refresh(Request $request): JsonResponse
    {
        $data = $this->authService->refresh($request->user());
        return response()->json($data);
    }
}
