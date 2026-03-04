<?php declare(strict_types=1);

namespace MLL\Utils;

class Chromosome
{
    private const MITOCHONDRIAL = 'M';
    private const MITOCHONDRIAL_ENSEMBL = 'MT';

    private string $value;

    public function __construct(string $chromosomeAsString)
    {
        /** Matches human chromosomes with or without "chr" prefix: chr1-chr22, chrX, chrY, chrM, chrMT, or 1-22, X, Y, M, MT. */
        if (\Safe\preg_match('/^(chr)?(1[0-9]|[1-9]|2[0-2]|X|Y|M|MT)$/i', $chromosomeAsString, $matches) === 0) {
            throw new \InvalidArgumentException("Invalid chromosome: {$chromosomeAsString}. Expected format: chr1-chr22, chrX, chrY, chrM, or without chr prefix.");
        }

        $value = strtoupper($matches[2]);
        $this->value = $value === self::MITOCHONDRIAL_ENSEMBL ? self::MITOCHONDRIAL : $value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function toString(NamingConvention $namingConvention): string
    {
        switch ($namingConvention->value) {
            case NamingConvention::UCSC:
                return "chr{$this->value}";
            case NamingConvention::ENSEMBL:
                return $this->value === self::MITOCHONDRIAL ? self::MITOCHONDRIAL_ENSEMBL : $this->value;
            default:
                throw new \InvalidArgumentException("No toString logic implemented for naming convention: {$namingConvention->value}");
        }
    }
}
