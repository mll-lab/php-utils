<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2;

use MLL\Utils\IlluminaSampleSheet\Section;

class CloudDataSection implements Section
{
    /** @var array<CloudDataSample> */
    private array $samples = [];

    public function addSample(
        string $sampleId,
        string $projectName,
        string $libraryName,
        string $libraryPrepKitName,
        string $indexAdapterKitName
    ): void {
        $this->samples[] = new CloudDataSample(
            $sampleId,
            $projectName,
            $libraryName,
            $libraryPrepKitName,
            $indexAdapterKitName
        );
    }

    public function convertSectionToString(): string
    {
        $dataLines = ["[Cloud_Data]\nSample_ID,ProjectName,LibraryName,LibraryPrepKitName,IndexAdapterKitName"];
        foreach ($this->samples as $sample) {
            $dataLines[] = implode(',', $sample->toArray());
        }

        return implode("\n", $dataLines) . "\n";
    }
}
