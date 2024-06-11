<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use MLL\Utils\IlluminaSampleSheet\SampleSheet;

class NovaSeqSampleSheet extends SampleSheet
{
    public function setHeaderData(
        string $iemFileVersion,
         string $investigatorName,
         string $experimentName,
         string $date,
         string $workflow,
         string $application,
         string $assay,
         string $description,
         string $chemistry
    ): self {
        $headerSection = new NovaSeqHeaderSection(
            $iemFileVersion,
            $investigatorName,
            $experimentName,
            $date,
            $workflow,
            $application,
            $assay,
            $description,
            $chemistry
        );

        $this->addSection($headerSection);

        return $this;
    }

    public function setReadsData(
        int $read1,
        int $read2
    ): self {
        $readsSection = new ReadsSection($read1, $read2);

        $this->addSection($readsSection);

        return $this;
    }

    public function setSettingsData(
        string $adapter,
        string $adapterRead2
    ): self {
        $settingsSection = new SettingsSection($adapter, $adapterRead2);

        $this->addSection($settingsSection);

        return $this;
    }

    public function setData(array $columns, array $rows): self
    {
        $dataSection = new DataSection(new SampleSheetData($columns, $rows));

        $this->addSection($dataSection);

        return $this;
    }
}
