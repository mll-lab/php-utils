<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\Class_;

final class ClassNameIdToIDRule extends CapitalizationOfIDRule
{
    public function getNodeType(): string
    {
        return Class_::class;
    }

    protected function getErrorIdentifier(): string
    {
        return 'mll.classNameIdToID';
    }

    protected function extractName(Node $node): ?string
    {
        assert($node instanceof Class_);

        if ($node->name instanceof Identifier) {
            return $node->name->name;
        }

        return null;
    }

    public static function fixIDCapitalization(string $nodeName): string
    {
        return str_replace('Id', 'ID', $nodeName);
    }
}
