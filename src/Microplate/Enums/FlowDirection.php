<?php declare(strict_types=1);

namespace MLL\Utils\Microplate\Enums;

final class FlowDirection
{
    public const ROW = 'ROW';
    public const COLUMN = 'COLUMN';

    public string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function ROW(): self
    {
        return new self(self::ROW);
    }

    public static function COLUMN(): self
    {
        return new self(self::COLUMN);
    }
}
