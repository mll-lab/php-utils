<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use MLL\Utils\IlluminaSampleSheet\SampleSheet;

class MiSeqSampleSheet extends SampleSheet
{
    public function __construct(
        MiSeqHeaderSection $header,
        ReadsSection $reads,
        MiSeqDataSection $data
    ) {
        $this->addSection($header);
        $this->addSection($reads);
        $this->addSection(new SettingsSection());
        $this->addSection($data);
    }
}
