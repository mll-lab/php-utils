<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2;

use MLL\Utils\IlluminaSampleSheet\SectionInterface;

class HeaderSection implements SectionInterface
{
    private string $runName;

    private string $fileFormatVersion = '2';

    private ?string $runDescription;

    private ?string $instrumentType;

    private ?string $instrumentPlatform;

    /** @var array<string, string> */
    private array $customParams = [];

    /**
     * @param string $runName - Required. Name of the run.
     * @param string|null $instrumentPlatform - Optional. Platform of the instrument.
     * @param string|null $runDescription - Optional. Description of the run.
     * @param string|null $instrumentType - Optional. Type of the instrument.
     */
    public function __construct(string $runName, ?string $instrumentPlatform = null, ?string $runDescription = null, ?string $instrumentType = null)
    {
        $this->runName = $runName;
        $this->runDescription = $runDescription;
        $this->instrumentType = $instrumentType;
        $this->instrumentPlatform = $instrumentPlatform;
    }

    /**
     * @param string $paramName - Name of the parameter
     * @param string $paramValue - Value of the parameter
     */
    public function addCustomParam(string $paramName, string $paramValue): void
    {
        $this->customParams[$paramName] = $paramValue;
    }

    public function convertSectionToString(): string
    {
        $headerLines = [
            '[Header]',
            "FileFormatVersion,{$this->fileFormatVersion}",
            "RunName,{$this->runName}",
        ];
        if ($this->runDescription !== null) {
            $headerLines[] = "RunDescription,{$this->runDescription}";
        }
        if ($this->instrumentType !== null) {
            $headerLines[] = "InstrumentType,{$this->instrumentType}";
        }
        if ($this->instrumentPlatform !== null) {
            $headerLines[] = "InstrumentPlatform,{$this->instrumentPlatform}";
        }
        foreach ($this->customParams as $paramName => $paramValue) {
            $headerLines[] = "{$paramName},{$paramValue}";
        }
        $headerLines[] = ''; // blank line at the end

        return implode("\n", $headerLines);
    }
}
