<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet;

class CloudDataSample
{
    public string $sampleId;

    public string $projectName;

    public string $libraryName;

    public string $libraryPrepKitName;

    public string $indexAdapterKitName;

    public function __construct(
        string $sampleId,
        string $projectName,
        string $libraryName,
        string $libraryPrepKitName,
        string $indexAdapterKitName
    ) {
        $this->sampleId = $sampleId;
        $this->projectName = $projectName;
        $this->libraryName = $libraryName;
        $this->libraryPrepKitName = $libraryPrepKitName;
        $this->indexAdapterKitName = $indexAdapterKitName;
    }

    /** @return array<string> */
    public function toArray(): array
    {
        return [
            'Sample_ID' => $this->sampleId,
            'ProjectName' => $this->projectName,
            'LibraryName' => $this->libraryName,
            'LibraryPrepKitName' => $this->libraryPrepKitName,
            'IndexAdapterKitName' => $this->indexAdapterKitName,
        ];
    }
}
