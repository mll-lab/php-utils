<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Microplate\Scalars;

use GraphQL\Error\Error;
use GraphQL\Type\Definition\ScalarType;
use MLL\Utils\Microplate\Scalars\Column12;
use PHPUnit\Framework\TestCase;

final class Column12Test extends TestCase
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
        $this->expectExceptionMessage('Value not in range 1-12: "12".');

        (new Column12())->serialize('12');
    }

    public function testSerializeThrowsIfInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Value not in range 1-12: 13.');

        (new Column12())->serialize(13);
    }

    public function testSerializePassesValid(): void
    {
        $serializedResult = (new Column12())->serialize(12);

        self::assertSame(12, $serializedResult);
    }

    public function testParseValueThrowsIfInvalid(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('Value not in range 1-12: 13.');

        (new Column12())->parseValue(13);
    }

    public function testParseValuePassesIfValid(): void
    {
        self::assertSame(
            12,
            (new Column12())->parseValue(12)
        );
    }
}
