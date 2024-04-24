<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Tecan\BasicCommands;

use MLL\Utils\Tecan\BasicCommands\Wash;
use PHPUnit\Framework\TestCase;

final class WashTest extends TestCase
{
    public function testWashCommand(): void
    {
        self::assertSame('W;', (new Wash())->toString());
    }
}
