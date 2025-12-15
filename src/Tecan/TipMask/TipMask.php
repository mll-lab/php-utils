<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\TipMask;

use MLL\Utils\Tecan\TecanException;

class TipMask
{
    public const FOUR_TIPS = 'FOUR_TIPS';
    public const EIGHT_TIPS = 'EIGHT_TIPS';

    public ?int $currentTip = null;

    public function __construct(
        public string $value
    ) {}

    public static function FOUR_TIPS(): self
    {
        return new static(self::FOUR_TIPS);
    }

    public static function EIGHT_TIPS(): self
    {
        return new static(self::EIGHT_TIPS);
    }

    public static function firstTip(): int
    {
        return 1;
    }

    public function isLastTip(): bool
    {
        return match ($this->value) {
            self::FOUR_TIPS => $this->currentTip === 8,
            self::EIGHT_TIPS => $this->currentTip === 128,
            default => throw new TecanException("isLastTip not defined for {$this->value}."),
        };
    }

    public function nextTip(): int
    {
        $this->currentTip = $this->currentTip === null || $this->isLastTip()
            ? self::firstTip()
            // due to the bitwise nature we can simply multiply the current tip by 2 if we want to specify the next tip.
            : $this->currentTip * 2;

        return $this->currentTip;
    }
}
