<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Class_>
 */
class ThrowableClassNameRule implements Rule
{
    public function getNodeType(): string
    {
        return Class_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $className = (string) $node->name;
        $extendsThrowable = false;

        if ($node->extends !== null) {
            $parentClass = $node->extends->toString();
            $extendsThrowable = is_subclass_of($parentClass, \Throwable::class) || $parentClass === \Throwable::class;
        }

        if ($extendsThrowable && ! str_ends_with($className, 'Exception')) {
            return [
                RuleErrorBuilder::message(sprintf(
                    'Class "%s" extends \Throwable but does not use the suffix "Exception".',
                    $className
                ))->build(),
            ];
        }

        if (! $extendsThrowable && str_ends_with($className, 'Exception')) {
            return [
                RuleErrorBuilder::message(sprintf(
                    'Class "%s" uses the suffix "Exception" but does not extend \Throwable. Consider using "Exemption" or another term.',
                    $className
                ))->build(),
            ];
        }

        return [];
    }
}
