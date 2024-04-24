<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

interface DataInterface
{
    /** @return array<string> */
    public function getColumns(): array;

    /** @return array<array<string|int>> */
    public function getRows(): array;
}
