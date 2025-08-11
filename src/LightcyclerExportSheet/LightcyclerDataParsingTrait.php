<?php declare(strict_types=1);

namespace MLL\Utils\LightcyclerExportSheet;

use Illuminate\Support\Collection;

trait LightcyclerDataParsingTrait
{
    protected function parseFloatValue(?string $value): ?float
    {
        $cleanString = $this->cleanString($value);

        if ($cleanString === null) {
            return null;
        }

        if (! is_numeric($cleanString)) {
            throw new \InvalidArgumentException("Invalid float value: '{$cleanString}'");
        }

        return (float) $cleanString;
    }

    /** @return array{float, float} */
    protected function validateConcentrationAndCrossingPoint(?string $concentration, ?string $crossingPoint): array
    {
        $parsedConcentration = $this->parseFloatValue($concentration);
        $parsedCrossingPoint = $this->parseFloatValue($crossingPoint);

        if (($parsedConcentration === null) !== ($parsedCrossingPoint === null)) {
            throw new \InvalidArgumentException('Concentration and crossing point must both be present or both be absent');
        }

        return [
            $parsedConcentration ?? LightcyclerXmlParser::FLOAT_ZERO,
            $parsedCrossingPoint ?? LightcyclerXmlParser::FLOAT_ZERO,
        ];
    }

    protected function cleanString(?string $maybeString): ?string
    {
        if ($maybeString === null) {
            return null;
        }

        return trim($maybeString) /** @phpstan-ignore ternary.shortNotAllowed (we explicitly want the short ternary here) */
            ?: null;
    }

    /** @param  array<string, string>  $properties */
    protected function requiredProperty(array $properties, string $propertyName): string
    {
        $cleaned = $this->cleanString($properties[$propertyName] ?? null);
        if ($cleaned === null) {
            throw MissingRequiredPropertyException::forProperty($propertyName);
        }

        return $cleaned;
    }

    /** @param  array<string, string>  $properties */
    protected function optionalProperty(array $properties, string $propertyName): ?string
    {
        return $this->cleanString($properties[$propertyName] ?? null);
    }

    /**
     * @param Collection<array-key, LightcyclerSample> $samples
     *
     * @return Collection<array-key, LightcyclerSample>
     */
    protected function validateUniqueCoordinates(Collection $samples): Collection
    {
        $coordinateCount = [];

        foreach ($samples as $sample) {
            $coordinateString = $sample->coordinates->toString();
            $coordinateCount[$coordinateString] = ($coordinateCount[$coordinateString] ?? 0) + 1;
        }

        $duplicates = array_keys(array_filter($coordinateCount, fn (int $count): bool => $count > 1));

        if ($duplicates !== []) {
            throw DuplicateCoordinatesException::forCoordinates($duplicates);
        }

        return $samples;
    }
}
