<?php

namespace App\Http\Controllers;

use App\Http\Resources\SlotResource;
use Illuminate\Http\Request;
use App\Providers\SlotService;
use OpenApi\Attributes as OA;

class SlotController extends Controller
{
    public function __construct(private readonly SlotService $slotService)
    {}

    #[OA\Get(
        path: '/api/slots',
        summary: 'Показ всех слотов',
        tags: ['slots'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Список слотов',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: '#/components/schemas/SlotResource')
                )
            ),
        ]
    )]
    public function list(Request $request)
    {
        $slots = $this->slotService->list($request);
        return response()->json(SlotResource::collection($slots));
    }
}
