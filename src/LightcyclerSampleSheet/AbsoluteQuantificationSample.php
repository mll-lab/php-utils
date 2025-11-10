<?php declare(strict_types=1);

namespace MLL\Utils\LightcyclerSampleSheet;

use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem12x8;
use MLL\Utils\SafeCast;

class AbsoluteQuantificationSample
{
    public string $sampleName;

    public string $filterCombination;

    public string $hexColor;

    public string $sampleType;

    /** Key used to determine replication grouping - samples with the same key will replicate to the first occurrence */
    public string $replicationOfKey;

    public ?int $concentration;

    public function __construct(
        string $sampleName,
        string $filterCombination,
        string $hexColor,
        string $sampleType,
        string $replicationOfKey,
        ?int $concentration
    ) {
        $this->sampleName = $sampleName;
        $this->filterCombination = $filterCombination;
        $this->hexColor = $hexColor;
        $this->sampleType = $sampleType;
        $this->replicationOfKey = $replicationOfKey;
        $this->concentration = $concentration;
    }

    public static function formatConcentration(?int $concentration): ?string
    {
        if ($concentration === null) {
            return null;
        }

        if ($concentration === 0) {
            return '0.00E0';
        }

        $exponent = SafeCast::toInt(floor(log10(abs($concentration))));
        $mantissa = $concentration / (10 ** $exponent);

        return number_format($mantissa, 2) . 'E' . $exponent;
    }

    /** @return array<string, string|null> */
    public function toSerializableArray(string $coordinatesString, string $replicationOfCoordinate): array
    {
        return [
            'General:Pos' => Coordinates::fromString($coordinatesString, new CoordinateSystem12x8())->toString(),
            'General:Sample Name' => $this->sampleName,
            'General:Repl. Of' => $replicationOfCoordinate,
            'General:Filt. Comb.' => $this->filterCombination,
            'Sample Preferences:Color' => RandomHexGenerator::LIGHTCYCLER_COLOR_PREFIX . $this->hexColor,
            'Abs Quant:Sample Type' => $this->sampleType,
            'Abs Quant:Concentration' => self::formatConcentration($this->concentration),
        ];
    }
}
