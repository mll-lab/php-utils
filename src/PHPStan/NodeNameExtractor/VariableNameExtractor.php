<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\NodeNameExtractor;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Param;

class VariableNameExtractor implements NodeNameExtractor
{
    public function extract(Node $node): ?string
    {
        if ($node instanceof Variable && is_string($node->name)) {
            return $node->name;
        }
        if ($node instanceof Param
            && $node->var instanceof Variable
            && is_string($node->var->name)
        ) {
            return $node->var->name;
        }

        return null;
    }
}
