<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2;

use MLL\Utils\IlluminaSampleSheet\SectionInterface;

class NovaSeqXCloudSequencingSettingsSection implements SectionInterface
{
    public string $libraryPrepKits;

    public function __construct(
        string $libraryPrepKits
    ) {
        $this->libraryPrepKits = $libraryPrepKits;
    }

    public function convertSectionToString(): string
    {
        $sequencingSettingsLines = [
            '[Sequencing_Settings]',
            "LibraryPrepKits,{$this->libraryPrepKits}",
            '',
        ];

        return implode("\n", $sequencingSettingsLines);
    }
}
