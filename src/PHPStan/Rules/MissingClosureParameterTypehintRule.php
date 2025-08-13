<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\ArrowFunction;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\Variable;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\IdentifierRuleError;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Node\Expr>
 */
final class MissingClosureParameterTypehintRule implements Rule
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

        $errors = [];
        foreach ($node->params as $param) {
            if ($param->type !== null) {
                continue;
            }

            $paramVar = $param->var;

            if (! $paramVar instanceof Variable) {
                continue;
            }

            if (! is_string($paramVar->name)) {
                continue;
            }

            $varName = $paramVar->name;

            $errors[] = RuleErrorBuilder::message("Closure parameter {$varName} is missing a native type hint.")
                ->identifier('closure.missingParameterType')
                ->build();
        }

        return $errors;
    }
}
