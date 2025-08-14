<?php

namespace App\Exceptions;

use Exception;
use OpenApi\Attributes as OA;

#[OA\Schema(
    description: "Ответ на ошибку UserNotActiveException",
    properties: [
        new OA\Property(
            property: "message",
            type: "string",
            example: "Пользователь не найден!"
        ),
    ],
)]
class UserNotFoundException extends Exception
{
    protected $message = "Пользователь не найден!";
}
