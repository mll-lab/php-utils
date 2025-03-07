<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

use Illuminate\Support\Str;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/** @implements Rule<Class_> */
class ThrowableClassNameRule implements Rule
{
    private ReflectionProvider $reflectionProvider;

    public function __construct(
        ReflectionProvider $reflectionProvider
    ) {
        $this->reflectionProvider = $reflectionProvider;
    }

    public function getNodeType(): string
    {
        return Class_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $nodeName = $node->name;
        if ($nodeName === null) {
            return [];
        }

        $className = $nodeName->name;

        $extends = $node->extends;
        if ($extends === null) {
            if (Str::endsWith($className, 'Exception')) {
                return [
                    RuleErrorBuilder::message(<<<TXT
                    Class "{$className}" is suffixed with "Exception" but does not extend \Exception. Consider using "Exemption" or another term.
                    TXT)->identifier('mll.exceptionSuffix')->build(),
                ];
            }

            return [];
        }

        $parentClass = $extends->toString();
        $extendsThrowable = $this->reflectionProvider->getClass($parentClass)
            ->is(\Exception::class);

        if ($extendsThrowable && ! Str::endsWith($className, 'Exception')) {
            return [
                RuleErrorBuilder::message(<<<TXT
                Class "{$className}" extends \Exception but is not suffixed with "Exception".
                TXT)->identifier('mll.exceptionSuffix')
                    ->build(),
            ];
        }

        return [];
    }
}
