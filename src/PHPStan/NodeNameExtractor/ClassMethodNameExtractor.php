<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\NodeNameExtractor;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;

class ClassMethodNameExtractor implements NodeNameExtractor
{
    public function extract(Node $node): ?string
    {
        if ($node instanceof ClassMethod) {
            return $node->name->toString();
        }

        return null;
    }
}
