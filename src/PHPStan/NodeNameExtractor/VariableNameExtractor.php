<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\NodeNameExtractor;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;

final class VariableNameExtractor implements NodeNameExtractor
{
    public function extract(Node $node): ?string
    {
        if ($node instanceof Variable && is_string($node->name)) {
            return $node->name;
        }

        return null;
    }
}
