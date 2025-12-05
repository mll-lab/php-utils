<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan;

use MLL\Utils\PHPStan\Rules\VariableNameIdToIDRule;
use PhpParser\Node\Expr\Variable;
use PHPUnit\Framework\TestCase;

/**
 * Tests for VariableNameIdToIDRule.
 *
 * Static methods (containsWrongIDCapitalization, fixIDCapitalization) are
 * tested in CapitalizationOfIDRuleTest since they are inherited unchanged.
 */
final class VariableNameIdToIDRuleTest extends TestCase
{
    public function testReturnsCorrectNodeType(): void
    {
        $rule = new VariableNameIdToIDRule();

        self::assertSame(Variable::class, $rule->getNodeType());
    }
}
