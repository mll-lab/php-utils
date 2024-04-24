<?php declare(strict_types=1);

namespace Tecan\Rack;

use MLL\Utils\Tecan\Rack\CustomRack;
use PHPUnit\Framework\TestCase;

final class CustomRackTest extends TestCase
{
    public function testCustomRack(): void
    {
        $name = 'name';
        $type = 'type';
        $barcode = 'barcode';

        $customRack = new CustomRack($name, $type, $barcode);

        self::assertSame($name, $customRack->name());
        self::assertSame($type, $customRack->type());
        self::assertSame($barcode, $customRack->id());

        self::assertSame('name;barcode;type', $customRack->toString());
    }
}
