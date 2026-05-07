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

    public ?float $concentration;

    public function __construct(
        string $sampleName,
        string $filterCombination,
        string $hexColor,
        string $sampleType,
        string $replicationOfKey,
        ?float $concentration
    ) {
        $this->sampleName = $sampleName;
        $this->filterCombination = $filterCombination;
        $this->hexColor = $hexColor;
        $this->sampleType = $sampleType;
        $this->replicationOfKey = $replicationOfKey;
        $this->concentration = $concentration;
    }

    public static function formatConcentration(?float $concentration): ?string
    {
        if ($concentration === null) {
            return null;
        }

        if (! is_finite($concentration)) {
            throw new \InvalidArgumentException('Concentration must be finite, got: ' . var_export($concentration, true));
        }

        if ($concentration === 0.0) {
            return '0.00E0';
        }

        $exponent = SafeCast::toInt(floor(log10(abs($concentration))));
        $mantissa = $concentration / (10 ** $exponent);
        $mantissa = round($mantissa, 2);

        if (abs($mantissa) >= 10) {
            $mantissa /= 10;
            ++$exponent;
        }

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
