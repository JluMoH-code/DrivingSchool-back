<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{

    #[OA\Post(
        path: '/login',
        summary: 'Вход',
        requestBody: new OA\RequestBody(
            content: [new OA\MediaType(mediaType: 'application/json',
                schema: new OA\Schema(ref: '#/components/schemas/AuthRequest'))]
        ),
        tags: ['auth'],
        responses: [
            new OA\Response(response: 204, description: 'No content'),
            new OA\Response(response: 422, description: 'Unprocessable Content')
        ]
    )]
    public function authenticate(AuthRequest $request)
    {
        $credentials = $request->all();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->noContent(204);
        }

        return response()->json(['message' => 'Некорректные данные']);
    }

    #[OA\Get(
        path: '/logout',
        summary: 'Выход',
        tags: ['auth'],
        responses: [
            new OA\Response(response: 204, description: 'No content'),
            new OA\Response(response: 422, description: 'Unprocessable Content')
        ]
    )]
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->noContent(204);
    }
}
