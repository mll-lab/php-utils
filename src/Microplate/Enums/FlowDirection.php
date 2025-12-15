<?php declare(strict_types=1);

namespace MLL\Utils\Microplate\Enums;

class FlowDirection
{
    public const ROW = 'ROW';
    public const COLUMN = 'COLUMN';

    public function __construct(
        public string $value
    ) {}

    public static function ROW(): self
    {
        return new static(self::ROW);
    }

    public static function COLUMN(): self
    {
        return new static(self::COLUMN);
    }
}
