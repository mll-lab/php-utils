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
        yield ['Cannot cast value of type "boolean" to int', true];
        yield ['Cannot cast value of type "boolean" to int', false];
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
        yield ['Cannot cast value of type "boolean" to float', true];
        yield ['Cannot cast value of type "boolean" to float', false];
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
        $object = new class() implements \Stringable {
            public function __toString(): string
            {
                return 'object-string';
            }
        };

        self::assertSame('object-string', SafeCast::toString($object));
    }

    public function testTryStringWithObjectHavingToStringMethod(): void
    {
        $object = new class() implements \Stringable {
            public function __toString(): string
            {
                return 'object-string';
            }
        };

        self::assertSame('object-string', SafeCast::tryString($object));
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
        yield ['Cannot cast value of type "boolean" to string', true];
        yield ['Cannot cast value of type "boolean" to string', false];
    }

    /**
     * @dataProvider validIntProvider
     *
     * @param mixed $input can be anything
     */
    #[DataProvider('validIntProvider')]
    public function testTryIntWithValidInput(int $expected, $input): void
    {
        self::assertSame($expected, SafeCast::tryInt($input));
    }

    /**
     * @dataProvider invalidIntProvider
     *
     * @param mixed $input can be anything
     */
    #[DataProvider('invalidIntProvider')]
    public function testTryIntReturnsNullForInvalidInput(string $expectedMessage, $input): void
    {
        self::assertNull(SafeCast::tryInt($input));
    }

    /**
     * @dataProvider validFloatProvider
     *
     * @param mixed $input can be anything
     */
    #[DataProvider('validFloatProvider')]
    public function testTryFloatWithValidInput(float $expected, $input): void
    {
        self::assertSame($expected, SafeCast::tryFloat($input));
    }

    /**
     * @dataProvider invalidFloatProvider
     *
     * @param mixed $input can be anything
     */
    #[DataProvider('invalidFloatProvider')]
    public function testTryFloatReturnsNullForInvalidInput(string $expectedMessage, $input): void
    {
        self::assertNull(SafeCast::tryFloat($input));
    }

    /**
     * @dataProvider validStringProvider
     *
     * @param mixed $input can be anything
     */
    #[DataProvider('validStringProvider')]
    public function testTryStringWithValidInput(string $expected, $input): void
    {
        self::assertSame($expected, SafeCast::tryString($input));
    }

    /**
     * @dataProvider invalidStringProvider
     *
     * @param mixed $input can be anything
     */
    #[DataProvider('invalidStringProvider')]
    public function testTryStringReturnsNullForInvalidInput(string $expectedMessage, $input): void
    {
        self::assertNull(SafeCast::tryString($input));
    }

    /**
     * @dataProvider validBoolProvider
     *
     * @param mixed $input can be anything
     */
    #[DataProvider('validBoolProvider')]
    public function testTryBoolWithValidInput(bool $expected, $input): void
    {
        self::assertSame($expected, SafeCast::tryBool($input));
    }

    /**
     * @dataProvider invalidBoolProvider
     *
     * @param mixed $input can be anything
     */
    #[DataProvider('invalidBoolProvider')]
    public function testTryBoolReturnsNullForInvalidInput(string $expectedMessage, $input): void
    {
        self::assertNull(SafeCast::tryBool($input));
    }

    /**
     * @dataProvider validBoolProvider
     *
     * @param mixed $input can be anything
     */
    #[DataProvider('validBoolProvider')]
    public function testToBoolWithValidInput(bool $expected, $input): void
    {
        self::assertSame($expected, SafeCast::toBool($input));
    }

    /** @return iterable<array{bool, mixed}> */
    public static function validBoolProvider(): iterable
    {
        yield [true, true];
        yield [false, false];
        yield [true, 1];
        yield [false, 0];
        yield [true, '1'];
        yield [false, '0'];
    }

    /**
     * @dataProvider invalidBoolProvider
     *
     * @param mixed $input can be anything
     */
    #[DataProvider('invalidBoolProvider')]
    public function testToBoolThrowsExceptionForInvalidInput(string $expectedMessage, $input): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage($expectedMessage);
        SafeCast::toBool($input);
    }

    /** @return iterable<array{string, mixed}> */
    public static function invalidBoolProvider(): iterable
    {
        yield ['Cannot safely cast value of type "string" to bool', 'true'];
        yield ['Cannot safely cast value of type "string" to bool', 'false'];
        yield ['Cannot safely cast value of type "string" to bool', 'yes'];
        yield ['Cannot safely cast value of type "string" to bool', 'no'];
        yield ['Cannot safely cast value of type "string" to bool', ''];
        yield ['Cannot safely cast value of type "NULL" to bool', null];
        yield ['Cannot safely cast value of type "integer" to bool', 2];
        yield ['Cannot safely cast value of type "integer" to bool', -1];
        yield ['Cannot safely cast value of type "array" to bool', []];
        yield ['Cannot safely cast value of type "object" to bool', new \stdClass()];
        yield ['Cannot safely cast value of type "double" to bool', 1.0];
        yield ['Cannot safely cast value of type "double" to bool', 0.0];
    }
}
