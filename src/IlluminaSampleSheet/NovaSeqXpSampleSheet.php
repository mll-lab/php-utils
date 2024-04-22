<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet;

class NovaSeqXpSampleSheet extends SampleSheet
{
    public function __construct(
        NovaSeqHeaderSection $header,
        ReadsSection $reads,
        SettingsSection $settings,
        DataSection $data
    ) {
        $this->addSection($header);
        $this->addSection($reads);
        $this->addSection($settings);
        $this->addSection($data);
    }
}
