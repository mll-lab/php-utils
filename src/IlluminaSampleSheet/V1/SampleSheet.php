<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use MLL\Utils\IlluminaSampleSheet\BaseSampleSheet;

class SampleSheet extends BaseSampleSheet
{
    public function __construct(
        HeaderSection $header,
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
