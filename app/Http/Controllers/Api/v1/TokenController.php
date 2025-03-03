<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TokenResource;
use App\UseCases\Services\TokenService;
use Symfony\Component\HttpFoundation\Response;

class TokenController extends Controller
{
    public $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    public function regenerate(Request $request, $token): Response
    {
        return response(new TokenResource($this->tokenService->regenerate($token)), Response::HTTP_ACCEPTED);
    }

    public function revoke(Request $request, $token): Response
    {
        $this->tokenService->delete($token);
        return response( ['message' => 'Token succesfuly revoked.'], Response::HTTP_ACCEPTED);
    }
}
