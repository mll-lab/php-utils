<?php declare(strict_types=1);

namespace MLL\Utils\LightcyclerExportSheet;

use Illuminate\Support\Collection;
use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem12x8;
use MLL\Utils\SafeCast;

use function Safe\simplexml_load_string;

class LightcyclerXmlParser
{
    use LightcyclerDataParsingTrait;

    public const FLOAT_ZERO = 0.0;

    /** @return Collection<array-key, LightcyclerSample> */
    public function parse(string $xmlContent): Collection
    {
        $xml = simplexml_load_string($xmlContent);

        $analyses = $xml->analyses;
        if ($analyses === null || $analyses->analysis === null) {
            return new Collection();
        }

        return $this->extractAnalysisSamples($analyses);
    }

    private const QUANTIFICATION_SHORTNAME = 'Abs Quant/2nd Der';

    /** @return Collection<array-key, LightcyclerSample> */
    private function extractAnalysisSamples(\SimpleXMLElement $analyses): Collection
    {
        $samples = [];

        foreach ($analyses->analysis as $analysis) {
            if (! $this->isAbsoluteQuantificationAnalysis($analysis)) {
                continue;
            }

            if (property_exists($analysis, 'AnalysisSamples')
                && $analysis->AnalysisSamples !== null
            ) {
                foreach ($analysis->AnalysisSamples->AnalysisSample as $xmlSample) {
                    $samples[] = $this->createSampleFromXml($xmlSample);
                }
            }
        }

        return $this->validateUniqueCoordinates(new Collection($samples));
    }

    protected function isAbsoluteQuantificationAnalysis(\SimpleXMLElement $analysis): bool
    {
        foreach ($analysis->prop as $prop) {
            if ((string) $prop['name'] === 'shortname') {
                return (string) $prop === self::ANALYSIS_SHORTNAME;
            }
        }

        return false;
    }

    private function createSampleFromXml(\SimpleXMLElement $xmlSample): LightcyclerSample
    {
        $sampleProperties = $this->extractPropertiesFromXml($xmlSample);

        [$validatedConcentration, $validatedCrossingPoint] = $this->validateConcentrationAndCrossingPoint(
            $this->optionalProperty($sampleProperties, 'CalcConc'),
            $this->optionalProperty($sampleProperties, 'CrossingPoint'),
        );

        $coordinates = Coordinates::fromString(
            $this->requiredProperty($sampleProperties, 'Position'),
            new CoordinateSystem12x8(),
        );

        return new LightcyclerSample(
            $this->requiredProperty($sampleProperties, 'name'),
            $coordinates,
            $validatedConcentration,
            $validatedCrossingPoint,
            $this->parseFloatValue($this->optionalProperty(
                $sampleProperties,
                'StandardConc',
            )),
        );
    }

    /** @return array<string, string> */
    private function extractPropertiesFromXml(\SimpleXMLElement $xmlElement): array
    {
        $properties = [];

        foreach ($xmlElement->prop as $propertyNode) {
            $propertyName = SafeCast::toString($propertyNode->attributes()->name);
            $propertyValue = $propertyNode->__toString();

            if (! isset($properties[$propertyName])) {
                $properties[$propertyName] = $propertyValue;
            }
        }

        return $properties;
    }
}
