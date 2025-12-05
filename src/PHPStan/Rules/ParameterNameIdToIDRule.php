<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Param;

/** Checks that "ID" is used instead of "Id" in parameter names. */
final class ParameterNameIdToIDRule extends CapitalizationOfIDRule
{
    public function getNodeType(): string
    {
        return Param::class;
    }

    protected function getErrorIdentifier(): string
    {
        return 'mll.parameterNameIdToID';
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
