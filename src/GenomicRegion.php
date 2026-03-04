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
            throw new \InvalidArgumentException("End ({$end}) must be greater than start ({$start})");
        }

        $this->chromosome = $chromosome;
        $this->start = $start;
        $this->end = $end;
    }

    public static function parse(string $genomicRegion): self
    {
        if (preg_match('/^([^:]+):(g\.|)(\d+)(-(\d+)|)$/', $genomicRegion, $matches) === 0) {
            throw new \InvalidArgumentException("Invalid genomic region format: {$genomicRegion}. Expected format: chr1:123-456.");
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

    /** Returns the overlapping region, or null if the regions do not intersect. */
    public function overlap(self $other): ?self
    {
        if (! $this->intersectsWithGenomicRegion($other)) {
            return null;
        }

        return new self(
            $this->chromosome,
            max($this->start, $other->start),
            min($this->end, $other->end)
        );
    }

    public function containsGenomicPosition(GenomicPosition $genomicPosition): bool
    {
        return $this->chromosome->equals($genomicPosition->chromosome)
            && $this->positionIsBetweenStartAndEnd($genomicPosition->position);
    }

    public function containsGenomicRegion(self $genomicRegion): bool
    {
        return $this->chromosome->equals($genomicRegion->chromosome)
            && $this->positionIsBetweenStartAndEnd($genomicRegion->start)
            && $this->positionIsBetweenStartAndEnd($genomicRegion->end);
    }

    public function isCoveredByGenomicRegion(self $genomicRegion): bool
    {
        return $this->chromosome->equals($genomicRegion->chromosome)
            && $genomicRegion->start <= $this->start
            && $genomicRegion->end >= $this->end;
    }

    public function intersectsWithGenomicRegion(self $genomicRegion): bool
    {
        return $this->chromosome->equals($genomicRegion->chromosome)
            && $this->start <= $genomicRegion->end
            && $genomicRegion->start <= $this->end;
    }

    private function positionIsBetweenStartAndEnd(int $position): bool
    {
        return $position >= $this->start && $position <= $this->end;
    }

    public function toString(NamingConvention $namingConvention): string
    {
        return "{$this->chromosome->toString($namingConvention)}:{$this->start}-{$this->end}";
    }
}
