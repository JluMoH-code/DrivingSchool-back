<?php

namespace App\Exceptions;

use Exception;
use OpenApi\Attributes as OA;

#[OA\Schema(
    description: "Ответ на ошибку SlotNotFoundException",
    properties: [
        new OA\Property(
            property: "message",
            type: "string",
            example: "Слот не найден!"
        ),
    ],
)]
class SlotNotFoundException extends Exception
{
    protected $message = "Слот не найден!";
}
