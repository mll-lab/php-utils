<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

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
