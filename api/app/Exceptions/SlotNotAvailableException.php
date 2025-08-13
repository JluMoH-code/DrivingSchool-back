<?php

namespace App\Exceptions;

use Exception;
use OpenApi\Attributes as OA;

#[OA\Schema(
    description: "Ответ на ошибку SlotNotAvailableException",
    properties: [
        new OA\Property(
            property: "message",
            type: "string",
            example: "Невозможно забронировать слот (возможно, его уже кто-то забронировал)!"
        ),
    ],
)]
class SlotNotAvailableException extends Exception
{
    protected $message = "Невозможно забронировать слот (возможно, его уже кто-то забронировал)!";
}
