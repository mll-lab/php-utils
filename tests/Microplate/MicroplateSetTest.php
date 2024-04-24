<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Microplate;

use MLL\Utils\Microplate\CoordinateSystem96Well;
use MLL\Utils\Microplate\MicroplateSet\MicroplateSetAB;
use MLL\Utils\Microplate\MicroplateSet\MicroplateSetABCD;
use MLL\Utils\Microplate\MicroplateSet\MicroplateSetABCDE;
use PHPUnit\Framework\TestCase;

final class MicroplateSetTest extends TestCase
{
    public function testPlateCount(): void
    {
        $anyCoordinateSystemWillDo = new CoordinateSystem96Well();

        self::assertSame(MicroplateSetAB::PLATE_COUNT, (new MicroplateSetAB($anyCoordinateSystemWillDo))->plateCount());
        self::assertSame(MicroplateSetABCD::PLATE_COUNT, (new MicroplateSetABCD($anyCoordinateSystemWillDo))->plateCount());
        self::assertSame(MicroplateSetABCDE::PLATE_COUNT, (new MicroplateSetABCDE($anyCoordinateSystemWillDo))->plateCount());
    }
}
