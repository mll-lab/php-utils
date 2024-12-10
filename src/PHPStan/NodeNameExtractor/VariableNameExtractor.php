<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\NodeNameExtractor;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Param;

class VariableNameExtractor implements NodeNameExtractor
{
    public function extract(Node $node): ?string
    {
        if ($node instanceof Variable) {
            $name = $node->name;
            if (is_string($name)) {
                return $name;
            }
        }

        if ($node instanceof Param) {
            $var = $node->var;
            if ($var instanceof Variable) {
                $name = $var->name;
                if (is_string($name)) {
                    return $name;
                }
            }
        }

        return null;
    }
}
