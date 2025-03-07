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
    protected const FALSE_POSITIVES = ['Identifier', 'Identity'];

    public function getNodeType(): string
    {
        return Variable::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $nodeName = $node->name;

        if (is_string($nodeName)
            && static::containsWrongIDCapitalization($nodeName)
        ) {
            $expectedName = static::fixIDCapitalization($nodeName);

            return [
                RuleErrorBuilder::message(<<<TXT
                Variable name "\${$nodeName}" should use "ID" instead of "Id", rename it to "\${$expectedName}".
                TXT)->identifier('mll.nameIdToID')
                    ->build(),
            ];
        }

        return [];
    }

    public static function containsWrongIDCapitalization(string $nodeName): bool
    {
        return \Safe\preg_match('/Id/', $nodeName) === 1
            && ! Str::contains($nodeName, self::FALSE_POSITIVES);
    }

    public static function fixIDCapitalization(string $nodeName): string
    {
        if ($nodeName === 'Id') {
            return 'id';
        }

        return str_replace('Id', 'ID', $nodeName);
    }
}
