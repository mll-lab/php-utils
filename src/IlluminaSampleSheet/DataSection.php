<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet;

abstract class DataSection implements SectionInterface
{
    /** @var array<Sample> */
    private array $samples = [];

    public function addSample(Sample $sample): void
    {
        $this->samples[] = $sample;
    }

    public function toString(): string
    {
        $dataLines = ["[Data]\n{$this->dataSectionHeader()}"];
        foreach ($this->samples as $sample) {
            $dataLines[] = $sample->toString();
        }

        return implode("\n", $dataLines) . "\n";
    }

    abstract public function dataSectionHeader(): string;
}
