<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Tecan\BasicCommands;

use MLL\Utils\Tecan\BasicCommands\BreakCommand;
use PHPUnit\Framework\TestCase;

final class BreakTest extends TestCase
{
    public function testBreakCommand(): void
    {
        self::assertSame('B;', (new BreakCommand())->toString());
    }
}
