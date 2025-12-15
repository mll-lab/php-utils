<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\ReagentDistribution;

class ReagentDistributionDirection
{
    public const LEFT_TO_RIGHT = 0;
    public const RIGHT_TO_LEFT = 1;

    public function __construct(
        public int $value
    ) {}

    public static function LEFT_TO_RIGHT(): self
    {
        return new static(self::LEFT_TO_RIGHT);
    }

    public static function RIGHT_TO_LEFT(): self
    {
        return new static(self::RIGHT_TO_LEFT);
    }
}
