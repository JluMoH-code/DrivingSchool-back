<?php

namespace App\Http\Controllers;

use App\Exceptions\SlotAlreadyCompletedException;
use App\Exceptions\SlotNotAvailableException;
use App\Exceptions\SlotNotFoundException;
use App\Exceptions\SlotStartTimeHasAlreadyPastException;
use App\Exceptions\UserNotActiveException;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\UserNotStudentException;
use App\Http\Resources\DrivingSessionResource;
use App\Http\Resources\SlotResource;
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
                            description: 'Прошло более 1 часа с начала занятия!'
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

    #[OA\Put(
        path: '/api/slots/{slotId}/cancel',
        summary: 'Отмена резервирования слота для авторизованного пользователя',
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
                description: 'Слот',
                content: new OA\JsonContent(ref: '#/components/schemas/SlotResource'),
            ),
            new OA\Response(
                response: 400,
                description: 'Слот закрыт или с начала занятия прошло более 1 часа!',
                content: new OA\JsonContent(
                    oneOf: [
                        new OA\Schema(
                            ref: '#/components/schemas/SlotAlreadyCompletedException',
                            description: 'Слот уже закрыт (занятие проведено)!'
                        ),
                        new OA\Schema(
                            ref: '#/components/schemas/SlotStartTimeHasAlreadyPastException',
                            description: 'Прошло более 1 часа с начала занятия!'
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
    public function cancelReservation($slotId, Request $request)
    {
        try {
            $slot = $this->reservationSlotService->cancelReservation($slotId, $request);
            return response()->json(new SlotResource($slot));
        } catch (SlotAlreadyCompletedException|SlotStartTimeHasAlreadyPastException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        } catch (UserNotActiveException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        } catch (SlotNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    #[OA\Post(
        path: '/api/slots/{slotId}/reserve-for/{userId}',
        summary: 'Резервирование слота для пользователя (только для админа)',
        tags: ['slots'],
        parameters: [
            new OA\Parameter(
                name: 'slotId',
                description: 'ID слота',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 42)
            ),
            new OA\Parameter(
                name: 'userId',
                description: 'ID пользователя',
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
                description: 'Слот недоступен!',
                content: new OA\JsonContent(ref: '#/components/schemas/SlotNotAvailableException'),
            ),
            new OA\Response(
                response: 403,
                description: 'Невозможно забронировать слот!',
                content: new OA\JsonContent(ref: '#/components/schemas/UserNotActiveException'),
            ),
            new OA\Response(
                response: 404,
                description: 'Слот или пользователь не найден!',
                content: new OA\JsonContent(
                    oneOf: [
                        new OA\Schema(
                            ref: '#/components/schemas/SlotNotFoundException',
                            description: 'Слот не найден!',
                        ),
                        new OA\Schema(
                            ref: '#/components/schemas/UserNotFoundException',
                            description: 'Пользователь не найден!',
                        )
                    ]
                ),
            ),
            new OA\Response(
                response: 422,
                description: 'Пользователь не является студентом!',
                content: new OA\JsonContent(ref: '#/components/schemas/UserNotStudentException'),
            ),
        ]
    )]
    public function reserveSlotForUser($slotId, $userId)
    {
        try {
            $drivingSession = $this->reservationSlotService->reserveSlotForUser($slotId, $userId);
            return response()->json(new DrivingSessionResource($drivingSession));
        } catch (SlotNotAvailableException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        } catch (UserNotActiveException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        } catch (SlotNotFoundException|UserNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        } catch (UserNotStudentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    #[OA\Put(
        path: '/api/slots/{slotId}/cancel-for/{userId}',
        summary: 'Отмена резервирования слота для пользователя (только для админа)',
        tags: ['slots'],
        parameters: [
            new OA\Parameter(
                name: 'slotId',
                description: 'ID слота',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 42)
            ),
            new OA\Parameter(
                name: 'userId',
                description: 'ID пользователя',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 42)
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Слот',
                content: new OA\JsonContent(ref: '#/components/schemas/SlotResource'),
            ),
            new OA\Response(
                response: 400,
                description: 'Слот закрыт или с начала занятия прошло более 1 часа!',
                content: new OA\JsonContent(ref: '#/components/schemas/SlotAlreadyCompletedException'),
            ),
            new OA\Response(
                response: 403,
                description: 'Невозможно забронировать слот!',
                content: new OA\JsonContent(ref: '#/components/schemas/UserNotActiveException'),
            ),
            new OA\Response(
                response: 404,
                description: 'Слот или пользователь не найден!',
                content: new OA\JsonContent(
                    oneOf: [
                        new OA\Schema(
                            ref: '#/components/schemas/SlotNotFoundException',
                            description: 'Слот не найден!',
                        ),
                        new OA\Schema(
                            ref: '#/components/schemas/UserNotFoundException',
                            description: 'Пользователь не найден!',
                        )
                    ]
                ),
            ),
        ]
    )]
    public function cancelReservationForUser($slotId, $userId)
    {
        try {
            $slot = $this->reservationSlotService->cancelReservationForUser($slotId, $userId);
            return response()->json(new SlotResource($slot));
        } catch (SlotAlreadyCompletedException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        } catch (UserNotActiveException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        } catch (SlotNotFoundException|UserNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}
