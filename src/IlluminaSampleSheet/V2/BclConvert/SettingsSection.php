<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\BclConvert;

use MLL\Utils\IlluminaSampleSheet\Section;
use MLL\Utils\IlluminaSampleSheet\V2\Enums\FastQCompressionFormat;

class SettingsSection implements Section
{
    public string $softwareVersion;

    public FastQCompressionFormat $fastqCompressionFormat;

    public ?bool $trimUMI = null;

    public function __construct(
        string $softwareVersion,
        FastQCompressionFormat $fastqCompressionFormat
    ) {
        $this->softwareVersion = $softwareVersion;
        $this->fastqCompressionFormat = $fastqCompressionFormat;
    }

    public function convertSectionToString(): string
    {
        $bclConvertSettingsLines = [
            '[BCLConvert_Settings]',
            "SoftwareVersion,{$this->softwareVersion}",
            "FastqCompressionFormat,{$this->fastqCompressionFormat->value}",
        ];

        if (! is_null($this->trimUMI)) {
            $trimUMIAsString = $this->trimUMI
                ? '1'
                : '0';

            $bclConvertSettingsLines[] = "TrimUMI,{$trimUMIAsString}";
        }

        return implode("\n", $bclConvertSettingsLines) . "\n";
    }

    public function setTrimUMI(bool $trimUMI): SettingsSection
    {
        $this->trimUMI = $trimUMI;

        return $this;
    }
}
