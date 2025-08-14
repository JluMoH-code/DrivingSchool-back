<?php

namespace App\Http\Controllers;

use App\Http\Requests\SlotsListRequest;
use App\Http\Resources\SlotResource;
use App\Services\SlotService;
use OpenApi\Attributes as OA;

class SlotController extends Controller
{
    public function __construct(private readonly SlotService $slotService)
    {}

    #[OA\Get(
        path: '/api/slots',
        summary: 'Показ всех слотов',
        tags: ['slots'],
        parameters: [
            new OA\Parameter(
                name: 'available_only',
                description: 'Показывать только доступные слоты',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'boolean')
            ),
            new OA\Parameter(
                name: 'from_date',
                description: 'Начальная дата (формат Y-m-d)',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'string', format: 'date', example: '2025-08-14')
            ),
            new OA\Parameter(
                name: 'to_date',
                description: 'Конечная дата (формат Y-m-d)',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'string', format: 'date', example: '2025-08-24')
            ),
            new OA\Parameter(
                name: 'from_time',
                description: 'Начальное время (формат H:i)',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'string', example: '08:00')
            ),
            new OA\Parameter(
                name: 'to_time',
                description: 'Конечное время (формат H:i)',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'string', example: '10:00')
            ),
            new OA\Parameter(
                name: 'instructor_ids',
                description: 'Список ID инструкторов',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'string', example: '1,2,3')
            ),
            new OA\Parameter(
                name: 'car_ids',
                description: 'Список ID автомобилей',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'string', example: '1,2,3')
            ),
            new OA\Parameter(
                name: 'transmissions',
                description: 'Типы трансмиссий',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'string', example: 'mt,amt')
            ),
        ],
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
    public function list(SlotsListRequest $request)
    {
        $slots = $this->slotService->list($request);
        return response()->json(SlotResource::collection($slots));
    }
}
