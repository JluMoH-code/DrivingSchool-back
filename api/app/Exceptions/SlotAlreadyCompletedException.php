<?php

namespace App\Exceptions;

use Exception;
use OpenApi\Attributes as OA;

#[OA\Schema(
    description: "Ответ на ошибку SlotAlreadyCompletedException",
    properties: [
        new OA\Property(
            property: "message",
            type: "string",
            example: "Слот уже закрыт (занятие проведено)!"
        ),
    ],
)]
class SlotAlreadyCompletedException extends Exception
{
    protected $message = "Слот уже закрыт (занятие проведено)!";
}
