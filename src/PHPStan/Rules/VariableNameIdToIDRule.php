<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

/**
 * Checks that "ID" is used instead of "Id" in variable names only.
 *
 * For checking parameters, methods, and classes as well, use CapitalizationOfIDRule directly.
 */
class VariableNameIdToIDRule extends CapitalizationOfIDRule
{
    public function __construct()
    {
        parent::__construct(
            true,  // checkVariables
            false, // checkParameters
            false, // checkMethods
            false  // checkClasses
        );
    }
}
