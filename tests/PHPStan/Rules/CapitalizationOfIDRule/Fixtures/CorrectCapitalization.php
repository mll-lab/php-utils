<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan\Rules\CapitalizationOfIDRule\Fixtures;

/**
 * Fixture file containing correct "ID" capitalizations.
 * Used for integration testing of CapitalizationOfIDRule.
 */
class CorrectCapitalization
{
    public function getLabID(): int // Correct: "ID" uppercase
    {
        return 1;
    }

    public function processLabID(int $labID): void // Correct: "ID" uppercase
    {
        $sampleID = $labID; // Correct: "ID" uppercase
    }

    public function getIdentifier(): string // Correct: "Identifier" is a false positive
    {
        return 'test';
    }

    public function isIdentical(int $a, int $b): bool // Correct: "Identical" is a false positive
    {
        return $a === $b;
    }
}
