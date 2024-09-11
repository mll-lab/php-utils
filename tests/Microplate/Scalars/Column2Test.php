<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Microplate\Scalars;

use GraphQL\Error\Error;
use GraphQL\Type\Definition\ScalarType;
use MLL\Utils\Microplate\Scalars\Column2;
use PHPUnit\Framework\TestCase;

final class Column2Test extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (! class_exists(ScalarType::class)) {
            self::markTestSkipped('Our webonyx/graphql-php version requires PHP 8');
        }
    }

    public function testSerializeThrowsIfColumn2x16WellIsNotAnInt(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Value not in range: "3".');

        (new Column2())->serialize('3');
    }

    public function testSerializeThrowsIfColumn2x16WellIsInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Value not in range: 3.');

        (new Column2())->serialize(3);
    }

    public function testSerializePassesWhenColumn2x16WellIsValid(): void
    {
        $serializedResult = (new Column2())->serialize(2);

        self::assertSame(2, $serializedResult);
    }

    public function testParseValueThrowsIfColumn2x16WellIsInvalid(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('Value not in range: 3.');

        (new Column2())->parseValue(3);
    }

    public function testParseValuePassesIfColumn2x16WellIsValid(): void
    {
        self::assertSame(
            2,
            (new Column2())->parseValue(2)
        );
    }
}
