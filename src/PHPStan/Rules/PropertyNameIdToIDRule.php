<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\PropertyProperty;

final class PropertyNameIdToIDRule extends IdToIDRule
{
    public function getNodeType(): string
    {
        return PropertyProperty::class;
    }

    protected function getErrorIdentifier(): string
    {
        return 'mll.propertyNameIdToID';
    }

    protected function formatNameForMessage(string $name): string
    {
        return '$' . $name;
    }

    protected function extractName(Node $node): string
    {
        assert($node instanceof PropertyProperty);

        return $node->name->name;
    }
}
