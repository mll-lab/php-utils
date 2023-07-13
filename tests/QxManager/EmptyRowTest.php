<?php declare(strict_types=1);

namespace MLL\Utils\Tests\QxManager;

use MLL\Utils\QxManager\EmptyRow;
use PHPUnit\Framework\TestCase;

class EmptyRowTest extends TestCase
{
    public function testToString(): void
    {
        self::assertEquals('No,,,,,,,,,,,,,,,,', (new EmptyRow())->toString());
    }
}
