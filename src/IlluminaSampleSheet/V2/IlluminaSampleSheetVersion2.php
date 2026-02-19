<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2;

use MLL\Utils\IlluminaSampleSheet\BaseSampleSheet;
use MLL\Utils\IlluminaSampleSheet\V2\Sections\BclConvertDataSection;
use MLL\Utils\IlluminaSampleSheet\V2\Sections\BclConvertSettingsSection;
use MLL\Utils\IlluminaSampleSheet\V2\Sections\CloudDataSection;
use MLL\Utils\IlluminaSampleSheet\V2\Sections\CloudSettingsSection;
use MLL\Utils\IlluminaSampleSheet\V2\Sections\HeaderSection;
use MLL\Utils\IlluminaSampleSheet\V2\Sections\ReadsSection;

/**
 * Illumina SampleSheet Documentation
 * https://help.connected.illumina.com/run-set-up/overview/sample-sheet-structure/bcl-convert-interactive-sample-sheet.
 */
final class IlluminaSampleSheetVersion2 extends BaseSampleSheet
{
    public function __construct(
        HeaderSection $headerSection,
        ReadsSection $readsSection,
        BclConvertSettingsSection $bclConvertSettingsSection,
        BclConvertDataSection $bclConvertDataSection,
        ?CloudSettingsSection $cloudSettingsSection,
        ?CloudDataSection $cloudDataSection
    ) {
        $this->addSection($headerSection);
        $this->addSection($readsSection);
        $this->addSection($bclConvertSettingsSection);
        $this->addSection($bclConvertDataSection);
        if ($cloudSettingsSection instanceof CloudSettingsSection) {
            $this->addSection($cloudSettingsSection);
        }
        if ($cloudDataSection instanceof CloudDataSection) {
            $this->addSection($cloudDataSection);
        }
    }
}
