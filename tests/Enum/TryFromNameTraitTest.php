<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Enum;

use PHPUnit\Framework\TestCase;

final class TryFromNameTraitTest extends TestCase
{
    public function testReturnsMatchingCase(): void
    {
        $result = TestBackedEnum::tryFromName('FOO');
        self::assertSame(TestBackedEnum::FOO, $result);

        $result = TestBackedEnum::tryFromName('BAR');
        self::assertSame(TestBackedEnum::BAR, $result);
    }

    public function testReturnsNullForNonExistentCase(): void
    {
        $result = TestBackedEnum::tryFromName('NON_EXISTENT');
        self::assertNull($result);
    }

    public function testIsCaseSensitive(): void
    {
        $result = TestBackedEnum::tryFromName('foo');
        self::assertNull($result);
    }

    public function testWorksWithPureEnums(): void
    {
        $result = TestUnitEnum::tryFromName('FIRST');
        self::assertSame(TestUnitEnum::FIRST, $result);

        $result = TestUnitEnum::tryFromName('SECOND');
        self::assertSame(TestUnitEnum::SECOND, $result);

        $result = TestUnitEnum::tryFromName('THIRD');
        self::assertSame(TestUnitEnum::THIRD, $result);
    }

    public function testHandlesEdgeCases(): void
    {
        // Empty string returns null
        $result = TestBackedEnum::tryFromName('');
        self::assertNull($result);

        // String with spaces returns null
        $result = TestBackedEnum::tryFromName('FOO ');
        self::assertNull($result);

        $result = TestBackedEnum::tryFromName(' FOO');
        self::assertNull($result);

        // Special characters return null
        $result = TestBackedEnum::tryFromName('FOO!');
        self::assertNull($result);
    }
}
