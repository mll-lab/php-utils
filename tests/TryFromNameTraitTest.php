<?php declare(strict_types=1);

namespace MLL\Utils\Tests;

use PHPUnit\Framework\TestCase;

/**
 * @requires PHP >= 8.1
 */
final class TryFromNameTraitTest extends TestCase
{
    public function testReturnsMatchingCase(): void
    {
        $result = TestEnum::tryFromName('FOO');
        self::assertSame(TestEnum::FOO, $result);

        $result = TestEnum::tryFromName('BAR');
        self::assertSame(TestEnum::BAR, $result);
    }

    public function testReturnsNullForNonExistentCase(): void
    {
        $result = TestEnum::tryFromName('NON_EXISTENT');
        self::assertNull($result);
    }

    public function testIsCaseSensitive(): void
    {
        $result = TestEnum::tryFromName('foo');
        self::assertNull($result);
    }

    public function testWorksWithPureEnums(): void
    {
        $result = PureTestEnum::tryFromName('FIRST');
        self::assertSame(PureTestEnum::FIRST, $result);

        $result = PureTestEnum::tryFromName('SECOND');
        self::assertSame(PureTestEnum::SECOND, $result);

        $result = PureTestEnum::tryFromName('THIRD');
        self::assertSame(PureTestEnum::THIRD, $result);
    }

    public function testHandlesEdgeCases(): void
    {
        // Empty string returns null
        $result = TestEnum::tryFromName('');
        self::assertNull($result);

        // String with spaces returns null
        $result = TestEnum::tryFromName('FOO ');
        self::assertNull($result);

        $result = TestEnum::tryFromName(' FOO');
        self::assertNull($result);

        // Special characters return null
        $result = TestEnum::tryFromName('FOO!');
        self::assertNull($result);
    }
}
