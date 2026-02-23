<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\CallLike;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\NullsafeMethodCall;
use PhpParser\Node\Expr\NullsafePropertyFetch;
use PhpParser\Node\Expr\PropertyFetch;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\IdentifierRuleError;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

use function Safe\file_get_contents;

/**
 * @implements Rule<CallLike>
 */
final class OneThingPerLineRule implements Rule
{
    /** @var array<string, string> */
    private array $fileContentsCache = [];

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

        if ($var->getArgs() === []) {
            return [];
        }

        if ($this->isInsideStringInterpolation($scope->getFile(), $node)) {
            return [];
        }

        return [
            RuleErrorBuilder::message('Method chain calls must each be on their own line.')
                ->identifier('mll.oneThingPerLine')
                ->line($node->name->getStartLine())
                ->build(),
        ];
    }

    private function isInsideStringInterpolation(string $file, Expr $node): bool
    {
        $root = $node;
        while ($root instanceof MethodCall
            || $root instanceof NullsafeMethodCall
            || $root instanceof PropertyFetch
            || $root instanceof NullsafePropertyFetch) {
            $root = $root->var;
        }

        $startPos = $root->getStartFilePos();
        if ($startPos <= 0) {
            return false;
        }

        $this->fileContentsCache[$file] ??= file_get_contents($file);

        return $this->fileContentsCache[$file][$startPos - 1] === '{';
    }
}
