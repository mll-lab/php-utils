<?php declare(strict_types=1);

namespace MLL\Utils;

/**
 * The ALT of a VCF record, where `.` means there is no alternate allele.
 */
class AlternateAllele extends DnaSequence
{
    public const MISSING = '.';

    public function __construct(string $sequence)
    {
        if (trim($sequence) === self::MISSING) {
            $this->validatedSequence = self::MISSING;

            return;
        }

        parent::__construct($sequence);
    }

    public function isMissing(): bool
    {
        return $this->validatedSequence === self::MISSING;
    }
}
