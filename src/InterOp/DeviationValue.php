<?php declare(strict_types=1);

namespace MLL\Utils\InterOp;

use MLL\Utils\SafeCast;

use function Safe\preg_match;

class DeviationValue
{
    public float $value;

    public float $deviation;

    public function __construct(float $value, float $deviation)
    {
        $this->value = $value;
        $this->deviation = $deviation;
    }

    /**
     * Parses strings like "851 +/- 32" into value and deviation.
     *
     * Returns null for "nan +/- nan" (occurs for index reads).
     */
    public static function parse(string $raw): ?self
    {
        if (preg_match('/^([\d.]+)\s*\+\/-\s*([\d.]+)$/', $raw, $matches) !== 1) {
            return null;
        }

        assert(isset($matches[1], $matches[2]), "Regex matched but captures missing in: {$raw}.");

        return new self(
            SafeCast::toFloat($matches[1]),
            SafeCast::toFloat($matches[2])
        );
    }

    public static function average(self $a, self $b): self
    {
        return new self(
            ($a->value + $b->value) / 2,
            ($a->deviation + $b->deviation) / 2
        );
    }
}
