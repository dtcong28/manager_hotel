<?php

namespace App\Models\Enums;

enum RoomStatusEnum: int
{
    use HasEnumLabel;

    case VACANT = 0;
    case OCCUPIED = 1;
    case EXPECTED_ARRIVAL = 2;

    public function label(): string
    {
        return match ($this) {
            self::VACANT => 'Vacant',
            self::OCCUPIED => 'Occupied',
            self::EXPECTED_ARRIVAL => 'Expected arrival',
        };
    }
}
