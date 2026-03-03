<?php declare(strict_types=1);

namespace MLL\Utils;

class Chromosome
{
    /** Matches human chromosomes with or without "chr" prefix: chr1-chr22, chrX, chrY, chrM, chrMT, or 1-22, X, Y, M, MT. */
    public const CHROMOSOME_REGEX = '/^(chr)?(1[0-9]|[1-9]|2[0-2]|X|Y|M|MT)$/i';

    private string $value;

    private NamingConvention $namingConvention;

    public function __construct(string $chromosomeAsString)
    {
        if (\Safe\preg_match(self::CHROMOSOME_REGEX, $chromosomeAsString, $matches) === 0) {
            throw new \InvalidArgumentException("Invalid chromosome: {$chromosomeAsString}. Expected format: chr1-chr22, chrX, chrY, chrM, or without chr prefix.");
        }
        $this->namingConvention = $matches[1] === 'chr'
            ? new NamingConvention(NamingConvention::ENSEMBL)
            : new NamingConvention(NamingConvention::UCSC);

        $this->value = $matches[2];
    }

    public function toString(?NamingConvention $referenceGenome = null): string
    {
        $referenceGenome ??= $this->namingConvention;

        switch ($referenceGenome->value) {
            case NamingConvention::ENSEMBL:
                return "chr{$this->value}";
            case NamingConvention::UCSC:
                return $this->value;
            default:
                throw new \InvalidArgumentException("Invalid reference genome: {$referenceGenome->value}");
        }
    }
}
