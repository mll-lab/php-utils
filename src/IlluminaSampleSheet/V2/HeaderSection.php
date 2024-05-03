<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2;

use MLL\Utils\IlluminaSampleSheet\SectionInterface;

class HeaderSection implements SectionInterface
{
    private const FILE_FORMAT_VERSION = '2';

    private string $fileFormatVersion = self::FILE_FORMAT_VERSION;

    private string $runName;

    private ?string $runDescription = null;

    private ?string $instrumentType = null;

    private ?string $instrumentPlatform = null;

    /** @var array<string, string> */
    private array $customParams = [];

    public function __construct(string $runName)
    {
        $this->runName = $runName;
    }

    public function setRunDescription(string $runDescription): HeaderSection
    {
        $this->runDescription = $runDescription;

        return $this;
    }

    public function setInstrumentType(string $instrumentType): HeaderSection
    {
        $this->instrumentType = $instrumentType;

        return $this;
    }

    public function setInstrumentPlatform(string $instrumentPlatform): HeaderSection
    {
        $this->instrumentPlatform = $instrumentPlatform;

        return $this;
    }

    public function setCustomParam(string $paramName, string $paramValue): void
    {
        $this->customParams['Custom_' . $paramName] = $paramValue;
    }

    public function convertSectionToString(): string
    {
        $headerLines = [
            '[Header]',
            "FileFormatVersion,{$this->fileFormatVersion}",
            "RunName,{$this->runName}",
        ];
        if (! is_null($this->runDescription)) {
            $headerLines[] = "RunDescription,{$this->runDescription}";
        }
        if (! is_null($this->instrumentType)) {
            $headerLines[] = "InstrumentType,{$this->instrumentType}";
        }
        if (! is_null($this->instrumentPlatform)) {
            $headerLines[] = "InstrumentPlatform,{$this->instrumentPlatform}";
        }
        foreach ($this->customParams as $paramName => $paramValue) {
            $headerLines[] = "{$paramName},{$paramValue}";
        }

        return implode("\n", $headerLines) . "\n";
    }
}
