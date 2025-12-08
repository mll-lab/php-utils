<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Param;

final class ParameterNameIdToIDRule extends IdToIDRule
{
    public function getNodeType(): string
    {
        return Param::class;
    }

    protected function getErrorIdentifier(): string
    {
        return 'mll.parameterNameIdToID';
    }

    protected function formatNameForMessage(string $name): string
    {
        return '$' . $name;
    }

    protected function extractName(Node $node): ?string
    {
        assert($node instanceof Param);

        if ($node->var instanceof Variable && is_string($node->var->name)) {
            return $node->var->name;
        }

        return null;
    }
}
