<?php declare(strict_types=1);

namespace MLL\Utils\Tests\LightcyclerExportSheet;

use MLL\Utils\LightcyclerExportSheet\LightcyclerSample;
use MLL\Utils\LightcyclerExportSheet\LightcyclerXmlParser;
use MLL\Utils\LightcyclerExportSheet\MissingRequiredPropertyException;
use PHPUnit\Framework\TestCase;

final class QpcrXmlParserTest extends TestCase
{
    public function testParseXmlHandlesMissingRequiredProperties(): void
    {
        $xmlWithMissingName = /* @lang XML */ <<<XML
            <?xml version="1.0" encoding="UTF-8"?>
            <root>
                <analyses>
                    <analysis>
                        <AnalysisSamples>
                            <AnalysisSample>
                                <prop name="Position">A1</prop>
                                <prop name="CalcConc">100.0</prop>
                                <prop name="CrossingPoint">25.0</prop>
                            </AnalysisSample>
                        </AnalysisSamples>
                    </analysis>
                </analyses>
            </root>
            XML;

        $this->expectExceptionObject(MissingRequiredPropertyException::forProperty('name'));

        $parser = new LightcyclerXmlParser();
        $parser->parse($xmlWithMissingName);
    }

    public function testParseXmlReturnsEmptyCollectionForInvalidXml(): void
    {
        $invalidXml = /* @lang XML */ '<invalid>xml</invalid>';

        $parser = new LightcyclerXmlParser();
        $result = $parser->parse($invalidXml);

        self::assertTrue($result->isEmpty());
    }

    public function testSampleTypeDetection(): void
    {
        $parser = new LightcyclerXmlParser();

        // Test Patient Sample
        $patientXml /* @lang XML */
            = <<<XML
            <?xml version="1.0" encoding="UTF-8"?>
            <root>
                <analyses>
                    <analysis>
                        <AnalysisSamples>
                            <AnalysisSample>
                                <prop name="name">XX-XXXXXX</prop>
                                <prop name="Position">A1</prop>
                                <prop name="CalcConc">100.0</prop>
                                <prop name="CrossingPoint">25.0</prop>
                            </AnalysisSample>
                        </AnalysisSamples>
                    </analysis>
                </analyses>
            </root>
            XML;

        $result = $parser->parse($patientXml);
        self::assertCount(1, $result);
        $sample = $result->first();
        self::assertInstanceOf(LightcyclerSample::class, $sample); // Test Standard Sample
        $standardConcentration = 400.0;
        $standardXml /* @lang XML */
            = <<<XML
            <?xml version="1.0" encoding="UTF-8"?>
            <root>
                <analyses>
                    <analysis>
                        <AnalysisSamples>
                            <AnalysisSample>
                                <prop name="name">STANDARD-400</prop>
                                <prop name="Position">B1</prop>
                                <prop name="CalcConc">{$standardConcentration}</prop>
                                <prop name="StandardConc">{$standardConcentration}</prop>
                                <prop name="CrossingPoint">20.0</prop>
                            </AnalysisSample>
                        </AnalysisSamples>
                    </analysis>
                </analyses>
            </root>
            XML;

        $result = $parser->parse($standardXml);
        self::assertCount(1, $result);
        $sample = $result->first();
        self::assertInstanceOf(LightcyclerSample::class, $sample);

        // Test Control Sample
        $controlXml /* @lang XML */
            = <<<XML
            <?xml version="1.0" encoding="UTF-8"?>
            <root>
                <analyses>
                    <analysis>
                        <AnalysisSamples>
                            <AnalysisSample>
                                <prop name="name">CONTROL</prop>
                                <prop name="Position">C1</prop>
                                <prop name="CalcConc">0.0</prop>
                                <prop name="CrossingPoint">35.0</prop>
                            </AnalysisSample>
                        </AnalysisSamples>
                    </analysis>
                </analyses>
            </root>
            XML;

        $result = $parser->parse($controlXml);
        self::assertCount(1, $result);
        $sample = $result->first();
        self::assertInstanceOf(LightcyclerSample::class, $sample);
    }

    public function testParseXmlValidatesConcentrationAndCrossingPointConsistency(): void
    {
        $parser = new LightcyclerXmlParser();

        // Test: CalcConc present but CrossingPoint missing
        $xmlWithCalcConcButNoCrossingPoint = /* @lang XML */ <<<XML
            <?xml version="1.0" encoding="UTF-8"?>
            <root>
                <analyses>
                    <analysis>
                        <AnalysisSamples>
                            <AnalysisSample>
                                <prop name="name">P123</prop>
                                <prop name="Position">A1</prop>
                                <prop name="CalcConc">100.0</prop>
                            </AnalysisSample>
                        </AnalysisSamples>
                    </analysis>
                </analyses>
            </root>
            XML;

        $this->expectExceptionObject(new \InvalidArgumentException('Concentration and crossing point must both be present or both be absent'));
        $parser->parse($xmlWithCalcConcButNoCrossingPoint);
    }

    public function testParseXmlHandlesEmptyAndMissingValues(): void
    {
        $parser = new LightcyclerXmlParser();

        // Test empty string values are treated as absent
        $xmlWithEmptyValues = /* @lang XML */ <<<XML
            <?xml version="1.0" encoding="UTF-8"?>
            <root>
                <analyses>
                    <analysis>
                        <AnalysisSamples>
                            <AnalysisSample>
                                <prop name="name">Control-Empty</prop>
                                <prop name="Position">B1</prop>
                                <prop name="CalcConc">  </prop>
                                <prop name="CrossingPoint">  </prop>
                            </AnalysisSample>
                        </AnalysisSamples>
                    </analysis>
                </analyses>
            </root>
            XML;

        $result = $parser->parse($xmlWithEmptyValues);
        self::assertCount(1, $result);
        self::assertEqualsWithDelta(0.0, $result->firstOrFail()->calculatedConcentration, PHP_FLOAT_EPSILON);
        self::assertEqualsWithDelta(0.0, $result->firstOrFail()->crossingPoint, PHP_FLOAT_EPSILON);

        // Test completely missing values
        $xmlWithBothMissing = /* @lang XML */ <<<XML
            <?xml version="1.0" encoding="UTF-8"?>
            <root>
                <analyses>
                    <analysis>
                        <AnalysisSamples>
                            <AnalysisSample>
                                <prop name="name">NTC-Control</prop>
                                <prop name="Position">H12</prop>
                            </AnalysisSample>
                        </AnalysisSamples>
                    </analysis>
                </analyses>
            </root>
            XML;

        $result = $parser->parse($xmlWithBothMissing);
        self::assertCount(1, $result);
        self::assertInstanceOf(LightcyclerSample::class, $result->first());
        self::assertEqualsWithDelta(0.0, $result->first()->calculatedConcentration, PHP_FLOAT_EPSILON);
        self::assertEqualsWithDelta(0.0, $result->first()->crossingPoint, PHP_FLOAT_EPSILON);
    }

    public function testParseXmlHandlesInvalidFloatValues(): void
    {
        $xmlWithInvalidFloat = /* @lang XML */ <<<XML
            <?xml version="1.0" encoding="UTF-8"?>
            <root>
                <analyses>
                    <analysis>
                        <AnalysisSamples>
                            <AnalysisSample>
                                <prop name="name">Test</prop>
                                <prop name="Position">A1</prop>
                                <prop name="CalcConc">invalid</prop>
                                <prop name="CrossingPoint">also-invalid</prop>
                            </AnalysisSample>
                        </AnalysisSamples>
                    </analysis>
                </analyses>
            </root>
            XML;

        $this->expectExceptionObject(new \InvalidArgumentException("Invalid float value: 'invalid'"));

        $parser = new LightcyclerXmlParser();
        $parser->parse($xmlWithInvalidFloat);
    }
}
