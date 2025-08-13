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
            example: "Невозможно забронировать слот!"
        ),
    ],
)]
class UserNotActiveException extends Exception
{
    protected $message = "Невозможно забронировать слот!";
}
