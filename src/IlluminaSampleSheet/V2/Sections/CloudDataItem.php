<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\Sections;

final class CloudDataItem
{
    public function __construct(
        public string $bioSampleName,
        public string $projectName,
        public string $libraryName,
    ) {}

    public function toString(): string
    {
        return implode(',', [
            $this->bioSampleName,
            $this->projectName,
            $this->libraryName,
        ]);
    }
}
