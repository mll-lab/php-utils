<?php declare(strict_types=1);

namespace MLL\Utils\TapeStation;

readonly class CompactRegionTableRecord
{
    public function __construct(
        public string $fileName,
        public string $wellID,
        public string $sampleDescription,
        public int $fromBp,
        public int $toBp,
        public int $averageSizeBp,
        public float $concentrationNgPerUl,
        public float $regionMolarityNmolPerL,
        public float $percentOfTotal,
        public string $regionComment,
    ) {}
}
