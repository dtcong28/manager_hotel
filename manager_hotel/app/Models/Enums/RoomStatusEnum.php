<?php

namespace App\Models\Enums;

enum RoomStatusEnum: int
{
    use HasEnumLabel;

    case VACANT = 0;
    case OCCUPIED = 1;

    public function label(): string
    {
        return match ($this) {
            self::VACANT => 'Vacant',
            self::OCCUPIED => 'Occupied',
        };
    }
}
