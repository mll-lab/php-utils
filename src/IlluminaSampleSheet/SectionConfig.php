<?php

namespace MLL\Utils\IlluminaSampleSheet;

class SectionConfig
{
    public int $index;

    public string $className;

    /**
     * @param int $index
     * @param string $className
     */
    public function __construct(int $index, string $className)
    {
        $this->index = $index;
        $this->className = $className;
    }
}
