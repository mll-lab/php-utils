<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\CallLike;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\NullsafeMethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\IdentifierRuleError;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/** @implements Rule<CallLike> */
final class OneThingPerLineRule implements Rule
{
    public function getNodeType(): string
    {
        return CallLike::class;
    }

    /** @return list<IdentifierRuleError> */
    public function processNode(Node $node, Scope $scope): array
    {
        if (! $node instanceof MethodCall
            && ! $node instanceof NullsafeMethodCall) {
            return [];
        }

        $var = $node->var;
        if (! $var instanceof MethodCall
            && ! $var instanceof NullsafeMethodCall) {
            return [];
        }

        if ($node->name->getStartLine() !== $var->name->getStartLine()) {
            return [];
        }

        return [
            RuleErrorBuilder::message('Method chain calls must each be on their own line.')
                ->identifier('mll.oneThingPerLine')
                ->line($node->name->getStartLine())
                ->build(),
        ];
    }
}
