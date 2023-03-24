<?php

namespace App\Models\Enums;

enum BookingStatusEnum: int
{
    use HasEnumLabel;

    case CHECK_OUT = 0;
    case CHECK_IN = 1;
    case EXPECTED_ARRIVAL = 2;

    public function label(): string
    {
        return match ($this) {
            self::CHECK_OUT => 'Check out',
            self::CHECK_IN => 'Check in',
            self::EXPECTED_ARRIVAL => 'Expected arrival',
        };
    }

    public static function statusLabel($value): string
    {
        return match ($value) {
            self::CHECK_OUT->value => 'Check out',
            self::CHECK_IN->value => 'Check in',
            self::EXPECTED_ARRIVAL->value => 'Expected arrival',
        };
    }

    public static function statusBg($value): string
    {
        return match ($value) {
            self::CHECK_OUT->value => 'label label-sm label-danger',
            self::CHECK_IN->value => 'label label-sm label-success',
            self::EXPECTED_ARRIVAL->value => 'label label-sm label-warning',
        };
    }
}
