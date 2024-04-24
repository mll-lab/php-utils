<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;

abstract class Sample
{
    abstract public function toString(): string;

    protected function validateIndex(string $index): string
    {
        if (! $this->isValidNucleotidSequence($index)) {
            throw new IlluminaSampleSheetException('Index contains invalid characters. Only A, T, C, G, N are allowed.');
        }

        return $index;
    }

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

    protected function isValidNucleotidSequence(string $index): bool
    {
        return (bool) \Safe\preg_match('/^[ATCGN]+$/', $index);
    }
}
