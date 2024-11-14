<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

use Illuminate\Support\Str;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Node\Expr\Variable>
 */
class VariableNameIdToIDRule implements Rule
{
    private const WHITELIST = ['Identifier'];

    public function getNodeType(): string
    {
        return Node\Expr\Variable::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if (
            is_string($node->name)
            && \Safe\preg_match('/Id/', $node->name) === 1
            && ! Str::contains($node->name, self::WHITELIST)
        ) {
            return [
                RuleErrorBuilder::message(sprintf(
                    'Variable name "$%s" should use "ID" instead of "Id".',
                    $node->name,
                ))->build(),
            ];
        }

        return [];
    }
}
