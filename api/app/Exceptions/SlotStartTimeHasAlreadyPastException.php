<?php

namespace App\Exceptions;

use Exception;
use OpenApi\Attributes as OA;

#[OA\Schema(
    description: "Ответ на ошибку SlotStartTimeHasAlreadyPastException",
    properties: [
        new OA\Property(
            property: "message",
            type: "string",
            example: "Прошло более 1 часа с начала занятия!"
        ),
    ],
)]
class SlotStartTimeHasAlreadyPastException extends Exception
{
    protected $message = "Прошло более 1 часа с начала занятия!";
}
