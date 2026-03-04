<?php declare(strict_types=1);

use MLL\Utils\Chromosome;
use MLL\Utils\NamingConvention;
use PHPUnit\Framework\TestCase;

final class ChromosomeTest extends TestCase
{
    public function testToStringWithDefault(): void
    {
        $chromosome = new Chromosome('chr11');
        self::assertSame('chr11', $chromosome->toString());
    }

    public function testToStringForEnsembl(): void
    {
        $chromosome = new Chromosome('chr11');
        self::assertSame('11', $chromosome->toString(new NamingConvention(NamingConvention::ENSEMBL)));
    }

    public function testInitWithEnsembl(): void
    {
        $chromosome = new Chromosome('11');
        self::assertSame('11', $chromosome->toString());
    }

    public function testUpperCaseChrPrefixIsDetectedAsUCSC(): void
    {
        $chromosome = new Chromosome('CHR11');
        self::assertSame('chr11', $chromosome->toString());
    }

    public function testMixedCaseChrPrefixIsDetectedAsUCSC(): void
    {
        $chromosome = new Chromosome('Chr11');
        self::assertSame('chr11', $chromosome->toString());
    }

    public function testToStringWithUCSCAndMitochondrialChromosome(): void
    {
        $chromosome = new Chromosome('chrM');
        self::assertSame('MT', $chromosome->toString(new NamingConvention(NamingConvention::ENSEMBL)));
    }

    public function testFailedInit(): void
    {
        $chromosomeAsString = 'FOO11';
        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage("Invalid chromosome: {$chromosomeAsString}. Expected format: chr1-chr22, chrX, chrY, chrM, or without chr prefix.");
        new Chromosome($chromosomeAsString);
    }

    public function testNormalizesMTtoM(): void
    {
        $fromMT = new Chromosome('chrMT');
        self::assertSame('chrM', $fromMT->toString(new NamingConvention(NamingConvention::UCSC)));
        self::assertSame('MT', $fromMT->toString(new NamingConvention(NamingConvention::ENSEMBL)));
    }

    public function testEqualsIgnoresNamingConvention(): void
    {
        $ucsc = new Chromosome('chr11');
        $ensembl = new Chromosome('11');
        self::assertTrue($ucsc->equals($ensembl));
    }

    public function testEqualsCaseInsensitive(): void
    {
        $upper = new Chromosome('chrX');
        $lower = new Chromosome('chrx');
        self::assertTrue($upper->equals($lower));
    }
}
