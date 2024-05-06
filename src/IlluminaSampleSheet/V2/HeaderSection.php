<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2;

use MLL\Utils\IlluminaSampleSheet\Section;

class HeaderSection implements Section
{
    protected const FILE_FORMAT_VERSION = '2';

    protected string $fileFormatVersion = self::FILE_FORMAT_VERSION;

    protected string $runName;

    protected ?string $runDescription = null;

    protected ?string $instrumentType = null;

    protected ?string $instrumentPlatform = null;

    /** @var array<string, string> */
    protected array $customParams = [];

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
