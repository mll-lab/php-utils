<?php declare(strict_types=1);

namespace MLL\Utils\LightcyclerSampleSheet;

use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem12x8;

class AbsoluteQuantificationSample
{
    public string $sampleName;

    public string $filterCombination;

    public string $hexColor;

    public string $sampleType;

    public ?int $concentration;

    /** @var Coordinates<CoordinateSystem12x8>|null */
    public ?Coordinates $replicationOf;

    /** @param Coordinates<CoordinateSystem12x8>|null $replicationOf */
    public function __construct(
        string $sampleName,
        string $filterCombination,
        string $hexColor,
        string $sampleType,
        ?int $concentration,
        ?Coordinates $replicationOf = null
    ) {
        $this->sampleName = $sampleName;
        $this->filterCombination = $filterCombination;
        $this->hexColor = $hexColor;
        $this->sampleType = $sampleType;
        $this->concentration = $concentration;
        $this->replicationOf = $replicationOf;
    }

    public static function formatConcentration(?int $concentration): string
    {
        if ($concentration === null) {
            return '';
        }

        $exponent = (int) floor(log10(abs($concentration)));
        $mantissa = $concentration / (10 ** $exponent);

        return number_format($mantissa, 2) . 'E' . $exponent;
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
            self::formatConcentration($this->concentration),
        ];
    }
}
