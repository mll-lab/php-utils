<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

use Illuminate\Support\Str;
use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/** @implements Rule<Node> */
class NameIdToIDRule implements Rule
{
    /** Lists words or phrases that contain "Id" but are fine. */
    protected const FALSE_POSITIVES = [
        'Identifier',
        'Identical',
        'Idt', // IDT is an abbreviation for the brand "Integrated DNA Technologies, Inc."
    ];

    public function getNodeType(): string
    {
        return Node::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $result = $this->extractNodeNameAndType($node);

        if ($result === null) {
            return [];
        }

        [$nodeName, $type] = $result;

        if (! static::containsWrongIDCapitalization($nodeName)) {
            return [];
        }

        $expectedName = static::fixIDCapitalization($nodeName);

        return [
            RuleErrorBuilder::message(
                <<<TXT
                {$type} Name "{$nodeName}" should use "ID" instead of "Id", rename it to "{$expectedName}".
                TXT
            )->identifier('mllLabRules.nameIdToID')
                ->build(),
        ];
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

    /** @return array{0: string, 1: string}|null */
    public function extractNodeNameAndType(Node $node): ?array
    {
        if ($node instanceof Variable && is_string($node->name)) {
            return [$node->name, 'Variable'];
        }
        if ($node instanceof Node\Param && $node->var instanceof Variable && is_string($node->var->name)) {
            return [$node->var->name, 'Parameter'];
        }
        if ($node instanceof ClassMethod) {
            return [$node->name->toString(), 'ClassMethod'];
        }
        if ($node instanceof Node\Stmt\Class_ && $node->name instanceof Node\Identifier) {
            return [$node->name->toString(), 'Class'];
        }

        return null;
    }
}
