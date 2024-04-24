<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2;

use MLL\Utils\IlluminaSampleSheet\SectionInterface;

class NovaSeqXCloudHeaderSection implements SectionInterface
{
    public string $fileFormatVersion;

    public string $runName;

    public string $instrumentPlatform;

    public string $indexOrientation;

    public function __construct(
        string $fileFormatVersion,
        string $runName,
        string $instrumentPlatform,
        string $indexOrientation
    ) {
        $this->fileFormatVersion = $fileFormatVersion;
        $this->runName = $runName;
        $this->instrumentPlatform = $instrumentPlatform;
        $this->indexOrientation = $indexOrientation;
    }

    public function toString(): string
    {
        $headerLines = [
            '[Header]',
            "FileFormatVersion,{$this->fileFormatVersion}",
            "RunName,{$this->runName}",
            "InstrumentPlatform,{$this->instrumentPlatform}",
            "IndexOrientation,{$this->indexOrientation}",
            '',
        ];

        return implode("\n", $headerLines);
    }
}
