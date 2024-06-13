<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;

use function Safe\preg_match;

abstract class Index
{
    abstract public function validate(): void;

    protected function validateIndex(string $index): void
    {
        if ($index === '') {
            throw new IlluminaSampleSheetException('Index must not be an empty string.');
        }

        if (! (bool) preg_match('/^[ATCGN]+$/', $index)) {
            throw new IlluminaSampleSheetException("Index '{$index}' contains invalid characters. Only A, T, C, G, N are allowed.");
        }
    }
}
