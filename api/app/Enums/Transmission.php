<?php

namespace App\Enums;
use OpenApi\Attributes as OA;

#[OA\Schema(
    description: "Тип трансмиссии авто
        mt: Механическая,
        at: Автоматическая,
        amt: Автоматизированная механика (робот),
        cvt: Вариатор",
    type: "string",
    enum: ['mt', 'at', 'amt', 'cvt'],
    x: ["enum-varnames" => ["MT", "AT" , "AMT", "CVT"]],
)]
enum Transmission: string
{
    case MT = 'mt';
    case AT = 'at';
    case AMT = 'amt';
    case CVT = 'cvt';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
