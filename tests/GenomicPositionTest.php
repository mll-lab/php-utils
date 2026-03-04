<?php declare(strict_types=1);

use MLL\Utils\Chromosome;
use MLL\Utils\GenomicPosition;
use MLL\Utils\NamingConvention;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class GenomicPositionTest extends TestCase
{
    public function testParseUCSC(): void
    {
        $position = GenomicPosition::parse('chr11:1');
        self::assertSame('chr11:1', $position->toString(new NamingConvention(NamingConvention::UCSC)));
    }

    public function testParseEnsembl(): void
    {
        $position = GenomicPosition::parse('11:1');
        self::assertSame('11:1', $position->toString(new NamingConvention(NamingConvention::ENSEMBL)));
    }

    public function testParseHGVSg(): void
    {
        $position = GenomicPosition::parse('chr11:g.1');
        self::assertSame('chr11:1', $position->toString(new NamingConvention(NamingConvention::UCSC)));
    }

    public function testOutputInBothConventions(): void
    {
        $position = GenomicPosition::parse('chr11:12345');
        self::assertSame('chr11:12345', $position->toString(new NamingConvention(NamingConvention::UCSC)));
        self::assertSame('11:12345', $position->toString(new NamingConvention(NamingConvention::ENSEMBL)));
    }

    public function testEquals(): void
    {
        self::assertTrue(
            GenomicPosition::parse('chr11:100')->equals(GenomicPosition::parse('11:100'))
        );
        self::assertFalse(
            GenomicPosition::parse('chr11:100')->equals(GenomicPosition::parse('chr11:101'))
        );
        self::assertFalse(
            GenomicPosition::parse('chr11:100')->equals(GenomicPosition::parse('chr12:100'))
        );
    }

    public function testConstructorRejectsNonPositivePosition(): void
    {
        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage('Position must be positive, got: 0.');
        new GenomicPosition(new Chromosome('chr1'), 0);
    }

    /** @return iterable<array{string}> */
    public static function invalidFormats(): iterable
    {
        yield ['11:1test'];
        yield ['chr1:0'];
        yield ['chr1:'];
        yield ['chr1'];
    }

    /** @dataProvider invalidFormats */
    #[DataProvider('invalidFormats')]
    public function testParseRejectsInvalidFormat(string $value): void
    {
        self::expectException(\InvalidArgumentException::class);
        GenomicPosition::parse($value);
    }
}
