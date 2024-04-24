<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2;

use MLL\Utils\IlluminaSampleSheet\SampleSheet;

class NovaSeqXCloudSampleSheet extends SampleSheet
{
    public BclConvertSettingsSection $bclConvertSettingsSection;

    public function __construct(
        NovaSeqXCloudHeaderSection $header,
        NovaSeqXCloudReadsSection $reads,
        NovaSeqXCloudSequencingSettingsSection $sequencingSettingsSection,
        BclConvertSettingsSection $bclConvertSettingsSection,
        BclConvertDataSection $bclConvertDataSection,
        CloudSettingsSection $cloudSettings,
        CloudDataSection $cloudData
    ) {
        $this->addSection($header);
        $this->addSection($reads);
        $this->addSection($sequencingSettingsSection);
        $this->addSection($bclConvertSettingsSection);
        $this->addSection($bclConvertDataSection);
        $this->addSection($cloudSettings);
        $this->addSection($cloudData);
        $this->bclConvertSettingsSection = $bclConvertSettingsSection;
    }
}
