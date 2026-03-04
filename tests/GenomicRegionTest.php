<?php declare(strict_types=1);

use MLL\Utils\GenomicPosition;
use MLL\Utils\GenomicRegion;
use MLL\Utils\NamingConvention;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class GenomicRegionTest extends TestCase
{
    public function testParseUCSC(): void
    {
        $region = GenomicRegion::parse('chr11:1-2');
        self::assertSame('chr11:1-2', $region->toString(new NamingConvention(NamingConvention::UCSC)));
    }

    public function testParseEnsembl(): void
    {
        $region = GenomicRegion::parse('11:1-2');
        self::assertSame('11:1-2', $region->toString(new NamingConvention(NamingConvention::ENSEMBL)));
    }

    public function testParseHGVSg(): void
    {
        $region = GenomicRegion::parse('chr11:g.1-2');
        self::assertSame('chr11:1-2', $region->toString(new NamingConvention(NamingConvention::UCSC)));
    }

    public function testParseSingleBaseRegion(): void
    {
        $region = GenomicRegion::parse('chr1:100');
        self::assertSame(100, $region->start);
        self::assertSame(100, $region->end);
        self::assertSame(1, $region->length());
        self::assertSame('chr1:100-100', $region->toString(new NamingConvention(NamingConvention::UCSC)));
    }

    public function testParseOnError(): void
    {
        $value = '11:1_2';
        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage("Invalid genomic region format: {$value}. Expected format: chr1:123-456.");
        GenomicRegion::parse($value);
    }

    public function testStartGreaterThanEnd(): void
    {
        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage('End (1) must not be less than start (2).');
        GenomicRegion::parse('11:2-1');
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

    /** @return iterable<array{string, int}> */
    public static function lengths(): iterable
    {
        yield ['chr11:20-30', 11];
        yield ['chr1:5-5', 1];
        yield ['chr1:1-100', 100];
    }

    /** @dataProvider lengths */
    #[DataProvider('lengths')]
    public function testLength(string $region, int $expected): void
    {
        self::assertSame($expected, GenomicRegion::parse($region)->length());
    }

    public function testContainsPosition(): void
    {
        $region = GenomicRegion::parse('chr11:g.1-20');
        self::assertTrue($region->containsPosition(GenomicPosition::parse('chr11:20')));
        self::assertFalse($region->containsPosition(GenomicPosition::parse('chr11:21')));
    }

    public function testContainsPositionAcrossNamingConventions(): void
    {
        $region = GenomicRegion::parse('chr11:1-20');
        self::assertTrue($region->containsPosition(GenomicPosition::parse('11:15')));
    }

    public function testContainsPositionAtStartBoundary(): void
    {
        $region = GenomicRegion::parse('chr11:10-20');
        self::assertTrue($region->containsPosition(GenomicPosition::parse('chr11:10')));
    }

    public function testContainsRegion(): void
    {
        $region = GenomicRegion::parse('chr11:g.1-20');
        self::assertTrue($region->containsRegion(GenomicRegion::parse('chr11:19-20')));
        self::assertFalse($region->containsRegion(GenomicRegion::parse('chr11:21-22')));
    }

    public function testIsCoveredBy(): void
    {
        $region = GenomicRegion::parse('chr11:g.20-30');
        self::assertTrue($region->isCoveredBy(GenomicRegion::parse('chr11:g.15-35')));
        self::assertFalse($region->isCoveredBy(GenomicRegion::parse('chr11:g.22-35')));
    }

    public function testIsCoveredByIdenticalRegion(): void
    {
        $region = GenomicRegion::parse('chr11:20-30');
        self::assertTrue($region->isCoveredBy(GenomicRegion::parse('chr11:20-30')));
    }

    public function testIntersectsPartialOverlap(): void
    {
        $region = GenomicRegion::parse('chr11:g.20-30');
        self::assertTrue($region->intersects(GenomicRegion::parse('chr11:15-25')));
        self::assertTrue($region->intersects(GenomicRegion::parse('chr11:25-35')));
    }

    public function testIntersectsNoOverlap(): void
    {
        $region = GenomicRegion::parse('chr11:g.20-30');
        self::assertFalse($region->intersects(GenomicRegion::parse('chr11:15-19')));
    }

    public function testIntersectsAdjacentRegion(): void
    {
        $region = GenomicRegion::parse('chr11:10-20');
        self::assertFalse($region->intersects(GenomicRegion::parse('chr11:21-30')));
    }

    public function testIntersectsSinglePointOverlap(): void
    {
        $region = GenomicRegion::parse('chr1:10-20');
        self::assertTrue($region->intersects(GenomicRegion::parse('chr1:20-30')));
    }

    public function testIntersectionPartial(): void
    {
        $a = GenomicRegion::parse('chr11:10-20');
        $b = GenomicRegion::parse('chr11:15-25');

        $overlap = $a->intersection($b);
        self::assertNotNull($overlap);
        self::assertTrue($overlap->equals(GenomicRegion::parse('chr11:15-20')));
        self::assertSame(6, $overlap->length());
    }

    public function testIntersectionFullyContained(): void
    {
        $outer = GenomicRegion::parse('chr11:10-30');
        $inner = GenomicRegion::parse('chr11:15-20');

        $overlap = $outer->intersection($inner);
        self::assertNotNull($overlap);
        self::assertTrue($overlap->equals($inner));
    }

    public function testIntersectionSinglePoint(): void
    {
        $a = GenomicRegion::parse('chr1:10-20');
        $b = GenomicRegion::parse('chr1:20-30');

        $overlap = $a->intersection($b);
        self::assertNotNull($overlap);
        self::assertTrue($overlap->equals(GenomicRegion::parse('chr1:20-20')));
        self::assertSame(1, $overlap->length());
    }

    public function testIntersectionReturnsNullWhenNoIntersection(): void
    {
        $a = GenomicRegion::parse('chr11:10-20');
        $b = GenomicRegion::parse('chr11:21-30');

        self::assertNull($a->intersection($b));
    }

    public function testDifferentChromosomesNeverMatch(): void
    {
        $region = GenomicRegion::parse('chr11:1-100');
        $other = GenomicRegion::parse('chr12:10-20');
        self::assertFalse($region->containsPosition(GenomicPosition::parse('chr12:50')));
        self::assertFalse($region->containsRegion($other));
        self::assertFalse($region->intersects($other));
        self::assertNull($region->intersection($other));
    }

    public function testParseRejectsPositionZero(): void
    {
        self::expectException(\InvalidArgumentException::class);
        GenomicRegion::parse('chr1:0-10');
    }

    public function testContainsRegionIsInverseOfIsCoveredBy(): void
    {
        $outer = GenomicRegion::parse('chr11:10-30');
        $inner = GenomicRegion::parse('chr11:15-20');

        self::assertSame(
            $outer->containsRegion($inner),
            $inner->isCoveredBy($outer)
        );
        self::assertSame(
            $inner->containsRegion($outer),
            $outer->isCoveredBy($inner)
        );
    }

    public function testIsCoveredByDifferentChromosomes(): void
    {
        $region = GenomicRegion::parse('chr11:10-20');
        self::assertFalse($region->isCoveredBy(GenomicRegion::parse('chr12:1-100')));
    }

    public function testIntersectionIsCommutative(): void
    {
        $a = GenomicRegion::parse('chr11:10-20');
        $b = GenomicRegion::parse('chr11:15-25');

        $ab = $a->intersection($b);
        $ba = $b->intersection($a);

        self::assertNotNull($ab);
        self::assertNotNull($ba);
        self::assertTrue($ab->equals($ba));
    }
}
