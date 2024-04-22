<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet;

class MiSeqSampleSheet extends SampleSheet
{
    public function __construct(
        MiSeqHeaderSection $header,
        ReadsSection $reads,
        DataSection $data
    ) {
        $this->addSection($header);
        $this->addSection($reads);
        $this->addSection(new SettingsSection());
        $this->addSection($data);
    }
}
