<?php

namespace App\Http\Controllers;

use App\Exceptions\SlotNotAvailableException;
use App\Exceptions\SlotNotFoundException;
use App\Exceptions\SlotStartTimeHasAlreadyPastException;
use App\Exceptions\UserNotActiveException;
use App\Http\Resources\DrivingSessionResource;
use App\Services\ReservationSlotService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class ReservationSlotController extends Controller
{
    public function __construct(private readonly ReservationSlotService $reservationSlotService)
    {}

    #[OA\Post(
        path: '/api/slots/{slotId}/reserve',
        summary: 'Резервирование слота для авторизованного пользователя',
        tags: ['slots'],
        parameters: [
            new OA\Parameter(
                name: 'slotId',
                description: 'ID слота',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 42)
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Запись на вождение',
                content: new OA\JsonContent(ref: '#/components/schemas/DrivingSessionResource'),
            ),
            new OA\Response(
                response: 400,
                description: 'Слот недоступен или с начала занятия прошло более 1 часа!',
                content: new OA\JsonContent(
                    oneOf: [
                        new OA\Schema(
                            ref: '#/components/schemas/SlotNotAvailableException',
                            description: 'Невозможно забронировать слот (возможно, его уже кто-то забронировал)!'
                        ),
                        new OA\Schema(
                            ref: '#/components/schemas/SlotStartTimeHasAlreadyPastException',
                            description: 'Невозможно забронировать слот (прошло более 1 часа с начала занятия)!'
                        ),
                    ]
                )
            ),
            new OA\Response(
                response: 403,
                description: 'Невозможно забронировать слот!',
                content: new OA\JsonContent(ref: '#/components/schemas/UserNotActiveException'),
            ),
            new OA\Response(
                response: 404,
                description: 'Слот не найден!',
                content: new OA\JsonContent(ref: '#/components/schemas/SlotNotFoundException'),
            ),
        ]
    )]
    public function reserveSlotForSelf($slotId, Request $request)
    {
        try {
            $drivingSession = $this->reservationSlotService->reserveSlotForSelf($slotId, $request);
            return response()->json(new DrivingSessionResource($drivingSession));
        } catch (SlotNotAvailableException|SlotStartTimeHasAlreadyPastException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        } catch (UserNotActiveException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        } catch (SlotNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}
