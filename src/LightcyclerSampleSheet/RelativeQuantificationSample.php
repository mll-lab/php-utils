<?php declare(strict_types=1);

namespace MLL\Utils\LightcyclerSampleSheet;

use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem12x8;

class RelativeQuantificationSample
{
    /** @param Coordinates<CoordinateSystem12x8>|null $replicationOf */
    public function __construct(
        public string $sampleName,
        public string $filterCombination,
        public string $hexColor,
        public ?Coordinates $replicationOf
    ) {}

    /** @return list<string> */
    public function toSerializableArray(string $coordinatesString): array
    {
        $replicationOf = $this->replicationOf instanceof Coordinates
            ? "\"{$this->replicationOf->toString()}\""
            : '""';

        return [
            Coordinates::fromString($coordinatesString, new CoordinateSystem12x8())->toString(),
            "\"{$this->sampleName}\"",
            $replicationOf,
            $this->filterCombination,
            RandomHexGenerator::LIGHTCYCLER_COLOR_PREFIX . $this->hexColor,
        ];
    }
}
