<?php

namespace App\Exceptions;

use Exception;
use OpenApi\Attributes as OA;

#[OA\Schema(
    description: "Ответ на ошибку UserNotStudentException",
    properties: [
        new OA\Property(
            property: "message",
            type: "string",
            example: "Пользователь не является студентом!"
        ),
    ],
)]
class UserNotStudentException extends Exception
{
    protected $message = "Пользователь не является студентом!";
}
