<?php declare(strict_types=1);

namespace MLL\Utils\Tests\LightcyclerSampleSheet;

use MLL\Utils\LightcyclerSampleSheet\RandomHexGenerator;
use PHPUnit\Framework\TestCase;

final class RandomHexGeneratorTest extends TestCase
{
    public function testGeneratesValidHexCode(): void
    {
        $generator = new RandomHexGenerator();
        $hexCode = $generator->uniqueHex6Digits();

        self::assertMatchesRegularExpression('/^[A-F0-9]{6}$/', $hexCode);
    }

    public function testGeneratesUniqueHexCodes(): void
    {
        $generator = new RandomHexGenerator();
        $hexCodes = [];

        for ($i = 0; $i < 1000; ++$i) {
            $hexCodes[] = $generator->uniqueHex6Digits();
        }

        self::assertCount(1000, array_unique($hexCodes));
    }
}
