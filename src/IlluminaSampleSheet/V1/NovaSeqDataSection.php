<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use MLL\Utils\IlluminaSampleSheet\SectionInterface;

class NovaSeqDataSection implements SectionInterface
{
    /** @var array<NovaSeqXpSample> */
    private array $samples = [];

    public function addSample(NovaSeqXpSample $sample): void
    {
        $this->samples[] = $sample;
    }

    public function convertSectionToString(): string
    {
        $dataLines = ["[Data]\n{$this->dataSectionHeader()}"];
        $requiresLanesColumn = $this->requiresLanesColumn();

        foreach ($this->samples as $sample) {
            $dataLines[] = $requiresLanesColumn ? $sample->toStringWithoutLane() : $sample->toString();
        }

        return implode("\n", $dataLines) . "\n";
    }

    private function dataSectionHeader(): string
    {
        if ($this->requiresLanesColumn()) {
            return 'Sample_ID,Sample_Name,Sample_Plate,Sample_Well,I7_Index_ID,Index,I5_Index_ID,Index2,Sample_Project,Description';
        }

        return 'Lane,Sample_ID,Sample_Name,Sample_Plate,Sample_Well,I7_Index_ID,Index,I5_Index_ID,Index2,Sample_Project,Description';
    }

    private function requiresLanesColumn(): bool
    {
        return count(array_unique(array_map(fn (NovaSeqXpSample $sample) => $sample->lane, $this->samples))) === 1;
    }
}
