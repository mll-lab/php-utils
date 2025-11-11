<?php declare(strict_types=1);

namespace MLL\Utils\Tests;

use PHPUnit\Framework\TestCase;

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
}
