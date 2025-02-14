<?php declare(strict_types=1);

namespace MLL\Utils\Microplate\Enums;

class FlowDirection
{
    public const ROW = 'ROW';
    public const COLUMN = 'COLUMN';

    public string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function ROW(): static
    {
        return new static(self::ROW);
    }

    public static function COLUMN(): static
    {
        return new static(self::COLUMN);
    }
}
