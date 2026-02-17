<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\Sections;

use MLL\Utils\IlluminaSampleSheet\V2\IlluminaSampleSheetVersion2;
use MLL\Utils\IlluminaSampleSheet\V2\IndexOrientation;
use MLL\Utils\IlluminaSampleSheet\V2\InstrumentPlatform;

abstract class HeaderSectionVersion2 extends SimpleKeyValueSection
{
    /** @return array<string, string> */
    public function headerFields(): array
    {
        return [
            'FileFormatVersion' => IlluminaSampleSheetVersion2::SAMPLE_SHEET_VERSION,
            'IndexOrientation' => IndexOrientation::FORWARD->value,
        ];
    }

    /** @return string[] */
    public function requiredFields(): array
    {
        return [
            'RunName',
            'InstrumentPlatform',
        ];
    }

    public function setIndexOrientation(IndexOrientation $indexOrientation): void
    {
        $this->headerFields['IndexOrientation'] = $indexOrientation->value;
    }

    public function setRunName(string $runName): void
    {
        $this->headerFields['RunName'] = $runName;
    }

    public function setInstrumentPlatform(InstrumentPlatform $instrumentPlatform): void
    {
        $this->headerFields['InstrumentPlatform'] = $instrumentPlatform->value;
    }

    public function sectionName(): string
    {
        return 'Header';
    }
}
