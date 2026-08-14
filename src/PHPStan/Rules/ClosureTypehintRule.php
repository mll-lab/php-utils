<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\ArrowFunction;
use PhpParser\Node\Expr\Closure;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\IdentifierRuleError;
use PHPStan\Rules\Rule;

/**
 * @implements Rule<Node\Expr>
 */
abstract class ClosureTypehintRule implements Rule
{
    /**
     * @param Closure|ArrowFunction $closure
     *
     * @return list<IdentifierRuleError>
     */
    abstract protected function processClosure(Node\FunctionLike $closure): array;

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

        return $this->processClosure($node);
    }
}
