<?php declare(strict_types=1);


use MLL\Utils\GenomicPosition;
use MLL\Utils\GenomicRegion;
use PHPUnit\Framework\TestCase;

final class GenomicRegionTest extends TestCase
{
    public function testParseOnSuccessHG19(): void
    {
        $genomicRegion = GenomicRegion::parse('chr11:1-2');
        self::assertSame('chr11:1-2', $genomicRegion->toString());
    }

    public function testParseOnSuccessGRC37(): void
    {
        $genomicRegion = GenomicRegion::parse('11:1-2');
        self::assertSame('11:1-2', $genomicRegion->toString());
    }

    public function testParseOnSuccessHGVSg(): void
    {
        $genomicRegion = GenomicRegion::parse('chr11:g1-2');
        self::assertSame('chr11:1-2', $genomicRegion->toString());
    }

    public function testParseOnError(): void
    {
        $genomicRegionAsString = '11:1_2';
        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage("Invalid genomic region format: {$genomicRegionAsString}. Expected format: chr1:123-456.");
        GenomicRegion::parse($genomicRegionAsString);
    }

    public function testStartIsGerateThenEnd(): void
    {
        $genomicRegionAsString = '11:2-1';
        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage("End (1) must be greater then start (2)");
        GenomicRegion::parse($genomicRegionAsString);
    }

    public function testContainsGenomicPositionIsTrue(): void
    {
        $genomicRegion = GenomicRegion::parse('chr11:g1-20');
        self::assertTrue($genomicRegion->containsGenomicPosition(GenomicPosition::parse('chr11:20')));
    }

    public function testContainsGenomicPositionIsFalse(): void
    {
        $genomicRegion = GenomicRegion::parse('chr11:g1-20');
        self::assertFalse($genomicRegion->containsGenomicPosition(GenomicPosition::parse('chr11:21')));
    }

    public function testContainsGenomicRegionIsTrue(): void
    {
        $genomicRegion = GenomicRegion::parse('chr11:g1-20');
        self::assertTrue($genomicRegion->containsGenomicRegion(GenomicRegion::parse('chr11:19-20')));
    }

    public function testContainsGenomicRegionIsFalse(): void
    {
        $genomicRegion = GenomicRegion::parse('chr11:g1-20');
        self::assertFalse($genomicRegion->containsGenomicRegion(GenomicRegion::parse('chr11:21-22')));
    }

    public function testIntersectsWithGenomicRegionIsTrue(): void
    {
        $genomicRegion = GenomicRegion::parse('chr11:g20-30');
        self::assertTrue($genomicRegion->intersectsWithGenomicRegion(GenomicRegion::parse('chr11:15-25')));
    }

    public function testIntersectsWithGenomicRegionIsFalse(): void
    {
        $genomicRegion = GenomicRegion::parse('chr11:g20-30');
        self::assertFalse($genomicRegion->intersectsWithGenomicRegion(GenomicRegion::parse('chr11:15-19')));
    }
}
