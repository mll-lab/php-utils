<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2;

use MLL\Utils\IlluminaSampleSheet\SectionInterface;
use MLL\Utils\IlluminaSampleSheet\V2\Enums\FastQCompressionFormat;

class BclConvertSettingsSection implements SectionInterface
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
            $booleanToString = $this->trimUMI
                ? '1'
                : '0';

            $bclConvertSettingsLines[] = "TrimUMI,{$booleanToString}";
        }

        return implode("\n", $bclConvertSettingsLines) . "\n";
    }

    public function setTrimUMI(bool $trimUMI): BclConvertSettingsSection
    {
        $this->trimUMI = $trimUMI;

        return $this;
    }
}
