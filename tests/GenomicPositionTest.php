<?php declare(strict_types=1);

use MLL\Utils\GenomicPosition;
use MLL\Utils\NamingConvention;
use PHPUnit\Framework\TestCase;

final class GenomicPositionTest extends TestCase
{
    public function testParseUCSC(): void
    {
        $genomicPosition = GenomicPosition::parse('chr11:1');
        self::assertSame('chr11:1', $genomicPosition->toString(new NamingConvention(NamingConvention::UCSC)));
    }

    public function testParseEnsembl(): void
    {
        $genomicPosition = GenomicPosition::parse('11:1');
        self::assertSame('11:1', $genomicPosition->toString(new NamingConvention(NamingConvention::ENSEMBL)));
    }

    public function testParseHGVSg(): void
    {
        $genomicPosition = GenomicPosition::parse('chr11:g.1');
        self::assertSame('chr11:1', $genomicPosition->toString(new NamingConvention(NamingConvention::UCSC)));
    }

    public function testOutputInBothConventions(): void
    {
        $genomicPosition = GenomicPosition::parse('chr11:12345');
        self::assertSame('chr11:12345', $genomicPosition->toString(new NamingConvention(NamingConvention::UCSC)));
        self::assertSame('11:12345', $genomicPosition->toString(new NamingConvention(NamingConvention::ENSEMBL)));
    }

    public function testParseOnError(): void
    {
        $genomicPositionAsString = '11:1test';
        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage("Invalid genomic position format: {$genomicPositionAsString}. Expected format: chr1:123456.");
        GenomicPosition::parse($genomicPositionAsString);
    }
}
