<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\BclConvert;

use MLL\Utils\IlluminaSampleSheet\Section;
use MLL\Utils\IlluminaSampleSheet\V2\ReadsSection;

class BclConvertSection implements Section
{
    public function __construct(
        protected SettingsSection $settingsSection,
        protected DataSection $dataSection
    ) {}

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
