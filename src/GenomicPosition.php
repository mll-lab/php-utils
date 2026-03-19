<?php declare(strict_types=1);

namespace MLL\Utils;

use function Safe\preg_match;

class GenomicPosition
{
    public Chromosome $chromosome;

    public int $position;

    public function __construct(Chromosome $chromosome, NucleotidePosition $position)
    {
        $this->chromosome = $chromosome;
        $this->position = $position->value;
    }

    /** @example GenomicPosition::parseOneBased('chr1:123456') */
    public static function parseOneBased(string $value): self
    {
        if (preg_match('/^([^:]+):(g\.|)(\d+)$/', $value, $matches) === 0) {
            throw new \InvalidArgumentException("Invalid genomic position format: {$value}. Expected format: chr1:123456.");
        }

        return new self(new Chromosome($matches[1]), NucleotidePosition::fromOneBased((int) $matches[3]));
    }

    public function equals(self $other): bool
    {
        return $this->chromosome->equals($other->chromosome)
            && $this->position === $other->position;
    }

    public function toString(NamingConvention $namingConvention): string
    {
        return "{$this->chromosome->toString($namingConvention)}:{$this->position}";
    }
}
