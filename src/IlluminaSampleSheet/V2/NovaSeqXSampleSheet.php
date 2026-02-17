<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2;

use MLL\Utils\IlluminaSampleSheet\BaseSampleSheet;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvert\BclConvertSection;
use MLL\Utils\IlluminaSampleSheet\V2\Sections\HeaderSection;

class NovaSeqXSampleSheet extends BaseSampleSheet
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
