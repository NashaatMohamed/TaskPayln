<?php

namespace App\Enum;

enum ActiveEnum : int
{
    case INACTIVE = 0;
    case ACTIVE = 1;


    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
        };
    }
}
