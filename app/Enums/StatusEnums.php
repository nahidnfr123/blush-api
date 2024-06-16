<?php

namespace App\Enums;

enum StatusEnums: int
{
    case Inactive = 0;
    case Active = 1;
    case Pending = 2;
    case Delivered = 3;
    case Blocked = 4;
    case Canceled = 5;

    public static function values(): array
    {
        // return array_column(self::cases(), 'name', 'value');
        return array_map(fn($status) => $status, self::cases());
    }
}
