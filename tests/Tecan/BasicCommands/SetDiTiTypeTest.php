<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Tecan\BasicCommands;

use MLL\Utils\Tecan\BasicCommands\SetDiTiType;
use PHPUnit\Framework\TestCase;

final class SetDiTiTypeTest extends TestCase
{
    public function testFormatToString(): void
    {
        $index = 7;
        $setDiTiType = new SetDiTiType($index);

        self::assertSame("S;{$index}", $setDiTiType->toString());
    }
}
