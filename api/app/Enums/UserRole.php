<?php

namespace App\Enums;

use OpenApi\Attributes as OA;

#[OA\Schema(
    description: "Роль пользователя
        student: Ученик,
        instructor: Инструктор,
        admin: Админ",
    type: "string",
    enum: ['student', 'instructor', 'admin'],
    x: ["enum-varnames" => ["STUDENT", "INSTRUCTOR" , "ADMIN"]],
)]
enum UserRole: string
{
    case STUDENT = 'student';
    case INSTRUCTOR = 'instructor';
    case ADMIN = 'admin';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
