<?php

namespace App\Models\Enums;

trait HasEnumLabel
{
    abstract public function label(): string;

    public static function fromLabel(string $label)
    {
        return collect(self::cases())->first(function (self $enum) use ($label) {
            return $enum->label() === $label;
        });
    }

    public static function getLabelsList($nullable = false): array
    {
        $label = array_map(fn(self $enum) => $enum->label(), self::cases());
        if ($nullable) {
            array_push($label, "");
        }
        return $label;
    }
}
