<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\Sections;

final class CloudDataItem
{
    /** @var string */
    public $bioSampleName;

    /** @var string */
    public $projectName;

    /** @var string */
    public $libraryName;

    public function __construct(
        string $bioSampleName,
        string $projectName,
        string $libraryName
    ) {
        $this->bioSampleName = $bioSampleName;
        $this->projectName = $projectName;
        $this->libraryName = $libraryName;
    }

    public function toString(): string
    {
        return implode(',', [
            $this->bioSampleName,
            $this->projectName,
            $this->libraryName,
        ]);
    }
}
