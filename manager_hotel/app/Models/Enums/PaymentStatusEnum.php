<?php

namespace App\Models\Enums;

enum PaymentStatusEnum: int
{
    use HasEnumLabel;

    case UNPAID = 0;
    case PAID = 1;

    public function label(): string
    {
        return match ($this) {
            self::UNPAID => 'UNPAID',
            self::PAID => 'PAID',
        };
    }

    public static function statusLabel($value): string
    {
        return match ($value) {
            self::UNPAID->value => 'Unpaid',
            self::PAID->value => 'Paid',
        };
    }

    public static function statusBg($value): string
    {
        return match ($value) {
            self::UNPAID->value => 'label label-sm label-danger',
            self::PAID->value => 'label label-sm label-success',
        };
    }
}
