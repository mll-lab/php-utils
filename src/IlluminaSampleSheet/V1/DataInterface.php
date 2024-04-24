<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use MLL\Utils\CSVArray;

/**
 * @phpstan-import-type CSVPrimitive from CSVArray
 */
interface DataInterface
{
    /** @return array<string> */
    public function getColumns(): array;

    /** @return array<array<CSVPrimitive>> */
    public function getRows(): array;
}
