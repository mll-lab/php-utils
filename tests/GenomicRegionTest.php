<?php declare(strict_types=1);

use MLL\Utils\GenomicPosition;
use MLL\Utils\GenomicRegion;
use MLL\Utils\NamingConvention;
use PHPUnit\Framework\TestCase;

final class GenomicRegionTest extends TestCase
{
    public function testParseUCSC(): void
    {
        $genomicRegion = GenomicRegion::parse('chr11:1-2');
        self::assertSame('chr11:1-2', $genomicRegion->toString(new NamingConvention(NamingConvention::UCSC)));
    }

    public function testParseEnsembl(): void
    {
        $genomicRegion = GenomicRegion::parse('11:1-2');
        self::assertSame('11:1-2', $genomicRegion->toString(new NamingConvention(NamingConvention::ENSEMBL)));
    }

    public function testParseHGVSg(): void
    {
        $genomicRegion = GenomicRegion::parse('chr11:g.1-2');
        self::assertSame('chr11:1-2', $genomicRegion->toString(new NamingConvention(NamingConvention::UCSC)));
    }

    public function testParseOnError(): void
    {
        $genomicRegionAsString = '11:1_2';
        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage("Invalid genomic region format: {$genomicRegionAsString}. Expected format: chr1:123-456.");
        GenomicRegion::parse($genomicRegionAsString);
    }

    public function testStartGreaterThanEnd(): void
    {
        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage('End (1) must be greater than start (2)');
        GenomicRegion::parse('11:2-1');
    }

    public function testContainsGenomicPosition(): void
    {
        $genomicRegion = GenomicRegion::parse('chr11:g.1-20');
        self::assertTrue($genomicRegion->containsGenomicPosition(GenomicPosition::parse('chr11:20')));
        self::assertFalse($genomicRegion->containsGenomicPosition(GenomicPosition::parse('chr11:21')));
    }

    public function testContainsGenomicPositionAcrossNamingConventions(): void
    {
        $genomicRegion = GenomicRegion::parse('chr11:1-20');
        self::assertTrue($genomicRegion->containsGenomicPosition(GenomicPosition::parse('11:15')));
    }

    public function testContainsGenomicRegion(): void
    {
        $genomicRegion = GenomicRegion::parse('chr11:g.1-20');
        self::assertTrue($genomicRegion->containsGenomicRegion(GenomicRegion::parse('chr11:19-20')));
        self::assertFalse($genomicRegion->containsGenomicRegion(GenomicRegion::parse('chr11:21-22')));
    }

    public function testIsCoveredByGenomicRegion(): void
    {
        $genomicRegion = GenomicRegion::parse('chr11:g.20-30');
        self::assertTrue($genomicRegion->isCoveredByGenomicRegion(GenomicRegion::parse('chr11:g.15-35')));
        self::assertFalse($genomicRegion->isCoveredByGenomicRegion(GenomicRegion::parse('chr11:g.22-35')));
    }

    public function testIntersectsWithGenomicRegionPartialOverlap(): void
    {
        $genomicRegion = GenomicRegion::parse('chr11:g.20-30');
        self::assertTrue($genomicRegion->intersectsWithGenomicRegion(GenomicRegion::parse('chr11:15-25')));
        self::assertTrue($genomicRegion->intersectsWithGenomicRegion(GenomicRegion::parse('chr11:25-35')));
    }

    public function testIntersectsWithGenomicRegionFullyWrapped(): void
    {
        $genomicRegion = GenomicRegion::parse('chr11:g.20-30');
        self::assertTrue($genomicRegion->intersectsWithGenomicRegion(GenomicRegion::parse('chr11:g.15-35')));
    }

    public function testIntersectsWithGenomicRegionNoOverlap(): void
    {
        $genomicRegion = GenomicRegion::parse('chr11:g.20-30');
        self::assertFalse($genomicRegion->intersectsWithGenomicRegion(GenomicRegion::parse('chr11:15-19')));
    }

    public function testIntersectsWithAdjacentRegion(): void
    {
        $genomicRegion = GenomicRegion::parse('chr11:10-20');
        self::assertFalse($genomicRegion->intersectsWithGenomicRegion(GenomicRegion::parse('chr11:21-30')));
    }

    public function testIntersectsWithSinglePointOverlap(): void
    {
        $region = GenomicRegion::parse('chr1:10-20');
        self::assertTrue($region->intersectsWithGenomicRegion(GenomicRegion::parse('chr1:20-30')));
    }

    public function testParseSingleBaseRegion(): void
    {
        $region = GenomicRegion::parse('chr1:100');
        self::assertSame(100, $region->start);
        self::assertSame(100, $region->end);
        self::assertSame(1, $region->length());
        self::assertSame('chr1:100-100', $region->toString(new NamingConvention(NamingConvention::UCSC)));
    }

    public function testIsCoveredByIdenticalRegion(): void
    {
        $region = GenomicRegion::parse('chr11:20-30');
        self::assertTrue($region->isCoveredByGenomicRegion(GenomicRegion::parse('chr11:20-30')));
    }

    public function testContainsPositionAtStartBoundary(): void
    {
        $region = GenomicRegion::parse('chr11:10-20');
        self::assertTrue($region->containsGenomicPosition(GenomicPosition::parse('chr11:10')));
    }

    public function testEquals(): void
    {
        self::assertTrue(
            GenomicRegion::parse('chr11:10-20')->equals(GenomicRegion::parse('11:10-20'))
        );
        self::assertFalse(
            GenomicRegion::parse('chr11:10-20')->equals(GenomicRegion::parse('chr11:10-21'))
        );
        self::assertFalse(
            GenomicRegion::parse('chr11:10-20')->equals(GenomicRegion::parse('chr12:10-20'))
        );
    }

    public function testLength(): void
    {
        self::assertSame(11, GenomicRegion::parse('chr11:20-30')->length());
        self::assertSame(1, GenomicRegion::parse('chr1:5-5')->length());
        self::assertSame(100, GenomicRegion::parse('chr1:1-100')->length());
    }

    public function testOverlapPartial(): void
    {
        $a = GenomicRegion::parse('chr11:10-20');
        $b = GenomicRegion::parse('chr11:15-25');

        $overlap = $a->overlap($b);
        self::assertNotNull($overlap);
        self::assertTrue($overlap->equals(GenomicRegion::parse('chr11:15-20')));
        self::assertSame(6, $overlap->length());
    }

    public function testOverlapFullyContained(): void
    {
        $outer = GenomicRegion::parse('chr11:10-30');
        $inner = GenomicRegion::parse('chr11:15-20');

        $overlap = $outer->overlap($inner);
        self::assertNotNull($overlap);
        self::assertTrue($overlap->equals($inner));
    }

    public function testOverlapSinglePoint(): void
    {
        $a = GenomicRegion::parse('chr1:10-20');
        $b = GenomicRegion::parse('chr1:20-30');

        $overlap = $a->overlap($b);
        self::assertNotNull($overlap);
        self::assertTrue($overlap->equals(GenomicRegion::parse('chr1:20-20')));
        self::assertSame(1, $overlap->length());
    }

    public function testOverlapReturnsNullWhenNoIntersection(): void
    {
        $a = GenomicRegion::parse('chr11:10-20');
        $b = GenomicRegion::parse('chr11:21-30');

        self::assertNull($a->overlap($b));
    }

    public function testOverlapReturnsNullForDifferentChromosomes(): void
    {
        $a = GenomicRegion::parse('chr11:10-20');
        $b = GenomicRegion::parse('chr12:10-20');

        self::assertNull($a->overlap($b));
    }

    public function testDifferentChromosomesNeverMatch(): void
    {
        $region = GenomicRegion::parse('chr11:1-100');
        self::assertFalse($region->containsGenomicPosition(GenomicPosition::parse('chr12:50')));
        self::assertFalse($region->containsGenomicRegion(GenomicRegion::parse('chr12:10-20')));
        self::assertFalse($region->intersectsWithGenomicRegion(GenomicRegion::parse('chr12:10-20')));
    }
}
