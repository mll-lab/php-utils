<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;
use function Safe\preg_match;

abstract class Sample
{
    abstract public function toString(): string;



    protected function validateSampleId(string $sampleId): string
    {
        if ($sampleId === '') {
            throw new IlluminaSampleSheetException('Sample ID cannot be empty.');
        }

        return $sampleId;
    }

    protected function validateSampleName(string $sampleName): string
    {
        if ($sampleName === '') {
            throw new IlluminaSampleSheetException('Sample Name cannot be empty.');
        }

        return $sampleName;
    }

}
