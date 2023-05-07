<?php

namespace App\Models\Enums;

enum MethodPaymentEnum: int
{
    use HasEnumLabel;

    case CASH = 0;
    case BANKING = 1;

    public function label(): string
    {
        return match ($this) {
            self::CASH => 'Cash',
            self::BANKING => 'Banking',
        };
    }

    public static function statusLabel($value): string
    {
        return match ($value) {
            self::CASH->value => 'Cash',
            self::BANKING->value => 'Banking',
        };
    }
}
