<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

/**
 * Enforces correct capitalization of "Lab ID".
 *
 * Detects variants like:
 * - LabID, labID, LABID (missing space)
 * - Labid, labid (wrong case)
 * - Lab-ID, lab-Id (wrong separator)
 * - Lab Id (wrong case after space)
 */
final class LabIDCapitalizationRule extends CanonicalCapitalizationRule
{
    protected function getCanonicalForm(): string
    {
        return 'Lab ID';
    }

    /** @return array<int, string> */
    protected function getWrongVariants(): array
    {
        return [
            'LabID',
            'labID',
            'LABID',
            'Labid',
            'labid',
            'Lab-ID',
            'lab-Id',
            'Lab Id',
            'lab id',
        ];
    }

    protected function getErrorIdentifier(): string
    {
        return 'mll.labIDCapitalization';
    }
}
