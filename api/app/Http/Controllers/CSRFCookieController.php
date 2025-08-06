<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

class CSRFCookieController extends Controller
{
    #[OA\Get(
        path: '/sanctum/csrf-cookie',
        summary: 'Метод для записи csrf куки в браузер',
        tags: ['csrf'],
        responses: [new OA\Response(response: 204, description: 'No content')]
    )]
    public function csrfCookie(): void
    {}
}
