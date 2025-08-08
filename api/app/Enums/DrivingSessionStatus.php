<?php

namespace App\Enums;
use OpenApi\Attributes as OA;

#[OA\Schema(
    description: "Статус занятия
        reservation: Забронировано,
        completed: Закончено,
        canceled: Отменено",
    type: "string",
    enum: ['reservation', 'completed', 'canceled'],
    x: ["enum-varnames" => ["RESERVATION" , "COMPLETED", "CANCELED"]],
)]
enum DrivingSessionStatus: string
{
    case RESERVATION = 'reservation';
    case COMPLETED = 'completed';
    case CANCELED = 'canceled';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
