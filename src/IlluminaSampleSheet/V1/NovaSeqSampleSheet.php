<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use MLL\Utils\IlluminaSampleSheet\SampleSheet;

class NovaSeqSampleSheet extends SampleSheet
{
    public function __construct(
        NovaSeqHeaderSection $header,
        ReadsSection $reads,
        SettingsSection $settings,
        NovaSeqDataSection $data
    ) {
        $this->addSection($header);
        $this->addSection($reads);
        $this->addSection($settings);
        $this->addSection($data);
    }
}
