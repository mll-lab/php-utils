<?php declare(strict_types=1);

namespace MLL\Utils;

class NucleotidePosition
{
    public int $value;

    private function __construct(int $oneBasedPosition)
    {
        $this->value = $oneBasedPosition;
    }

    public static function fromOneBased(int $position): self
    {
        if ($position < 1) {
            throw new \InvalidArgumentException("Position must be positive, got: {$position}.");
        }

        $instance = new self($position);

        return $instance;
    }

    public static function fromZeroBased(int $position): self
    {
        if ($position < 0) {
            throw new \InvalidArgumentException("Position must not be negative, got: {$position}.");
        }

        $instance = new self($position + 1);

        return $instance;
    }
}
