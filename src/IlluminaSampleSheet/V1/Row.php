<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

abstract class Row
{
    public string $sampleID;

    abstract public function toString(): string;

    abstract public function headerLine(): string;
}
