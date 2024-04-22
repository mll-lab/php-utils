<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet;

use MLL\Utils\IlluminaSampleSheet\ReadsSection;
use PHPUnit\Framework\TestCase;

class ReadsSectionTest extends TestCase
{
    public function testReadsSectionToStringReturnsCorrectFormat(): void
    {
        $readsSection = new ReadsSection(150, 50);

        self::assertSame("[Reads]\n150\n50", $readsSection->toString());
    }
}
