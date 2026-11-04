<?php declare(strict_types=1);

namespace MLL\Utils\Tests;

use MLL\Utils\AlternateAllele;
use PHPUnit\Framework\TestCase;

final class AlternateAlleleTest extends TestCase
{
    public function testMissingAllele(): void
    {
        $alternateAllele = new AlternateAllele('.');
        self::assertTrue($alternateAllele->isMissing());
        self::assertSame('.', $alternateAllele->toString());
    }

    public function testBases(): void
    {
        $alternateAllele = new AlternateAllele('acn');
        self::assertFalse($alternateAllele->isMissing());
        self::assertSame('ACN', $alternateAllele->toString());
    }

    public function testInvalidAlleleThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new AlternateAllele('..');
    }
}
