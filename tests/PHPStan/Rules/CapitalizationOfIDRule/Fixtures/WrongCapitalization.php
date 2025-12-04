<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan\Rules\CapitalizationOfIDRule\Fixtures;

/**
 * Fixture file containing wrong "Id" capitalizations.
 * Used for integration testing of CapitalizationOfIDRule.
 */
class WrongCapitalization
{
    // Wrong: class property would not be caught (we don't check properties)
    // But methods, parameters, and variables are checked

    public function getLabId(): int // Wrong: method name contains "Id"
    {
        return 1;
    }

    public function processLabId(int $labId): void // Wrong: parameter contains "Id"
    {
        $sampleId = $labId; // Wrong: variable contains "Id"
    }
}
