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
}
