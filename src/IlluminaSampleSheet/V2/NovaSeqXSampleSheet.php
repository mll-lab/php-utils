<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2;

use MLL\Utils\IlluminaSampleSheet\SampleSheet;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvert\BclConvertSection;

class NovaSeqXSampleSheet extends SampleSheet
{
    public function __construct(
        HeaderSection $header,
        ?BclConvertSection $bclConvertSection
    ) {
        $this->addSection($header);

        if (! is_null($bclConvertSection)) {
            $this->addSection($bclConvertSection->makeReadsSection());
            $this->addSection($bclConvertSection);
        }
    }
}
