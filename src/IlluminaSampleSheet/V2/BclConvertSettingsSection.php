<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2;

use MLL\Utils\IlluminaSampleSheet\SectionInterface;

class BclConvertSettingsSection implements SectionInterface
{
    public string $softwareVersion;

    public string $trimUMI;

    public string $fastqCompressionFormat;

    public function __construct(
        string $softwareVersion,
        string $trimUMI,
        string $fastqCompressionFormat
    ) {
        $this->softwareVersion = $softwareVersion;
        $this->trimUMI = $trimUMI;
        $this->fastqCompressionFormat = $fastqCompressionFormat;
    }

    public function convertSectionToString(): string
    {
        $bclConvertSettingsLines = [
            '[BCLConvert_Settings]',
            "SoftwareVersion,{$this->softwareVersion}",
            "TrimUMI,{$this->trimUMI}",
            "FastqCompressionFormat,{$this->fastqCompressionFormat}",
            '',
        ];

        return implode("\n", $bclConvertSettingsLines);
    }
}
