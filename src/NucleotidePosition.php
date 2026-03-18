<?php declare(strict_types=1);

namespace MLL\Utils;

class NucleotidePosition
{
    public int $value;

    /** @param int|string $positionAsMixed */
    public function __construct($positionAsMixed)
    {
        $position = SafeCast::toInt($positionAsMixed);
        if ($position < 1) {
            throw new \InvalidArgumentException("Position must be positive, got: {$position}.");
        }
        $this->value = $position;
    }
}
