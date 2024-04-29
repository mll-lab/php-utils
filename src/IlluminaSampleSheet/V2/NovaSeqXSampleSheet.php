<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2;

use MLL\Utils\IlluminaSampleSheet\SampleSheet;

class NovaSeqXSampleSheet extends SampleSheet
{
    public function __construct(
        HeaderSection $header,
        ReadsSection $reads,
        BclConvertSettingsSection $bclConvertSettingsSection,
        BclConvertDataSection $bclConvertDataSection
    ) {
        $this->addSection($header);
        $this->addSection($reads);
        $this->addSection($bclConvertSettingsSection);
        $this->addSection($bclConvertDataSection);
    }
}
