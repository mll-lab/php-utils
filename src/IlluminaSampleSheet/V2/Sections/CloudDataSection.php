<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\Sections;

use Illuminate\Support\Collection;
use MLL\Utils\IlluminaSampleSheet\Section;

final class CloudDataSection implements Section
{
    /** @param Collection<int, CloudDataItem> $cloudDataItems */
    public function __construct(
        private readonly Collection $cloudDataItems
    ) {}

    public function convertSectionToString(): string
    {
        return $this->cloudDataItems
            ->map(fn (CloudDataItem $cloudDataItem): string => $cloudDataItem->toString())
            ->join(PHP_EOL);
    }
}
