<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Microplate\Scalars;

use GraphQL\Error\Error;
use GraphQL\Error\InvariantViolation;
use GraphQL\Type\Definition\ScalarType;
use MLL\Utils\Microplate\Scalars\Row2x16Well;
use PHPUnit\Framework\TestCase;

final class Row2x16WellTest extends TestCase
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

        (new Row2x16Well())->serialize('W');
    }

    public function testSerializeThrowsIfRow2x16WellIsNonCapital(): void
    {
        $this->expectException(InvariantViolation::class);
        $this->expectExceptionMessage('The given value "b" did not match the regex /^[A-P]$/.');

        (new Row2x16Well())->serialize('b');
    }

    public function testSerializePassesWhenRow2x16WellIsValid(): void
    {
        $serializedResult = (new Row2x16Well())->serialize('H');

        self::assertSame('H', $serializedResult);
    }

    public function testParseValueThrowsIfRow2x16WellIsInvalid(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('The given value "W" did not match the regex /^[A-P]$/.');

        (new Row2x16Well())->parseValue('W');
    }

    public function testParseValueThrowsIfRow2x16WellIsNonCapital(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('The given value "h" did not match the regex /^[A-P]$/.');

        (new Row2x16Well())->parseValue('h');
    }

    public function testParseValuePassesIfRow2x16WellIsValid(): void
    {
        self::assertSame(
            'P',
            (new Row2x16Well())->parseValue('P')
        );
    }
}
