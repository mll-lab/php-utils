<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\NodeNameExtractor;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Param;

final class ParameterNameExtractor implements NodeNameExtractor
{
    public function extract(Node $node): ?string
    {
        if ($node instanceof Param && $node->var instanceof Variable && is_string($node->var->name)) {
            return $node->var->name;
        }

        return null;
    }
}
