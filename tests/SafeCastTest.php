<?php declare(strict_types=1);

namespace MLL\Utils\Tests;

use MLL\Utils\SafeCast;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class SafeCastTest extends TestCase
{
    /**
     * @dataProvider validIntProvider
     *
     * @param mixed $input can be anything
     */
    #[DataProvider('validIntProvider')]
    public function testToIntWithValidInput(int $expected, $input): void
    {
        self::assertSame($expected, SafeCast::toInt($input));
    }

    /** @return iterable<array{int, mixed}> */
    public static function validIntProvider(): iterable
    {
        yield [42, 42];
        yield [-123, -123];
        yield [0, 0];
        yield [42, '42'];
        yield [-123, '-123'];
        yield [0, '0'];
        yield [999, '  999  '];
        yield [5, 5.0];
        yield [-10, -10.0];
        yield [0, 0.0];
        yield [42, '042'];
        yield [0, '000'];
        yield [42, '+42'];
    }

    /**
     * @dataProvider invalidIntProvider
     *
     * @param mixed $input can be anything
     */
    #[DataProvider('invalidIntProvider')]
    public function testToIntThrowsExceptionForInvalidInput(string $expectedMessage, $input): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage($expectedMessage);
        SafeCast::toInt($input);
    }

    /** @return iterable<array{string, mixed}> */
    public static function invalidIntProvider(): iterable
    {
        yield ['String value "hello" is not a valid integer format', 'hello'];
        yield ['String value "123abc" is not a valid integer format', '123abc'];
        yield ['String value "12.34" is not a valid integer format', '12.34'];
        yield ['Empty string cannot be cast to int', ''];
        yield ['Float value "5.5" cannot be safely cast to int', 5.5];
        yield ['cannot be safely cast to int (not a whole number or not finite)', INF];
        yield ['Cannot cast value of type "array" to int', []];
    }

    /**
     * @dataProvider validFloatProvider
     *
     * @param mixed $input can be anything
     */
    #[DataProvider('validFloatProvider')]
    public function testToFloatWithValidInput(float $expected, $input): void
    {
        self::assertSame($expected, SafeCast::toFloat($input));
    }

    /** @return iterable<array{float, mixed}> */
    public static function validFloatProvider(): iterable
    {
        yield [3.14, 3.14];
        yield [-2.5, -2.5];
        yield [0.0, 0.0];
        yield [42.0, 42];
        yield [-123.0, -123];
        yield [0.0, 0];
        yield [3.14, '3.14'];
        yield [-2.5, '-2.5'];
        yield [42.0, '42'];
        yield [1.23, '  1.23  '];
        yield [1.5e3, '1.5e3'];
        yield [2.5e-2, '2.5e-2'];
    }

    /**
     * @dataProvider invalidFloatProvider
     *
     * @param mixed $input can be anything
     */
    #[DataProvider('invalidFloatProvider')]
    public function testToFloatThrowsExceptionForInvalidInput(string $expectedMessage, $input): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage($expectedMessage);
        SafeCast::toFloat($input);
    }

    /** @return iterable<array{string, mixed}> */
    public static function invalidFloatProvider(): iterable
    {
        yield ['String value "hello" is not a valid numeric format', 'hello'];
        yield ['String value "3.14abc" is not a valid numeric format', '3.14abc'];
        yield ['String value "1.2.3" is not a valid numeric format', '1.2.3'];
        yield ['Empty string cannot be cast to float', ''];
        yield ['Cannot cast value of type "array" to float', []];
        yield ['is not a valid numeric format', '0x1A'];
        yield ['is not a valid numeric format', '0b1010'];
    }

    /**
     * @dataProvider validStringProvider
     *
     * @param mixed $input can be anything
     */
    #[DataProvider('validStringProvider')]
    public function testToStringWithValidInput(string $expected, $input): void
    {
        self::assertSame($expected, SafeCast::toString($input));
    }

    /** @return iterable<array{string, mixed}> */
    public static function validStringProvider(): iterable
    {
        yield ['hello', 'hello'];
        yield ['', ''];
        yield ['42', 42];
        yield ['-123', -123];
        yield ['0', 0];
        yield ['3.14', 3.14];
        yield ['-2.5', -2.5];
        yield ['', null];
    }

    public function testToStringWithObjectHavingToStringMethod(): void
    {
        $object = new class() {
            public function __toString(): string
            {
                return 'object-string';
            }
        };

        self::assertSame('object-string', SafeCast::toString($object));
    }

    /**
     * @dataProvider invalidStringProvider
     *
     * @param mixed $input can be anything
     */
    #[DataProvider('invalidStringProvider')]
    public function testToStringThrowsExceptionForInvalidInput(string $expectedMessage, $input): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage($expectedMessage);
        SafeCast::toString($input);
    }

    /** @return iterable<array{string, mixed}> */
    public static function invalidStringProvider(): iterable
    {
        yield ['Cannot cast value of type "object" to string', new \stdClass()];
        yield ['Cannot cast value of type "array" to string', []];
    }
}
