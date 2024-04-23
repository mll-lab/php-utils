<?php declare(strict_types=1);

namespace MLL\Utils\Tests\FluidXPlate\Scalars;

use GraphQL\Error\Error;
use GraphQL\Error\InvariantViolation;
use MLL\Utils\FluidXPlate\Scalars\FluidXBarcode;
use MLL\Utils\Tests\ScalarTestCase;

final class FluidXBarcodeTest extends ScalarTestCase
{
    public function testSerializeThrowsIfIsInvalid(): void
    {
        $this->expectExceptionObject(new InvariantViolation('The given value "foo123445" did not match the regex /[A-Z]{2}(\d){8}/.'));

        (new FluidXBarcode())->serialize('foo123445');
    }

    public function testSerializePassesWhenIsValid(): void
    {
        $input = 'AZ12345678';
        $serializedResult = (new FluidXBarcode())->serialize($input);

        self::assertSame($input, $serializedResult);
    }

    public function testParseValueThrowsIfIsInvalid(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('The given value "foo123445" did not match the regex /[A-Z]{2}(\d){8}/.');

        (new FluidXBarcode())->parseValue('foo123445');
    }

    public function testParseValuePassesIfIsValid(): void
    {
        $input = 'AZ12345678';
        self::assertSame(
            $input,
            (new FluidXBarcode())->parseValue($input)
        );
    }
}
