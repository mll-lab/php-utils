<?php declare(strict_types=1);

namespace MLL\Utils\InterOp;

use function Safe\preg_match;

class DeviationValue
{
    /** @var float */
    public $value;

    /** @var float */
    public $deviation;

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

        return new self((float) $matches[1], (float) $matches[2]);
    }
}
