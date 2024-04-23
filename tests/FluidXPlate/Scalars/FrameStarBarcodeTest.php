<?php declare(strict_types=1);

namespace MLL\Utils\Tests\FluidXPlate\Scalars;

use GraphQL\Error\Error;
use GraphQL\Error\InvariantViolation;
use MLL\Utils\FluidXPlate\Scalars\FrameStarBarcode;
use PHPUnit\Framework\TestCase;

final class FrameStarBarcodeTest extends TestCase
{
    public function testSerializeThrowsIfIsInvalid(): void
    {
        $this->expectException(InvariantViolation::class);
        $this->expectExceptionMessage('The given value "foo" did not match the regex /[A-Z]{2}(\d){6}/.');

        (new FrameStarBarcode())->serialize('foo');
    }

    public function testSerializePassesWhenIsValid(): void
    {
        $input = 'AZ123456';
        $serializedResult = (new FrameStarBarcode())->serialize($input);

        self::assertSame($input, $serializedResult);
    }

    public function testParseValueThrowsIfIsInvalid(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('The given value "bar" did not match the regex /[A-Z]{2}(\d){6}/.');

        (new FrameStarBarcode())->parseValue('bar');
    }

    public function testParseValuePassesIfIsValid(): void
    {
        $input = 'AZ123456';
        self::assertSame(
            $input,
            (new FrameStarBarcode())->parseValue($input)
        );
    }
}
