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

    /**
     * @lrd:start
     * Get random value in and amount percentage of value if it even.
     *
     * @param string $token The token to get the value for.
     * @return \Illuminate\Http\Response The HTTP response containing the result.
     * @lrd:end
     */
    public function index(Request $request, $token): Response
    {
        return response(new ResultResource($this->ticketService->imfeelinglucky($token)), Response::HTTP_ACCEPTED);
    }

    /**
     * @lrd:start
     * Retrieve the history of results for a given token.
     *
     * @param string $token The token to retrieve the history for.
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection The collection of result resources.
     * @lrd:end
     */
    public function history(Request $request, $token): AnonymousResourceCollection
    {
        return ResultResource::collection($this->ticketService->history($token));
    }
}
