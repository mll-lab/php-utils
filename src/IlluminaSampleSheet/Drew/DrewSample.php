<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\Drew;

class DrewSample
{
    public string $sampleName;

    public string $description;

    public function __construct(string $sampleName, string $description)
    {
        $this->sampleName = $sampleName;
        $this->description = $description;
    }

    public function toString(): string
    {
        return "{$this->sampleName},{$this->description}";
    }
}
