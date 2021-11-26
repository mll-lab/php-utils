<?php

declare(strict_types=1);

namespace Spawnia\PhpPackageTemplate\Tests\Unit;

use PHPUnit\Framework;
use Spawnia\PhpPackageTemplate\Example;

class ExampleTest extends Framework\TestCase
{
    public function testGreetIncludesName(): void
    {
        $name = 'spawnia';
        $example = new Example($name);

        self::assertStringContainsString($name, $example->greet());
    }
}
