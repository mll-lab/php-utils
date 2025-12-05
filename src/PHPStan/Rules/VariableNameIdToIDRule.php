<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;

final class VariableNameIdToIDRule extends CapitalizationOfIDRule
{
    public function getNodeType(): string
    {
        return Variable::class;
    }

    protected function getErrorIdentifier(): string
    {
        return 'mll.variableNameIdToID';
    }

    protected function formatNameForMessage(string $name): string
    {
        return '$' . $name;
    }

    protected function extractName(Node $node): ?string
    {
        assert($node instanceof Variable);

        if (is_string($node->name)) {
            return $node->name;
        }

        return null;
    }
}
