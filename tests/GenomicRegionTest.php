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
        $region = GenomicRegion::parseOneBased('chr11:1-2');
        self::assertSame('chr11:1-2', $region->toString(new NamingConvention(NamingConvention::UCSC)));
    }

    public function testParseEnsembl(): void
    {
        $region = GenomicRegion::parseOneBased('11:1-2');
        self::assertSame('11:1-2', $region->toString(new NamingConvention(NamingConvention::ENSEMBL)));
    }

    public function testParseHGVSg(): void
    {
        $region = GenomicRegion::parseOneBased('chr11:g.1-2');
        self::assertSame('chr11:1-2', $region->toString(new NamingConvention(NamingConvention::UCSC)));
    }

    public function testParseSingleBaseRegion(): void
    {
        $region = GenomicRegion::parseOneBased('chr1:100');
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
        GenomicRegion::parseOneBased($value);
    }

    public function testStartGreaterThanEnd(): void
    {
        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage('End (1) must not be less than start (2).');
        GenomicRegion::parseOneBased('11:2-1');
    }

    public function testEquals(): void
    {
        self::assertTrue(
            GenomicRegion::parseOneBased('chr11:10-20')->equals(GenomicRegion::parseOneBased('11:10-20'))
        );
        self::assertFalse(
            GenomicRegion::parseOneBased('chr11:10-20')->equals(GenomicRegion::parseOneBased('chr11:10-21'))
        );
        self::assertFalse(
            GenomicRegion::parseOneBased('chr11:10-20')->equals(GenomicRegion::parseOneBased('chr12:10-20'))
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
        self::assertSame($expected, GenomicRegion::parseOneBased($region)->length());
    }

    public function testContainsPosition(): void
    {
        $region = GenomicRegion::parseOneBased('chr11:g.1-20');
        self::assertTrue($region->containsPosition(GenomicPosition::parseOneBased('chr11:20')));
        self::assertFalse($region->containsPosition(GenomicPosition::parseOneBased('chr11:21')));
    }

    public function testContainsPositionAcrossNamingConventions(): void
    {
        $region = GenomicRegion::parseOneBased('chr11:1-20');
        self::assertTrue($region->containsPosition(GenomicPosition::parseOneBased('11:15')));
    }

    public function testContainsPositionAtStartBoundary(): void
    {
        $region = GenomicRegion::parseOneBased('chr11:10-20');
        self::assertTrue($region->containsPosition(GenomicPosition::parseOneBased('chr11:10')));
    }

    public function testContainsRegion(): void
    {
        $region = GenomicRegion::parseOneBased('chr11:g.1-20');
        self::assertTrue($region->containsRegion(GenomicRegion::parseOneBased('chr11:19-20')));
        self::assertFalse($region->containsRegion(GenomicRegion::parseOneBased('chr11:21-22')));
    }

    public function testIsCoveredBy(): void
    {
        $region = GenomicRegion::parseOneBased('chr11:g.20-30');
        self::assertTrue($region->isCoveredBy(GenomicRegion::parseOneBased('chr11:g.15-35')));
        self::assertFalse($region->isCoveredBy(GenomicRegion::parseOneBased('chr11:g.22-35')));
    }

    public function testIsCoveredByIdenticalRegion(): void
    {
        $region = GenomicRegion::parseOneBased('chr11:20-30');
        self::assertTrue($region->isCoveredBy(GenomicRegion::parseOneBased('chr11:20-30')));
    }

    public function testIntersectsPartialOverlap(): void
    {
        $region = GenomicRegion::parseOneBased('chr11:g.20-30');
        self::assertTrue($region->intersects(GenomicRegion::parseOneBased('chr11:15-25')));
        self::assertTrue($region->intersects(GenomicRegion::parseOneBased('chr11:25-35')));
    }

    public function testIntersectsNoOverlap(): void
    {
        $region = GenomicRegion::parseOneBased('chr11:g.20-30');
        self::assertFalse($region->intersects(GenomicRegion::parseOneBased('chr11:15-19')));
    }

    public function testIntersectsAdjacentRegion(): void
    {
        $region = GenomicRegion::parseOneBased('chr11:10-20');
        self::assertFalse($region->intersects(GenomicRegion::parseOneBased('chr11:21-30')));
    }

    public function testIntersectsSinglePointOverlap(): void
    {
        $region = GenomicRegion::parseOneBased('chr1:10-20');
        self::assertTrue($region->intersects(GenomicRegion::parseOneBased('chr1:20-30')));
    }

    public function testIntersectionPartial(): void
    {
        $a = GenomicRegion::parseOneBased('chr11:10-20');
        $b = GenomicRegion::parseOneBased('chr11:15-25');

        $overlap = $a->intersection($b);
        self::assertNotNull($overlap);
        self::assertTrue($overlap->equals(GenomicRegion::parseOneBased('chr11:15-20')));
        self::assertSame(6, $overlap->length());
    }

    public function testIntersectionFullyContained(): void
    {
        $outer = GenomicRegion::parseOneBased('chr11:10-30');
        $inner = GenomicRegion::parseOneBased('chr11:15-20');

        $overlap = $outer->intersection($inner);
        self::assertNotNull($overlap);
        self::assertTrue($overlap->equals($inner));
    }

    public function testIntersectionSinglePoint(): void
    {
        $a = GenomicRegion::parseOneBased('chr1:10-20');
        $b = GenomicRegion::parseOneBased('chr1:20-30');

        $overlap = $a->intersection($b);
        self::assertNotNull($overlap);
        self::assertTrue($overlap->equals(GenomicRegion::parseOneBased('chr1:20-20')));
        self::assertSame(1, $overlap->length());
    }

    public function testIntersectionReturnsNullWhenNoIntersection(): void
    {
        $a = GenomicRegion::parseOneBased('chr11:10-20');
        $b = GenomicRegion::parseOneBased('chr11:21-30');

        self::assertNull($a->intersection($b));
    }

    public function testDifferentChromosomesNeverMatch(): void
    {
        $region = GenomicRegion::parseOneBased('chr11:1-100');
        $other = GenomicRegion::parseOneBased('chr12:10-20');
        self::assertFalse($region->containsPosition(GenomicPosition::parseOneBased('chr12:50')));
        self::assertFalse($region->containsRegion($other));
        self::assertFalse($region->intersects($other));
        self::assertNull($region->intersection($other));
    }

    public function testParseRejectsPositionZero(): void
    {
        self::expectException(\InvalidArgumentException::class);
        GenomicRegion::parseOneBased('chr1:0-10');
    }

    public function testContainsRegionIsInverseOfIsCoveredBy(): void
    {
        $outer = GenomicRegion::parseOneBased('chr11:10-30');
        $inner = GenomicRegion::parseOneBased('chr11:15-20');

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
        $region = GenomicRegion::parseOneBased('chr11:10-20');
        self::assertFalse($region->isCoveredBy(GenomicRegion::parseOneBased('chr12:1-100')));
    }

    public function testFromZeroBasedHalfOpenConvertsToOneBased(): void
    {
        // BED: chr7  55249070  55249171 (EGFR Exon 19, 0-based half-open)
        $region = GenomicRegion::fromZeroBasedHalfOpen('chr7', 55249070, 55249171);

        self::assertSame(55249071, $region->start);
        self::assertSame(55249171, $region->end);
        self::assertSame(101, $region->length());
    }

    public function testFromZeroBasedHalfOpenSingleBase(): void
    {
        // BED single base: chr1  99  100 → 1-based chr1:100-100
        $region = GenomicRegion::fromZeroBasedHalfOpen('chr1', 99, 100);

        self::assertSame(100, $region->start);
        self::assertSame(100, $region->end);
        self::assertSame(1, $region->length());
    }

    public function testToZeroBasedHalfOpenRoundTrips(): void
    {
        $region = GenomicRegion::fromZeroBasedHalfOpen('chr7', 55249070, 55249171);

        [$chromosome, $start, $end] = $region->toZeroBasedHalfOpen();

        self::assertSame('7', $chromosome->value());
        self::assertSame(55249070, $start);
        self::assertSame(55249171, $end);
    }

    public function testFromZeroBasedHalfOpenLengthMatchesBedFormula(): void
    {
        $bedStart = 1000;
        $bedEnd = 2000;

        $region = GenomicRegion::fromZeroBasedHalfOpen('chr1', $bedStart, $bedEnd);

        // BED length = end - start; 1-based length = end - start + 1
        // Both must agree on the actual number of bases
        self::assertSame($bedEnd - $bedStart, $region->length());
    }

    public function testGenomicPositions(): void
    {
        $region = GenomicRegion::parseOneBased('chr11:10-13');
        $positions = $region->genomicPositions();

        self::assertCount(4, $positions);
        self::assertEquals($region->length(), count($positions));

        self::assertTrue($positions[0]->equals(GenomicPosition::parseOneBased('chr11:10')));
        self::assertTrue($positions[1]->equals(GenomicPosition::parseOneBased('chr11:11')));
        self::assertTrue($positions[2]->equals(GenomicPosition::parseOneBased('chr11:12')));
        self::assertTrue($positions[3]->equals(GenomicPosition::parseOneBased('chr11:13')));
    }

    public function testGenomicPositionsSingleBase(): void
    {
        $region = GenomicRegion::parseOneBased('chr1:42');
        $positions = $region->genomicPositions();

        self::assertCount(1, $positions);
        self::assertTrue($positions[0]->equals(GenomicPosition::parseOneBased('chr1:42')));
    }

    public function testGenomicPositionsFromZeroBasedHalfOpen(): void
    {
        $region = GenomicRegion::fromZeroBasedHalfOpen('chr1', 99, 102);
        $positions = $region->genomicPositions();

        self::assertCount(3, $positions);
        self::assertTrue($positions[0]->equals(GenomicPosition::parseOneBased('chr1:100')));
        self::assertTrue($positions[1]->equals(GenomicPosition::parseOneBased('chr1:101')));
        self::assertTrue($positions[2]->equals(GenomicPosition::parseOneBased('chr1:102')));
    }

    public function testIntersectionIsCommutative(): void
    {
        $a = GenomicRegion::parseOneBased('chr11:10-20');
        $b = GenomicRegion::parseOneBased('chr11:15-25');

        $ab = $a->intersection($b);
        $ba = $b->intersection($a);

        self::assertNotNull($ab);
        self::assertNotNull($ba);
        self::assertTrue($ab->equals($ba));
    }
}
