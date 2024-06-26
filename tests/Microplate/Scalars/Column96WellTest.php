<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Microplate\Scalars;

use GraphQL\Error\Error;
use GraphQL\Type\Definition\ScalarType;
use MLL\Utils\Microplate\Scalars\Column96Well;
use PHPUnit\Framework\TestCase;

final class Column96WellTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (! class_exists(ScalarType::class)) {
            self::markTestSkipped('Our webonyx/graphql-php version requires PHP 8');
        }
    }

    public function testSerializeThrowsIfColumn96WellIsNotAnInt(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Value not in range: "12".');

        (new Column96Well())->serialize('12');
    }

    public function testSerializeThrowsIfColumn96WellIsInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Value not in range: 13.');

        (new Column96Well())->serialize(13);
    }

    public function testSerializePassesWhenColumn96WellIsValid(): void
    {
        $serializedResult = (new Column96Well())->serialize(12);

        self::assertSame(12, $serializedResult);
    }

    public function testParseValueThrowsIfColumn96WellIsInvalid(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('Value not in range: 13.');

        (new Column96Well())->parseValue(13);
    }

    public function testParseValuePassesIfColumn96WellIsValid(): void
    {
        self::assertSame(
            12,
            (new Column96Well())->parseValue(12)
        );
    }
}
