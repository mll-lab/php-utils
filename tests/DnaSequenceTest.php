<?php declare(strict_types=1);

namespace MLL\Utils\Tests;

use MLL\Utils\DnaSequence;
use PHPUnit\Framework\TestCase;

class DnaSequenceTest extends TestCase
{
    public function testReverse(): void
    {
        $dnaSequence = new DnaSequence('ATGC');
        self::assertEquals('CGTA', $dnaSequence->reverse());
    }

    public function testComplement(): void
    {
        $dnaSequence = new DnaSequence('ATGC');
        self::assertEquals('TACG', $dnaSequence->complement());
    }

    public function testReverseComplement(): void
    {
        $dnaSequence = new DnaSequence('ATGC');
        self::assertEquals('GCAT', $dnaSequence->reverseComplement());
    }

    public function testInvalidSequenceThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new DnaSequence('INVALID');
    }

    public function testEmptySequence(): void
    {
        $dnaSequence = new DnaSequence('');
        self::assertEquals('', $dnaSequence->reverse());
        self::assertEquals('', $dnaSequence->complement());
        self::assertEquals('', $dnaSequence->reverseComplement());
    }
}
