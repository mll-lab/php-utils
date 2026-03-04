<?php declare(strict_types=1);

use MLL\Utils\Chromosome;
use MLL\Utils\NamingConvention;
use PHPUnit\Framework\TestCase;

final class ChromosomeTest extends TestCase
{
    public function testToStringUCSC(): void
    {
        $chromosome = new Chromosome('chr11');
        self::assertSame('chr11', $chromosome->toString(new NamingConvention(NamingConvention::UCSC)));
    }

    public function testToStringEnsembl(): void
    {
        $chromosome = new Chromosome('chr11');
        self::assertSame('11', $chromosome->toString(new NamingConvention(NamingConvention::ENSEMBL)));
    }

    public function testToStringFromEnsemblInput(): void
    {
        $chromosome = new Chromosome('11');
        self::assertSame('11', $chromosome->toString(new NamingConvention(NamingConvention::ENSEMBL)));
        self::assertSame('chr11', $chromosome->toString(new NamingConvention(NamingConvention::UCSC)));
    }

    public function testValueReturnsCanonicalForm(): void
    {
        self::assertSame('11', (new Chromosome('chr11'))->value());
        self::assertSame('11', (new Chromosome('11'))->value());
        self::assertSame('X', (new Chromosome('chrx'))->value());
        self::assertSame('M', (new Chromosome('chrM'))->value());
        self::assertSame('M', (new Chromosome('MT'))->value());
        self::assertSame('M', (new Chromosome('chrMT'))->value());
    }

    public function testMitochondrialNormalization(): void
    {
        $fromChrM = new Chromosome('chrM');
        $fromMT = new Chromosome('MT');
        $fromChrMT = new Chromosome('chrMT');

        self::assertTrue($fromChrM->equals($fromMT));
        self::assertTrue($fromChrM->equals($fromChrMT));

        self::assertSame('chrM', $fromChrM->toString(new NamingConvention(NamingConvention::UCSC)));
        self::assertSame('MT', $fromChrM->toString(new NamingConvention(NamingConvention::ENSEMBL)));
        self::assertSame('chrM', $fromChrMT->toString(new NamingConvention(NamingConvention::UCSC)));
        self::assertSame('MT', $fromMT->toString(new NamingConvention(NamingConvention::ENSEMBL)));
    }

    public function testEqualsAcrossNamingConventions(): void
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

    public function testCaseInsensitivePrefixDetection(): void
    {
        $chr = new Chromosome('CHR11');
        self::assertSame('chr11', $chr->toString(new NamingConvention(NamingConvention::UCSC)));

        $chr2 = new Chromosome('Chr11');
        self::assertSame('chr11', $chr2->toString(new NamingConvention(NamingConvention::UCSC)));
    }

    public function testBoundaryChromosomes(): void
    {
        self::assertSame('1', (new Chromosome('chr1'))->value());
        self::assertSame('22', (new Chromosome('chr22'))->value());
        self::assertSame('X', (new Chromosome('X'))->value());
        self::assertSame('Y', (new Chromosome('chrY'))->value());
    }

    public function testRejectsInvalidChromosomeNumbers(): void
    {
        self::expectException(\InvalidArgumentException::class);
        new Chromosome('chr23');
    }

    public function testFailedInit(): void
    {
        $chromosomeAsString = 'FOO11';
        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage("Invalid chromosome: {$chromosomeAsString}. Expected format: chr1-chr22, chrX, chrY, chrM, or without chr prefix.");
        new Chromosome($chromosomeAsString);
    }
}
