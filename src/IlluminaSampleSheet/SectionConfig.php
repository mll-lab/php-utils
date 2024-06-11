<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet;

class SectionConfig
{
    public int $index;

    public string $className;

    public function __construct(int $index, string $className)
    {
        $this->index = $index;
        $this->className = $className;
    }
}
