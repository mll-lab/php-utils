<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Microplate\Scalars;

use GraphQL\Error\Error;
use GraphQL\Error\InvariantViolation;
use GraphQL\Type\Definition\ScalarType;
use MLL\Utils\Microplate\Scalars\Row16;
use PHPUnit\Framework\TestCase;

final class Row16Test extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (! class_exists(ScalarType::class)) {
            self::markTestSkipped('Our webonyx/graphql-php version requires PHP 8');
        }
    }

    public function testSerializeThrowsIfRow2x16WellIsInvalid(): void
    {
        $this->expectException(InvariantViolation::class);
        $this->expectExceptionMessage('The given value "W" did not match the regex /^[A-P]$/.');

        (new Row16())->serialize('W');
    }

    public function testSerializeThrowsIfRow2x16WellIsNonCapital(): void
    {
        $this->expectException(InvariantViolation::class);
        $this->expectExceptionMessage('The given value "b" did not match the regex /^[A-P]$/.');

        (new Row16())->serialize('b');
    }

    public function testSerializePassesWhenRow2x16WellIsValid(): void
    {
        $serializedResult = (new Row16())->serialize('H');

        self::assertSame('H', $serializedResult);
    }

    public function testParseValueThrowsIfRow2x16WellIsInvalid(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('The given value "W" did not match the regex /^[A-P]$/.');

        (new Row16())->parseValue('W');
    }

    public function testParseValueThrowsIfRow2x16WellIsNonCapital(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('The given value "h" did not match the regex /^[A-P]$/.');

        (new Row16())->parseValue('h');
    }

    public function testParseValuePassesIfRow2x16WellIsValid(): void
    {
        self::assertSame(
            'P',
            (new Row16())->parseValue('P')
        );
    }
}
