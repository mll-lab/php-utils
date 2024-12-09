<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\NodeNameExtractor;

use PhpParser\Node;

interface NodeNameExtractor
{
    public function extract(Node $node): ?string;
}
