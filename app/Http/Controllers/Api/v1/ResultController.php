<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ResultResource;
use App\UseCases\Services\TicketService;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ResultController extends Controller
{
    public $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function index(Request $request, $token): Response
    {
        return response(new ResultResource($this->ticketService->imfeelinglucky($token)), Response::HTTP_ACCEPTED);
    }

    public function history(Request $request, $token): AnonymousResourceCollection
    {
        return ResultResource::collection($this->ticketService->history($token));
    }
}
