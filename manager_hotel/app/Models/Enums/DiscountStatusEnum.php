<?php

namespace App\Models\Enums;

enum DiscountStatusEnum: int
{
    use HasEnumLabel;

    case UNUSED = 0;

    case USED = 1;

    public function label(): string
    {
        return match ($this) {
            self::UNUSED => 'Unused',
            self::USED => 'Used',
        };
    }
}
