<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\Drew;

use MLL\Utils\IlluminaSampleSheet\BaseSampleSheet;

class DrewSampleSheet extends BaseSampleSheet
{
    public function __construct(DrewBclConvertDataSection $dataSection)
    {
        $this->addSection($dataSection);
    }
}
