<?php declare(strict_types=1);

use MLL\Utils\NamingConvention;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class NamingConventionTest extends TestCase
{
    public function testUCSC(): void
    {
        $convention = new NamingConvention(NamingConvention::UCSC);
        self::assertSame('UCSC', $convention->value);
    }

    public function testEnsembl(): void
    {
        $convention = new NamingConvention(NamingConvention::ENSEMBL);
        self::assertSame('ENSEMBL', $convention->value);
    }

    /** @return iterable<array{string}> */
    public static function invalidValues(): iterable
    {
        yield ['HGVS'];
        yield [''];
        yield ['ucsc'];
    }

    /** @dataProvider invalidValues */
    #[DataProvider('invalidValues')]
    public function testRejectsInvalidValue(string $value): void
    {
        self::expectException(\InvalidArgumentException::class);
        new NamingConvention($value);
    }
}
