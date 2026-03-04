<?php declare(strict_types=1);

namespace MLL\Utils;

class GenomicPosition
{
    public Chromosome $chromosome;

    public int $position;

    public function __construct(Chromosome $chromosome, int $position)
    {
        if ($position < 1) {
            throw new \InvalidArgumentException("Position must be positive, got: {$position}.");
        }

        $this->chromosome = $chromosome;
        $this->position = $position;
    }

    /** @example GenomicPosition::parse('chr1:123456') */
    public static function parse(string $genomicPosition): self
    {
        if (\Safe\preg_match('/^([^:]+):(g\.|)(\d+)$/', $genomicPosition, $matches) === 0) {
            throw new \InvalidArgumentException("Invalid genomic position format: {$genomicPosition}. Expected format: chr1:123456.");
        }

        return new self(new Chromosome($matches[1]), (int) $matches[3]);
    }

    public function toString(NamingConvention $namingConvention): string
    {
        return "{$this->chromosome->toString($namingConvention)}:{$this->position}";
    }
}
