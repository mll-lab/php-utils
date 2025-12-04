<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\NodeNameExtractor;

use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\Class_;

final class ClassNameExtractor implements NodeNameExtractor
{
    public function extract(Node $node): ?string
    {
        if ($node instanceof Class_ && $node->name instanceof Identifier) {
            return $node->name->name;
        }

        return null;
    }
}
