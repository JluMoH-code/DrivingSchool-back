<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersListRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use OpenApi\Attributes as OA;

class UserController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {}

    #[OA\Get(
        path: '/api/users',
        summary: 'Показ всех пользователей',
        tags: ['users'],
        parameters: [
            new OA\Parameter(
                name: 'available_only',
                description: 'Только активные пользователи.',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'boolean', default: false)
            ),
            new OA\Parameter(
                name: 'roles',
                description: 'Фильтр по ролям пользователей.',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'string', example: 'student,instructor'),
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Список пользователей',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: '#/components/schemas/UserResource')
                )
            ),
        ]
    )]
    public function list(UsersListRequest $request)
    {
        $users = $this->userService->list($request);
        return response()->json(UserResource::collection($users));
    }
}
