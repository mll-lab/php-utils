<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\ClassMethod;

class NodeIdentifier
{
    /** @return array{0: string, 1: string}|null */
    public static function extractNodeNameAndType(Node $node): ?array
    {
        if ($node instanceof Variable && is_string($node->name)) {
            return [$node->name, 'Variable'];
        }
        if ($node instanceof Node\Param && $node->var instanceof Variable && is_string($node->var->name)) {
            return [$node->var->name, 'Parameter'];
        }
        if ($node instanceof ClassMethod) {
            return [$node->name->toString(), 'ClassMethod'];
        }
        if ($node instanceof Node\Stmt\Class_ && $node->name instanceof Node\Identifier) {
            return [$node->name->toString(), 'Class'];
        }

        return null;
    }

    /** @return array{0: string, 1: string}|null */
    public static function nodeNameForString(Node $node): ?array
    {
        if ($node instanceof String_) {
            return [$node->value, 'String'];
        }

        if ($node instanceof Node\Scalar\EncapsedStringPart) {
            return [$node->value, 'String'];
        }

        return null;
    }
}
