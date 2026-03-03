<?php declare(strict_types=1);

use MLL\Utils\Chromosome;
use MLL\Utils\NamingConvention;
use PHPUnit\Framework\TestCase;

final class ChromosomeTest extends TestCase
{
    public function testToStringWithDefault(): void
    {
        $chromosome = new Chromosome('chr11');
        self::assertSame('chr11', $chromosome->toString());
    }

    public function testToStringWithGRC37(): void
    {
        $chromosome = new Chromosome('chr11');
        self::assertSame('11', $chromosome->toString(new NamingConvention(NamingConvention::UCSC)));
    }

    public function testInitWithGRC37(): void
    {
        $chromosome = new Chromosome('11');
        self::assertSame('11', $chromosome->toString());
    }

    public function testFailedInit(): void
    {
        $chromosomeAsString = 'FOO11';
        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage("Invalid chromosome: {$chromosomeAsString}. Expected format: chr1-chr22, chrX, chrY, chrM, or without chr prefix.");
        new Chromosome($chromosomeAsString);
    }
}
