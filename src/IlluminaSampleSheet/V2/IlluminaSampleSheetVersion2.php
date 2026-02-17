<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2;

use MLL\Utils\IlluminaSampleSheet\BaseSampleSheet;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvert\BclConvertSection;
use MLL\Utils\IlluminaSampleSheet\V2\Sections\BclConvertSettingsSection;
use MLL\Utils\IlluminaSampleSheet\V2\Sections\CloudDataSection;
use MLL\Utils\IlluminaSampleSheet\V2\Sections\CloudSettingsSection;
use MLL\Utils\IlluminaSampleSheet\V2\Sections\HeaderSectionVersion2;
use MLL\Utils\IlluminaSampleSheet\V2\Sections\ReadsSection;

final class IlluminaSampleSheetVersion2 extends BaseSampleSheet
{
    /** @var string */
    public const SAMPLE_SHEET_VERSION = '2';

    public function __construct(
        HeaderSectionVersion2 $headerSection,
        ReadsSection $readsSection,
        BclConvertSettingsSection $bclConvertSettingsSection,
        BclConvertSection $bclConvertSection,
        CloudSettingsSection $cloudSettingsSection,
        CloudDataSection $cloudDataSection,
    ) {
        $this->addSection($headerSection);
        $this->addSection($readsSection);
        $this->addSection($bclConvertSettingsSection);
        $this->addSection($bclConvertSection);
        $this->addSection($cloudSettingsSection);
        $this->addSection($cloudDataSection);
    }
}
