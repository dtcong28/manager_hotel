<?php

namespace App\Models\Enums;

enum GenderEnum: int
{
    use HasEnumLabel;

    case FEMALE = 0;

    case MALE = 1;

    public function label(): string
    {
        return match ($this) {
            self::FEMALE => 'Female',
            self::MALE => 'Male',
        };
    }
}
