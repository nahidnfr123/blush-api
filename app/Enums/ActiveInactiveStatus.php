<?php

namespace App\Enums;

enum ActiveInactiveStatus: int
{
  case Active = 1;
  case Inactive = 0;

  public static function values(): array
  {
//    return array_column(self::cases(), 'label', 'value');
    return array_map(fn($status) => $status, self::cases());
  }
}
