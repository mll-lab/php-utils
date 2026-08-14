<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan;

use MLL\Utils\PHPStan\Rules\MissingClosureReturnTypehintRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<MissingClosureReturnTypehintRule>
 */
final class MissingClosureReturnTypehintRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new MissingClosureReturnTypehintRule();
    }

    public function testMissingReturnTypes(): void
    {
        $this->analyse([__DIR__ . '/data/closure-return-types.php'], [
            ['Closure is missing a native return type hint.', 3],
            ['Arrow function is missing a native return type hint.', 7],
        ]);
    }
}
