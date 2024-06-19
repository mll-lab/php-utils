<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2;

use MLL\Utils\IlluminaSampleSheet\Section;

class HeaderSection implements Section
{
    protected const FILE_FORMAT_VERSION = '2';
    public const INDEX_ORIENTATION_FORWARD = 'Forward';

    protected string $fileFormatVersion = self::FILE_FORMAT_VERSION;

    public string $runName;

    public ?string $runDescription = null;

    public ?string $instrumentType = null;

    public ?string $instrumentPlatform = null;

    /** @var array<string, string> */
    protected array $customParams = [];

    public function __construct(string $runName)
    {
        $this->runName = $runName;
    }

    public static function isForwardIndexOrientation(): bool
    {
        // Added this static method to explicitly display that this flag influences Index2 in OverrideCycles.
        return HeaderSection::indexOrientation() === HeaderSection::INDEX_ORIENTATION_FORWARD;
    }

    public function setCustomParam(string $paramName, string $paramValue): void
    {
        $this->customParams['Custom_' . $paramName] = $paramValue;
    }

    public function convertSectionToString(): string
    {
        $indexOrientation = self::indexOrientation();
        $headerLines = [
            '[Header]',
            "FileFormatVersion,{$this->fileFormatVersion}",
            "RunName,{$this->runName}",
            "IndexOrientation,{$indexOrientation}",
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

    public static function indexOrientation(): string
    {
        // Only support the default IndexOrientation (Forward) for now.
        return self::INDEX_ORIENTATION_FORWARD;
    }
}
