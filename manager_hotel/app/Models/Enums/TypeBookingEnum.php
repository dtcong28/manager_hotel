<?php

namespace App\Models\Enums;

enum TypeBookingEnum: int
{
    use HasEnumLabel;

case
    OFFLINE = 0;
case
    ONLINE = 1;

    public
    function label(): string
    {
        return match ($this) {
            self::OFFLINE => 'Offline',
            self::ONLINE => 'Online',
        };
    }
}
