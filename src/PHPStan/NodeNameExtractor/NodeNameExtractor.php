<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\NodeNameExtractor;

use PhpParser\Node;

interface NodeNameExtractor
{
    /** @return string|null Returns the name if extractable, null otherwise. */
    public function extract(Node $node): ?string;
}
