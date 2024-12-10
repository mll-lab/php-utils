<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\NodeNameExtractor;

use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\Class_;

class ClassNameExtractor implements NodeNameExtractor
{
    public function extract(Node $node): ?string
    {
        if ($node instanceof Class_) {
            $name = $node->name;
            if ($name instanceof Identifier) {
                return $name->toString();
            }
        }

        return null;
    }
}
