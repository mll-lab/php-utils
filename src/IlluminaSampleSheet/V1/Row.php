<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use Illuminate\Support\Collection;

abstract class Row
{
    public string $sampleID;

    abstract public function toString(): string;

    /** @return Collection<int, string> */
    abstract public function getColumns(): Collection;
}
