<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan;

use MLL\Utils\PHPStan\Rules\VariableNameIdToIDRule;
use PHPUnit\Framework\TestCase;

/**
 * Tests for VariableNameIdToIDRule.
 *
 * The static methods (containsWrongIDCapitalization, fixIDCapitalization) are
 * tested in CapitalizationOfIDRuleTest since they are inherited unchanged.
 */
final class VariableNameIdToIDRuleTest extends TestCase
{
    public function testExtendsCapitalizationOfIDRule(): void
    {
        $rule = new VariableNameIdToIDRule();

        self::assertSame(\PhpParser\Node::class, $rule->getNodeType());
    }
}
