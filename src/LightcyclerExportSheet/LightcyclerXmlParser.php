<?php declare(strict_types=1);

namespace MLL\Utils\LightcyclerExportSheet;

use Illuminate\Support\Collection;
use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem12x8;

use function Safe\simplexml_load_string;

final class LightcyclerXmlParser
{
    use LightcyclerDataParsingTrait;

    private const XML_PROPERTY_NAME = 'name';
    private const XML_PROPERTY_POSITION = 'Position';
    private const XML_PROPERTY_CALC_CONC = 'CalcConc';
    private const XML_PROPERTY_STANDARD_CONC = 'StandardConc';
    private const XML_PROPERTY_CROSSING_POINT = 'CrossingPoint';
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

    /** @return Collection<array-key, LightcyclerSample> */
    private function extractAnalysisSamples(\SimpleXMLElement $analyses): Collection
    {
        $samples = [];

        foreach ($analyses->analysis as $analysis) {
            if (property_exists($analysis, 'AnalysisSamples') && $analysis->AnalysisSamples !== null) {
                foreach ($analysis->AnalysisSamples->AnalysisSample as $xmlSample) {
                    $samples[] = $this->createSampleFromXml($xmlSample);
                }
            }
        }

        return $this->validateUniqueCoordinates(new Collection($samples));
    }

    private function createSampleFromXml(\SimpleXMLElement $xmlSample): LightcyclerSample
    {
        $sampleProperties = $this->extractPropertiesFromXml($xmlSample);

        [$validatedConcentration, $validatedCrossingPoint] = $this->validateConcentrationAndCrossingPoint(
            $this->optionalProperty($sampleProperties, self::XML_PROPERTY_CALC_CONC),
            $this->optionalProperty($sampleProperties, self::XML_PROPERTY_CROSSING_POINT),
        );

        $coordinates = Coordinates::fromString(
            $this->requiredProperty($sampleProperties, self::XML_PROPERTY_POSITION),
            new CoordinateSystem12x8(),
        );

        return new LightcyclerSample(
            $this->requiredProperty($sampleProperties, self::XML_PROPERTY_NAME),
            $coordinates,
            $validatedConcentration,
            $validatedCrossingPoint,
            $this->parseFloatValue($this->optionalProperty(
                $sampleProperties,
                self::XML_PROPERTY_STANDARD_CONC,
            )),
        );
    }

    /** @return array<string, string> */
    private function extractPropertiesFromXml(\SimpleXMLElement $xmlElement): array
    {
        $properties = [];

        foreach ($xmlElement->prop as $propertyNode) {
            $propertyName = (string) $propertyNode->attributes()->name;
            $propertyValue = $propertyNode->__toString();

            if (! isset($properties[$propertyName])) {
                $properties[$propertyName] = $propertyValue;
            }
        }

        return $properties;
    }
}
