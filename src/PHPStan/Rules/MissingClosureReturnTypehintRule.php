<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\ArrowFunction;
use PhpParser\Node\Expr\Closure;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\IdentifierRuleError;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Node\Expr>
 */
final class MissingClosureReturnTypehintRule implements Rule
{
    /** @return class-string<Node\Expr> */
    public function getNodeType(): string
    {
        return Node\Expr::class;
    }

    /**
     * @param Node\Expr $node
     *
     * @return list<IdentifierRuleError>
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (! $node instanceof Closure && ! $node instanceof ArrowFunction) {
            return [];
        }

        if ($node->returnType instanceof Node) {
            return [];
        }

        $kind = $node instanceof ArrowFunction ? 'Arrow function' : 'Closure';

        return [
            RuleErrorBuilder::message("{$kind} is missing a native return type hint.")
                ->identifier('missingType.closureReturn')
                ->build(),
        ];
    }
}
