<?php declare(strict_types=1);

namespace MLL\Utils\Tests;

use MLL\Utils\Chromosome;
use MLL\Utils\DnaSequence;
use MLL\Utils\GenomicPosition;
use MLL\Utils\NamingConvention;
use MLL\Utils\NucleotidePosition;
use MLL\Utils\VariantIdentifier;
use MLL\Utils\VariantIdentifierFormat;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class VariantIdentifierTest extends TestCase
{
    public function testConstructAndToStringVCF(): void
    {
        $variant = new VariantIdentifier(
            new GenomicPosition(new Chromosome('chr1'), NucleotidePosition::fromOneBased(12345)),
            new DnaSequence('A'),
            new DnaSequence('T')
        );

        self::assertSame(
            'chr1-12345-A-T',
            $variant->toString(new VariantIdentifierFormat(VariantIdentifierFormat::VCF), new NamingConvention(NamingConvention::UCSC))
        );
    }

    public function testConstructAndToStringCanonical(): void
    {
        $variant = new VariantIdentifier(
            new GenomicPosition(new Chromosome('chr1'), NucleotidePosition::fromOneBased(12345)),
            new DnaSequence('A'),
            new DnaSequence('ATT')
        );

        self::assertSame(
            'chr1-12345-A/ATT',
            $variant->toString(new VariantIdentifierFormat(VariantIdentifierFormat::CANONICAL), new NamingConvention(NamingConvention::UCSC))
        );
    }

    public function testToStringEnsembl(): void
    {
        $variant = new VariantIdentifier(
            new GenomicPosition(new Chromosome('chrX'), NucleotidePosition::fromOneBased(99999)),
            new DnaSequence('GC'),
            new DnaSequence('A')
        );

        self::assertSame(
            'X-99999-GC-A',
            $variant->toString(new VariantIdentifierFormat(VariantIdentifierFormat::VCF), new NamingConvention(NamingConvention::ENSEMBL))
        );
        self::assertSame(
            'X-99999-GC/A',
            $variant->toString(new VariantIdentifierFormat(VariantIdentifierFormat::CANONICAL), new NamingConvention(NamingConvention::ENSEMBL))
        );
    }

    /** @dataProvider parseVCFProvider */
    #[DataProvider('parseVCFProvider')]
    public function testParseVCF(string $input, string $expectedChromosome, int $expectedPosition, string $expectedRef, string $expectedAlt): void
    {
        $variant = VariantIdentifier::parse($input);

        self::assertSame($expectedChromosome, $variant->genomicPosition->chromosome->value());
        self::assertSame($expectedPosition, $variant->genomicPosition->position);
        self::assertSame($expectedRef, $variant->reference->toString());
        self::assertSame($expectedAlt, $variant->alternate->toString());
    }

    /** @return iterable<string, array{string, string, int, string, string}> */
    public static function parseVCFProvider(): iterable
    {
        yield 'SNV with chr prefix' => ['chr1-12345-A-T', '1', 12345, 'A', 'T'];
        yield 'SNV without chr prefix' => ['1-12345-A-T', '1', 12345, 'A', 'T'];
        yield 'deletion' => ['chr7-5000-ATG-A', '7', 5000, 'ATG', 'A'];
        yield 'insertion' => ['chrX-99999-A-ATCG', 'X', 99999, 'A', 'ATCG'];
        yield 'chromosome 22' => ['chr22-100-G-C', '22', 100, 'G', 'C'];
        yield 'mitochondrial' => ['chrM-8000-T-C', 'M', 8000, 'T', 'C'];
    }

    /** @dataProvider parseCanonicalProvider */
    #[DataProvider('parseCanonicalProvider')]
    public function testParseCanonical(string $input, string $expectedChromosome, int $expectedPosition, string $expectedRef, string $expectedAlt): void
    {
        $variant = VariantIdentifier::parse($input);

        self::assertSame($expectedChromosome, $variant->genomicPosition->chromosome->value());
        self::assertSame($expectedPosition, $variant->genomicPosition->position);
        self::assertSame($expectedRef, $variant->reference->toString());
        self::assertSame($expectedAlt, $variant->alternate->toString());
    }

    /** @return iterable<string, array{string, string, int, string, string}> */
    public static function parseCanonicalProvider(): iterable
    {
        yield 'SNV with chr prefix' => ['chr1-12345-A/T', '1', 12345, 'A', 'T'];
        yield 'multi-base alternate' => ['chr1-12345-A/ATT', '1', 12345, 'A', 'ATT'];
        yield 'without chr prefix' => ['12-500-G/CA', '12', 500, 'G', 'CA'];
    }

    public function testParseInvalidVCFThrows(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        VariantIdentifier::parse('invalid');
    }

    public function testParseInvalidCanonicalThrows(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        VariantIdentifier::parse('invalid/stuff');
    }

    public function testRoundtripVCF(): void
    {
        $input = 'chr7-140753336-A-T';
        $variant = VariantIdentifier::parse($input);

        self::assertSame(
            $input,
            $variant->toString(new VariantIdentifierFormat(VariantIdentifierFormat::VCF), new NamingConvention(NamingConvention::UCSC))
        );
    }

    public function testRoundtripCanonical(): void
    {
        $input = 'chr7-140753336-A/T';
        $variant = VariantIdentifier::parse($input);

        self::assertSame(
            $input,
            $variant->toString(new VariantIdentifierFormat(VariantIdentifierFormat::CANONICAL), new NamingConvention(NamingConvention::UCSC))
        );
    }
}
