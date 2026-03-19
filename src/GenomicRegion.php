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
        NucleotidePosition $start,
        NucleotidePosition $end
    ) {
        if ($start->value > $end->value) {
            throw new \InvalidArgumentException("End ({$end->value}) must not be less than start ({$start->value}).");
        }

        $this->chromosome = $chromosome;
        $this->start = $start->value;
        $this->end = $end->value;
    }

    public static function parseOneBased(string $value): self
    {
        if (preg_match('/^([^:]+):(g\.|)(\d+)(-(\d+)|)$/', $value, $matches) === 0) {
            throw new \InvalidArgumentException("Invalid genomic region format: {$value}. Expected format: chr1:123-456.");
        }

        return new self(
            new Chromosome($matches[1]),
            NucleotidePosition::fromOneBased((int) $matches[3]),
            NucleotidePosition::fromOneBased((int) ($matches[5] ?? $matches[3]))
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
            NucleotidePosition::fromOneBased(max($this->start, $other->start)),
            NucleotidePosition::fromOneBased(min($this->end, $other->end))
        );
    }

    /** Constructs a 1-based closed region from 0-based half-open coordinates (BED, BAM, bigWig). */
    public static function fromZeroBasedHalfOpen(string $chromosome, int $start, int $end): self
    {
        return new self(
            new Chromosome($chromosome),
            NucleotidePosition::fromZeroBased($start),
            NucleotidePosition::fromOneBased($end)
        );
    }

    /** @return array{Chromosome, int, int} Chromosome, 0-based start, half-open end. */
    public function toZeroBasedHalfOpen(): array
    {
        return [$this->chromosome, $this->start - 1, $this->end];
    }

    private function containsCoordinate(int $position): bool
    {
        return $position >= $this->start && $position <= $this->end;
    }

    /** @return array<int, GenomicPosition> */
    public function genomicPositions(): array
    {
        $items = [];
        for ($genomicPosition = $this->start; $genomicPosition <= $this->end; ++$genomicPosition) {
            $items[] = new GenomicPosition($this->chromosome, NucleotidePosition::fromOneBased($genomicPosition));
        }

        return $items;
    }
}
