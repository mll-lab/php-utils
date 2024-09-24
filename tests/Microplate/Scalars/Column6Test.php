<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Microplate\Scalars;

use GraphQL\Error\Error;
use GraphQL\Type\Definition\ScalarType;
use MLL\Utils\Microplate\Scalars\Column6;
use PHPUnit\Framework\TestCase;

final class Column6Test extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (! class_exists(ScalarType::class)) {
            self::markTestSkipped('Our webonyx/graphql-php version requires PHP 8');
        }
    }

    public function testSerializeThrowsIfNotAnInt(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Value not in range 1-6: "2".');

        (new Column6())->serialize('2');
    }

    public function testSerializeThrowsIfInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Value not in range 1-6: 7.');

        (new Column6())->serialize(7);
    }

    public function testSerializePassesWhenValid(): void
    {
        self::assertSame(
            2,
            (new Column6())->serialize(2)
        );
    }

    public function testParseValueThrowsIfInvalid(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('Value not in range 1-6: 7.');

        (new Column6())->parseValue(7);
    }

    public function testParseValuePassesIfValid(): void
    {
        self::assertSame(
            5,
            (new Column6())->parseValue(5)
        );
    }
}
