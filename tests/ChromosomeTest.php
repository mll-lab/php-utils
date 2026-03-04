<?php declare(strict_types=1);

use MLL\Utils\Chromosome;
use MLL\Utils\NamingConvention;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class ChromosomeTest extends TestCase
{
    public function testToStringFromEnsemblInput(): void
    {
        $chromosome = new Chromosome('11');
        self::assertSame('11', $chromosome->toString(new NamingConvention(NamingConvention::ENSEMBL)));
        self::assertSame('chr11', $chromosome->toString(new NamingConvention(NamingConvention::UCSC)));
    }

    /** @return iterable<array{string, string}> */
    public static function canonicalValues(): iterable
    {
        yield ['chr11', '11'];
        yield ['11', '11'];
        yield ['chr1', '1'];
        yield ['chr22', '22'];
        yield ['X', 'X'];
        yield ['chrx', 'X'];
        yield ['chrY', 'Y'];
        yield ['chrM', 'M'];
        yield ['MT', 'M'];
        yield ['chrMT', 'M'];
    }

    /** @dataProvider canonicalValues */
    #[DataProvider('canonicalValues')]
    public function testValueReturnsCanonicalForm(string $input, string $expected): void
    {
        self::assertSame($expected, (new Chromosome($input))->value());
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

    public function testNotEqualsDifferentChromosome(): void
    {
        self::assertFalse((new Chromosome('chr1'))->equals(new Chromosome('chr2')));
    }

    public function testCaseInsensitivePrefixDetection(): void
    {
        $chr = new Chromosome('CHR11');
        self::assertSame('chr11', $chr->toString(new NamingConvention(NamingConvention::UCSC)));

        $chr2 = new Chromosome('Chr11');
        self::assertSame('chr11', $chr2->toString(new NamingConvention(NamingConvention::UCSC)));
    }

    /** @return iterable<array{string}> */
    public static function invalidChromosomes(): iterable
    {
        yield [''];
        yield ['chr0'];
        yield ['chr23'];
        yield ['FOO11'];
        yield [' chr1'];
        yield ['chr1 '];
    }

    /** @dataProvider invalidChromosomes */
    #[DataProvider('invalidChromosomes')]
    public function testRejectsInvalidInput(string $input): void
    {
        self::expectException(\InvalidArgumentException::class);
        new Chromosome($input);
    }
}
