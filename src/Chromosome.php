<?php declare(strict_types=1);

namespace MLL\Utils;

class Chromosome
{
    private string $value;

    private NamingConvention $namingConvention;

    public function __construct(string $chromosomeAsString)
    {
        /** Matches human chromosomes with or without "chr" prefix: chr1-chr22, chrX, chrY, chrM, chrMT, or 1-22, X, Y, M, MT. */
        if (\Safe\preg_match('/^(chr)?(1[0-9]|[1-9]|2[0-2]|X|Y|M|MT)$/i', $chromosomeAsString, $matches) === 0) {
            throw new \InvalidArgumentException("Invalid chromosome: {$chromosomeAsString}. Expected format: chr1-chr22, chrX, chrY, chrM, or without chr prefix.");
        }
        $this->namingConvention = $matches[1] !== ''
            ? new NamingConvention(NamingConvention::UCSC)
            : new NamingConvention(NamingConvention::ENSEMBL);

        $value = strtoupper($matches[2]);
        $this->value = $value === 'MT' ? 'M': $value;
    }

    public function toString(?NamingConvention $namingConvention = null): string
    {
        $namingConvention ??= $this->namingConvention;

        switch ($namingConvention->value) {
            case NamingConvention::ENSEMBL:
                return $this->value === 'M' ? 'MT' : $this->value;
            case NamingConvention::UCSC:
                return "chr{$this->value}";
            default:
                throw new \InvalidArgumentException("No toString logic implemented for valid naming convention: {$namingConvention->value}");
        }
    }

    public function getRawValue(): string
    {
        return $this->value;
    }

    public function equals(Chromosome $chromosome): bool
    {
        return $this->value === $chromosome->getRawValue();
    }
}
