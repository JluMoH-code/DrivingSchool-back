<?php

namespace App\Enums;
use OpenApi\Attributes as OA;

#[OA\Schema(
    description: "Статус слота
        available: Доступно к бронированию,
        reservation: Забронирован,
        completed: Закончен,
        blocked: Заблокирован",
    type: "string",
    enum: ['available', 'reservation', 'completed', 'blocked'],
    x: ["enum-varnames" => ["AVAILABLE", "RESERVATION" , "COMPLETED", "BLOCKED"]],
)]
enum SlotStatus: string
{
    case AVAILABLE = 'available';
    case RESERVATION = 'reservation';
    case COMPLETED = 'completed';
    case BLOCKED = 'blocked';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
