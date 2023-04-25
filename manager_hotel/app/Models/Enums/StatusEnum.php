<?php

namespace App\Models\Enums;

enum StatusEnum: int
{
    use HasEnumLabel;

    case INACTIVE = 0;

    case ACTIVE = 1;

    public function label(): string
    {
        return match ($this) {
            self::INACTIVE => 'Inactive',
            self::ACTIVE => 'Active',
        };
    }
}
