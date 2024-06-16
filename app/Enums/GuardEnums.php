<?php

namespace App\Enums;

enum GuardEnums: string
{
    case Admin = 'admin-api';
    case User = 'web';
}
