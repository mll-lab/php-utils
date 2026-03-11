<?php declare(strict_types=1);

namespace MLL\Utils;

use function Safe\preg_match;

class GenomicRegion
{
    public Chromosome $chromosome;

    public int $start;

    public int $end;

    public function __construct(
        Chromosome $chromosome,
        int $start,
        int $end
    ) {
        if ($start < 1) {
            throw new \InvalidArgumentException("Start must be positive, got: {$start}.");
        }

        if ($end < 1) {
            throw new \InvalidArgumentException("End must be positive, got: {$end}.");
        }

        if ($start > $end) {
            throw new \InvalidArgumentException("End ({$end}) must not be less than start ({$start}).");
        }

        $this->chromosome = $chromosome;
        $this->start = $start;
        $this->end = $end;
    }

    public static function parse(string $value): self
    {
        if (preg_match('/^([^:]+):(g\.|)(\d+)(-(\d+)|)$/', $value, $matches) === 0) {
            throw new \InvalidArgumentException("Invalid genomic region format: {$value}. Expected format: chr1:123-456.");
        }

        return new self(
            new Chromosome($matches[1]),
            (int) $matches[3],
            (int) ($matches[5] ?? $matches[3])
        );
    }

    public function equals(self $other): bool
    {
        return $this->chromosome->equals($other->chromosome)
            && $this->start === $other->start
            && $this->end === $other->end;
    }

    public function length(): int
    {
        return $this->end - $this->start + 1;
    }

    public function toString(NamingConvention $namingConvention): string
    {
        return "{$this->chromosome->toString($namingConvention)}:{$this->start}-{$this->end}";
    }

    public function containsPosition(GenomicPosition $other): bool
    {
        return $this->chromosome->equals($other->chromosome)
            && $this->containsCoordinate($other->position);
    }

    public function containsRegion(self $other): bool
    {
        return $other->isCoveredBy($this);
    }

    public function isCoveredBy(self $other): bool
    {
        return $this->chromosome->equals($other->chromosome)
            && $other->start <= $this->start
            && $other->end >= $this->end;
    }

    public function intersects(self $other): bool
    {
        return $this->chromosome->equals($other->chromosome)
            && $this->start <= $other->end
            && $other->start <= $this->end;
    }

    /** Returns the intersecting region, or null if the regions do not intersect. */
    public function intersection(self $other): ?self
    {
        if (! $this->intersects($other)) {
            return null;
        }

        return new self(
            $this->chromosome,
            max($this->start, $other->start),
            min($this->end, $other->end)
        );
    }

    private function containsCoordinate(int $position): bool
    {
        return $position >= $this->start && $position <= $this->end;
    }
}
