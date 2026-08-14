<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\ArrowFunction;
use PHPStan\Rules\RuleErrorBuilder;

final class MissingClosureReturnTypehintRule extends ClosureTypehintRule
{
    protected function processClosure(Node\FunctionLike $closure): array
    {
        if ($closure->getReturnType() instanceof Node) {
            return [];
        }

        $kind = $closure instanceof ArrowFunction ? 'Arrow function' : 'Closure';

        return [
            RuleErrorBuilder::message("{$kind} is missing a native return type hint.")
                ->identifier('missingType.closureReturn')
                ->build(),
        ];
    }
}
