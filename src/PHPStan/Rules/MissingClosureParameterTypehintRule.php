<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PHPStan\Rules\RuleErrorBuilder;

final class MissingClosureParameterTypehintRule extends ClosureTypehintRule
{
    protected function processClosure(Node\FunctionLike $closure): array
    {
        $kind = $this->closureKind($closure);

        $errors = [];
        foreach ($closure->getParams() as $param) {
            if ($param->type !== null) {
                continue;
            }

            $paramVar = $param->var;

            if (! $paramVar instanceof Variable) {
                continue;
            }

            if (! is_string($paramVar->name)) {
                continue;
            }

            $varName = $paramVar->name;

            $errors[] = RuleErrorBuilder::message("{$kind} parameter {$varName} is missing a native type hint.")
                ->identifier('missingType.parameter')
                ->build();
        }

        return $errors;
    }
}
