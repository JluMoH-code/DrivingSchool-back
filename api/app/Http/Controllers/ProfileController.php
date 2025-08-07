<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class ProfileController extends Controller
{
    public function __construct(private readonly ProfileService $profileService)
    {}

    #[OA\Get(
        path: '/api/profile',
        summary: 'Показ информации о текущем авторизованном пользователе',
        tags: ['profile'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Информация о пользователе',
                content: new OA\JsonContent(ref: '#/components/schemas/ProfileResource'),
            ),
        ]
    )]
    public function profile(Request $request)
    {
        $user = $this->profileService->profile($request);
        return response()->json(new ProfileResource($user));
    }
}
