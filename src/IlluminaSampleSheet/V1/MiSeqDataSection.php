<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use MLL\Utils\IlluminaSampleSheet\SectionInterface;

class MiSeqDataSection implements SectionInterface
{
    /** @var array<MiSeqSample > */
    private array $samples = [];

    public function addSample(MiSeqSample $sample): void
    {
        $this->samples[] = $sample;
    }

    public function convertSectionToString(): string
    {
        $dataLines = ["[Data]\n{$this->dataSectionHeader()}"];

        foreach ($this->samples as $sample) {
            $dataLines[] = $sample->toString();
        }

        return implode("\n", $dataLines) . "\n";
    }

    public function dataSectionHeader(): string
    {
        return 'Sample_ID,Sample_Name,Sample_Plate,Sample_Well,Sample_Project,I7_Index_ID,Index,I5_Index_ID,Index2';
    }
}
