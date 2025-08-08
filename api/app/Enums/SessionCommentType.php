<?php

namespace App\Enums;
use OpenApi\Attributes as OA;

#[OA\Schema(
    description: "Тип комментарий к занятию
        pre: До занятия,
        post: После занятие",
    type: "string",
    enum: ['pre', 'post'],
    x: ["enum-varnames" => ["PRE" , "POST"]],
)]
enum SessionCommentType: string
{
    case PRE = 'pre';
    case POST = 'post';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
