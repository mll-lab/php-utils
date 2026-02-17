<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\BclConvert;

use MLL\Utils\IlluminaSampleSheet\Section;
use MLL\Utils\IlluminaSampleSheet\V2\Sections\ReadsSection;

class BclConvertSection implements Section
{
    protected SettingsSection $settingsSection;

    protected DataSection $dataSection;

    public function __construct(SettingsSection $settingsSection, DataSection $dataSection)
    {
        $this->settingsSection = $settingsSection;
        $this->dataSection = $dataSection;
    }

    public function convertSectionToString(): string
    {
        $bclConvertLines = [
            $this->settingsSection->convertSectionToString(),
            $this->dataSection->convertSectionToString(),
        ];

        return implode("\n", $bclConvertLines);
    }

    public function makeReadsSection(): ReadsSection
    {
        return $this->dataSection->makeReadsSection();
    }
}
