<?php declare(strict_types=1);

namespace MLL\Utils\Tests\QxManager;

use MLL\Utils\QxManager\EmptyRow;
use PHPUnit\Framework\TestCase;

final class EmptyRowTest extends TestCase
{
    public function testToString(): void
    {
        self::assertSame('No,,,,,,,,,,,,,,,,', (new EmptyRow())->toString());
    }
}
