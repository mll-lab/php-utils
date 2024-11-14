<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

use Illuminate\Support\Str;
use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/** @implements Rule<Variable> */
class VariableNameIdToIDRule implements Rule
{
    /** Lists words or phrases that contain "Id" but are fine. */
    protected const FALSE_POSITIVES = ['Identifier'];

    public function getNodeType(): string
    {
        return Variable::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if (
            is_string($node->name)
            && \Safe\preg_match('/Id/', $node->name) === 1
            && ! Str::contains($node->name, self::FALSE_POSITIVES)
        ) {
            return [
                RuleErrorBuilder::message(<<<TXT
                Variable name "\${$node->name}" should use "ID" instead of "Id".
                TXT)->build(),
            ];
        }

        return [];
    }
}
