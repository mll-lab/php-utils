<?php declare(strict_types=1);

namespace MLL\Utils\LightcyclerSampleSheet;

use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem12x8;
use MLL\Utils\StringUtil;

class AbsoluteQuantificationSample
{
    public string $sampleName;

    public string $filterCombination;

    public string $hexColor;

    public string $sampleType;

    public string $concentration;

    /** @var Coordinates<CoordinateSystem12x8>|null */
    public ?Coordinates $replicationOf;

    /** @param Coordinates<CoordinateSystem12x8>|null $replicationOf */
    public function __construct(
        string $sampleName,
        string $filterCombination,
        string $hexColor,
        string $sampleType,
        string $concentration,
        ?Coordinates $replicationOf = null
    ) {
        $this->sampleName = $sampleName;
        $this->filterCombination = $filterCombination;
        $this->hexColor = $hexColor;
        $this->sampleType = $sampleType;
        $this->concentration = $concentration;
        $this->replicationOf = $replicationOf;
    }

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
            "\"{$this->sampleType}\"",
            "\"{$this->concentration}\"",
        ];
    }
}
