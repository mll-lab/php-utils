<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;

final class MethodNameIdToIDRule extends CapitalizationOfIDRule
{
    public function getNodeType(): string
    {
        return ClassMethod::class;
    }

    protected function getErrorIdentifier(): string
    {
        return 'mll.methodNameIdToID';
    }

    protected function extractName(Node $node): string
    {
        assert($node instanceof ClassMethod);

        return $node->name->name;
    }
}
