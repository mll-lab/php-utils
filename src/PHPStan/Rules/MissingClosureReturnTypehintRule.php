<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

use PhpParser\Node;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * Assumes PHP 8.0+, where every return type is natively expressible.
 * On PHP 7.4 a closure returning `mixed` has no native type to declare,
 * which is why `phpstan/include-by-php-version.php` gates `rules.neon`.
 */
final class MissingClosureReturnTypehintRule extends ClosureTypehintRule
{
    protected function processClosure(Node\FunctionLike $closure): array
    {
        if ($closure->getReturnType() instanceof Node) {
            return [];
        }

        $kind = $this->closureKind($closure);

        return [
            RuleErrorBuilder::message("{$kind} is missing a native return type hint.")
                ->identifier('missingType.closureReturn')
                ->build(),
        ];
    }
}
