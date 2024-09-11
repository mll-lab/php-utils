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

    public function testSerializeThrowsIfRow16IsInvalid(): void
    {
        $this->expectException(InvariantViolation::class);
        $this->expectExceptionMessage('The given value "W" did not match the regex /^[A-P]$/.');

        (new Row16())->serialize('W');
    }

    public function testSerializeThrowsIfRow16IsNonCapital(): void
    {
        $this->expectException(InvariantViolation::class);
        $this->expectExceptionMessage('The given value "b" did not match the regex /^[A-P]$/.');

        (new Row16())->serialize('b');
    }

    public function testSerializePassesWhenRow16IsValid(): void
    {
        $serializedResult = (new Row16())->serialize('H');

        self::assertSame('H', $serializedResult);
    }

    public function testParseValueThrowsIfRow16IsInvalid(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('The given value "W" did not match the regex /^[A-P]$/.');

        (new Row16())->parseValue('W');
    }

    public function testParseValueThrowsIfRow16IsNonCapital(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('The given value "h" did not match the regex /^[A-P]$/.');

        (new Row16())->parseValue('h');
    }

    public function testParseValuePassesIfRow16IsValid(): void
    {
        self::assertSame(
            'P',
            (new Row16())->parseValue('P')
        );
    }
}
