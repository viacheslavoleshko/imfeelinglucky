<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\UseCases\Services\RegisterService;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    /**
     * @lrd:start
     * This method allows the user to register with the system
     * @lrd:end
     */
    public function register(RegisterRequest $request): Response
    {
        $registeredUser = $this->registerService->register($request);

        $token = $registeredUser->createToken('api-token',['*'], now()->addMinutes((int) config('sanctum.expiration')))->plainTextToken;

        return response([
            'user' => $registeredUser,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => now()->addMinutes((int) config('sanctum.expiration')),
        ], Response::HTTP_CREATED);

    }

    /**
     * @lrd:start
     * This method login user to system
     * @lrd:end
     */
    public function login(LoginRequest $request): Response
    {
        $credentials = $request->only(['phonenumber', 'password']);

        if (!auth()->attempt($credentials)) {
            return response(['message' => 'Invalid credentials.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $token = auth()->user()->createToken('api-token', ['*'], now()->addMinutes((int) config('sanctum.expiration')))->plainTextToken;

        return response([
            'user' => auth()->user(),
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => now()->addMinutes((int) config('sanctum.expiration')),
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * @lrd:start
     * This method allows user to logout
     * @lrd:end
     */
    public function logout(Request $request): Response
    {
        $request->user()->currentAccessToken()->delete();
        return response(['message' => 'Successfully logged out.'], Response::HTTP_ACCEPTED);
    }
}