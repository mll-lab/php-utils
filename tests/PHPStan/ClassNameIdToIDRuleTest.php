<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan;

use MLL\Utils\PHPStan\Rules\ClassNameIdToIDRule;
use PHPUnit\Framework\TestCase;

final class ClassNameIdToIDRuleTest extends TestCase
{
    public function testConvertsStandaloneIdToUppercase(): void
    {
        self::assertSame('ID', ClassNameIdToIDRule::fixIDCapitalization('Id'));
    }
}
