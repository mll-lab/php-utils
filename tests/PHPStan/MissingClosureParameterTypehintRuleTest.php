<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan;

use MLL\Utils\PHPStan\Rules\MissingClosureParameterTypehintRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<MissingClosureParameterTypehintRule>
 */
final class MissingClosureParameterTypehintRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new MissingClosureParameterTypehintRule();
    }

    public function testMissingParameterTypes(): void
    {
        $this->analyse([__DIR__ . '/data/closure-parameter-types.php'], [
            ['Closure parameter factor is missing a native type hint.', 3],
            ['Arrow function parameter factor is missing a native type hint.', 7],
        ]);
    }
}
