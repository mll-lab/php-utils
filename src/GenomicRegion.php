<?php declare(strict_types=1);

namespace MLL\Utils;

use function Safe\preg_match;

final class GenomicRegion
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
            throw new \InvalidArgumentException("End ({$end}) must be greater then start ({$start})");
        }

        $this->chromosome = $chromosome;
        $this->start = $start;
        $this->end = $end;
    }

    public static function parse(string $genomicRegion): self
    {
        if (preg_match('/^(.+):(g|)(\d+)(-(\d+)|)$/', $genomicRegion, $matches) === 0) {
            throw new \InvalidArgumentException("Invalid genomic region format: {$genomicRegion}. Expected format: chr1:123-456.");
        }

        return new self(
            new Chromosome($matches[1]),
            (int) $matches[3],
            (int) ($matches[5] ?? $matches[3])
        );
    }

    public function containsGenomicPosition(GenomicPosition $genomicPosition): bool
    {
        return $this->chromosome->toString() === $genomicPosition->chromosome->toString()
            && $this->positionIsBetweenStartAndEnd($genomicPosition->position);
    }

    public function containsGenomicRegion(GenomicRegion $genomicRegion): bool
    {
        return $this->chromosome->toString() === $genomicRegion->chromosome->toString()
            && $this->positionIsBetweenStartAndEnd($genomicRegion->start)
            && $this->positionIsBetweenStartAndEnd($genomicRegion->end);
    }

    public function intersectsWithGenomicRegion(GenomicRegion $genomicRegion): bool
    {
        return $this->chromosome->toString() === $genomicRegion->chromosome->toString()
            && (
                $this->positionIsBetweenStartAndEnd($genomicRegion->start)
                || $this->positionIsBetweenStartAndEnd($genomicRegion->end)
            );
    }

    private function positionIsBetweenStartAndEnd(int $position): bool
    {
        return $position >= $this->start && $position <= $this->end;
    }

    public function toString(?NamingConvention $referenceGenome = null): string
    {
        return "{$this->chromosome->toString($referenceGenome)}:{$this->start}-{$this->end}";
    }
}
