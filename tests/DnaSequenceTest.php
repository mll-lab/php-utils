<?php declare(strict_types=1);

namespace MLL\Utils\Tests;

use MLL\Utils\DnaSequence;
use PHPUnit\Framework\TestCase;

final class DnaSequenceTest extends TestCase
{
    public function testReverse(): void
    {
        $dnaSequence = new DnaSequence('ATGC');
        self::assertSame('CGTA', $dnaSequence->reverse());
    }

    public function testComplement(): void
    {
        $dnaSequence = new DnaSequence('ATGC');
        self::assertSame('TACG', $dnaSequence->complement());
    }

    public function testReverseComplement(): void
    {
        $dnaSequence = new DnaSequence('ATGC');
        self::assertSame('GCAT', $dnaSequence->reverseComplement());
    }

    public function testInvalidSequenceThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new DnaSequence('INVALID');
    }

    public function testEmptySequence(): void
    {
        $dnaSequence = new DnaSequence('');
        self::assertSame('', $dnaSequence->reverse());
        self::assertSame('', $dnaSequence->complement());
        self::assertSame('', $dnaSequence->reverseComplement());
    }
}
