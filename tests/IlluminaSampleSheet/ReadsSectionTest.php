<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet;

use PHPUnit\Framework\TestCase;

class ReadsSectionTest extends TestCase
{
    public function testReadsSectionToStringReturnsCorrectFormat(): void
    {
        $readsSection = new \MLL\Utils\IlluminaSampleSheet\V1\ReadsSection(150, 50);

        self::assertSame("[Reads]\n150\n50", $readsSection->toString());
    }
}
