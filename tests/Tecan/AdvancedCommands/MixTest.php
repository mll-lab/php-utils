<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Tecan\AdvancedCommands;

use MLL\Utils\Tecan\AdvancedCommands\Mix;
use MLL\Utils\Tecan\AdvancedCommands\Volumes;
use MLL\Utils\Tecan\AdvancedCommands\WellSelection;
use PHPUnit\Framework\TestCase;

class MixTest extends TestCase
{
    public function testMixCommandWithValidParameters(): void
    {
        $mix = new Mix(
            'Water',
            new Volumes([5.5, 5.5, 4.5, 4.5, 0, 0, 0, 0, 0, 0, 0, 0]),
            15,
            2,
            1,
            new WellSelection(12, 8, [1]),
            1,
        );

        $expected = 'Mix(15,"Water","5.5","5.5","4.5","4.5",0,0,0,0,0,0,0,0,15,2,1,"0C0810000000000000",1,0,0)';
        self::assertEquals($expected, $mix->toString());
    }

    public function testMixCommandWithNoVolumes(): void
    {
        $mix = new Mix(
            'Water',
            new Volumes([0, 0.0, 0.00000, 0, 0, 0, 0, 0, 0, 0, 0, 0]),
            15,
            2,
            1,
            new WellSelection(12, 8, [1]),
            1,
        );

        $expected = 'Mix(0,"Water",0,0,0,0,0,0,0,0,0,0,0,0,15,2,1,"0C0810000000000000",1,0,0)';
        self::assertEquals($expected, $mix->toString());
    }
}
