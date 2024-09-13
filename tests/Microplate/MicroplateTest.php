<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Microplate;

use Illuminate\Support\Collection;
use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem12x8;
use MLL\Utils\Microplate\CoordinateSystem4x3;
use MLL\Utils\Microplate\Enums\FlowDirection;
use MLL\Utils\Microplate\Exceptions\MicroplateIsFullException;
use MLL\Utils\Microplate\Microplate;
use MLL\Utils\Microplate\WellWithCoordinates;
use PHPUnit\Framework\TestCase;

final class MicroplateTest extends TestCase
{
    public function testCanAddAndRetrieveWellBasedOnCoordinateSystem(): void
    {
        $coordinateSystem = new CoordinateSystem12x8();

        $microplate = new Microplate($coordinateSystem);

        $microplateCoordinate1 = new Coordinates('A', 2, $coordinateSystem);
        $microplateCoordinate2 = new Coordinates('A', 3, $coordinateSystem);

        $wellContent1 = 'foo';
        $microplate->addWell($microplateCoordinate1, $wellContent1);

        $wellContent2 = 'bar';
        $microplate->addWell($microplateCoordinate2, $wellContent2);

        self::assertEquals($wellContent1, $microplate->well($microplateCoordinate1));
        self::assertEquals($wellContent2, $microplate->well($microplateCoordinate2));

        $coordinateWithOtherCoordinateSystem = new Coordinates('B', 2, new CoordinateSystem4x3());
        // @phpstan-ignore-next-line expecting a type error due to mismatching coordinates
        $microplate->addWell($coordinateWithOtherCoordinateSystem, 'foo');
    }

    public function testMatchRow(): void
    {
        $coordinateSystem = new CoordinateSystem12x8();

        $microplate = new Microplate($coordinateSystem);

        $content = 'foo';
        $coordinates = new Coordinates('A', 1, $coordinateSystem);
        $key = $coordinates->toString();
        $microplate->addWell($coordinates, $content);

        $microplate->addWell(new Coordinates('B', 1, $coordinateSystem), 'bar');

        $wells = $microplate->wells();

        $a = $wells->filter($microplate->matchRow('A'));
        self::assertCount($coordinateSystem->columnsCount(), $a);
        self::assertSame($content, $a[$key]);

        $notA = $wells->reject($microplate->matchRow('A'));
        self::assertCount($coordinateSystem->positionsCount() - $coordinateSystem->columnsCount(), $notA);

        $noMatch = $microplate->filledWells()
            ->filter($microplate->matchRow('C'));
        self::assertCount(0, $noMatch);
    }

    public function testMatchColumn(): void
    {
        $coordinateSystem = new CoordinateSystem12x8();

        $microplate = new Microplate($coordinateSystem);

        $coordinateColumn1 = (new Coordinates('A', 1, $coordinateSystem))->toString();
        $coordinateColumn2 = (new Coordinates('A', 2, $coordinateSystem))->toString();

        $matchColumn = $microplate->matchColumn(1);
        self::assertTrue($matchColumn('foo', $coordinateColumn1));
        self::assertFalse($matchColumn('foo', $coordinateColumn2));
    }

    public function testtoWellWithCoordinatesMapper(): void
    {
        $coordinateSystem = new CoordinateSystem12x8();
        $microplate = new Microplate($coordinateSystem);

        $coordinates = new Coordinates('A', 1, $coordinateSystem);
        $content = 'foo';
        $microplate->addWell($coordinates, $content);

        $wellWithCoordinates = $microplate->wells()
            ->map($microplate->toWellWithCoordinatesMapper())
            ->first();

        self::assertInstanceOf(WellWithCoordinates::class, $wellWithCoordinates);
        self::assertSame($content, $wellWithCoordinates->content);
        self::assertEquals($coordinates, $wellWithCoordinates->coordinates);
    }

    public function testSortedWells(): void
    {
        $microplate = $this->preparePlate();

        /** @var Collection<int, string> $keysSortedByRow PHPStan is wrong about what keys() does */
        $keysSortedByRow = $microplate->sortedWells(FlowDirection::ROW())->keys();
        self::assertSame('A1', $keysSortedByRow[0]);
        self::assertSame('A2', $keysSortedByRow[1]);
        self::assertSame('A3', $keysSortedByRow[2]);
        self::assertSame('A4', $keysSortedByRow[3]);
        self::assertSame('H11', $keysSortedByRow[94]);
        self::assertSame('H12', $keysSortedByRow[95]);

        /** @var Collection<int, string> $keysSortedByColumn PHPStan is wrong about what keys() does */
        $keysSortedByColumn = $microplate->sortedWells(FlowDirection::COLUMN())->keys();
        self::assertSame('A1', $keysSortedByColumn[0]);
        self::assertSame('B1', $keysSortedByColumn[1]);
        self::assertSame('C1', $keysSortedByColumn[2]);
        self::assertSame('D1', $keysSortedByColumn[3]);
        self::assertSame('G12', $keysSortedByColumn[94]);
        self::assertSame('H12', $keysSortedByColumn[95]);
    }

    public function testFreeWells(): void
    {
        $microplate = $this->preparePlate();

        self::assertGreaterThan(
            0,
            $microplate->wells()
                // @phpstan-ignore-next-line generic false-positive
                ->filter(static fn (?string $value): bool => $value !== null)
                ->count()
        );
        self::assertNotCount(0, $microplate->freeWells());
    }

    /** @phpstan-return Microplate<mixed, CoordinateSystem12x8> */
    private function preparePlate(): Microplate
    {
        $coordinateSystem = new CoordinateSystem12x8();

        $microplate = new Microplate($coordinateSystem);

        $data12x8 = CoordinatesTest::data12x8();
        \Safe\shuffle($data12x8);
        foreach ($data12x8 as $well) {
            $microplateCoordinates = Coordinates::fromArray($well, new CoordinateSystem12x8());

            $randomNumber = rand(1, 100);
            $randomNumberOrNull = $randomNumber > 50 ? $randomNumber : null;

            $microplate->addWell($microplateCoordinates, $randomNumberOrNull);
        }

        return $microplate;
    }

    public function testNextFreeWellAddingAndGetting(): void
    {
        $coordinateSystem = new CoordinateSystem12x8();
        $microplate = new Microplate($coordinateSystem);

        $wellData = [
            'A1' => 'foo',
            'B1' => 'bar',
            'A2' => 'foobar',
            'A3' => 'barfoo',
        ];

        $coordinatesString1 = array_keys($wellData)[0];
        $microplateCoordinate1 = Coordinates::fromString($coordinatesString1, $coordinateSystem);
        self::assertEquals($microplateCoordinate1, $microplate->nextFreeWellCoordinates(FlowDirection::COLUMN()));
        $microplate->addToNextFreeWell($wellData[$coordinatesString1], FlowDirection::COLUMN());

        $coordinatesString2 = array_keys($wellData)[1];
        $microplateCoordinate2 = Coordinates::fromString($coordinatesString2, $coordinateSystem);
        self::assertEquals($microplateCoordinate2, $microplate->nextFreeWellCoordinates(FlowDirection::COLUMN()));
        $microplate->addToNextFreeWell($wellData[$coordinatesString2], FlowDirection::COLUMN());

        $microplateCoordinate3 = Coordinates::fromString('C1', $coordinateSystem);
        self::assertEquals($microplateCoordinate3, $microplate->nextFreeWellCoordinates(FlowDirection::COLUMN()));

        $coordinatesString4 = array_keys($wellData)[2];
        $microplateCoordinate4 = Coordinates::fromString($coordinatesString4, $coordinateSystem);
        self::assertEquals($microplateCoordinate4, $microplate->addToNextFreeWell($wellData[$coordinatesString4], FlowDirection::ROW()));

        $coordinatesString5 = array_keys($wellData)[3];
        $microplateCoordinate5 = Coordinates::fromString($coordinatesString5, $coordinateSystem);
        self::assertEquals($microplateCoordinate5, $microplate->addToNextFreeWell($wellData[$coordinatesString5], FlowDirection::ROW()));

        self::assertSame($wellData, $microplate->filledWells()->toArray());
    }

    public function testThrowsPlateFullException(): void
    {
        $coordinateSystem = new CoordinateSystem4x3();
        $microplate = new Microplate($coordinateSystem);

        $dataProvider12Well = CoordinatesTest::data4x3();
        foreach ($dataProvider12Well as $wellData) {
            $microplateCoordinates = Coordinates::fromArray($wellData, $coordinateSystem);
            // check that it does not throw before the plate is full
            self::assertEquals($microplateCoordinates, $microplate->nextFreeWellCoordinates(FlowDirection::ROW()));
            $microplate->addWell($microplateCoordinates, rand(1, 100));
        }

        $this->expectException(MicroplateIsFullException::class);
        $microplate->nextFreeWellCoordinates(FlowDirection::ROW());
    }

    public function testIsConsecutiveForColumn(): void
    {
        $coordinateSystem = new CoordinateSystem12x8();
        $microplate = new Microplate($coordinateSystem);

        $data = [
            'A1', 'B1', 'C1',
        ];
        foreach ($data as $wellData) {
            $microplateCoordinates = Coordinates::fromString($wellData, $coordinateSystem);
            $microplate->addWell($microplateCoordinates, 'test');
        }

        self::assertTrue($microplate->isConsecutive(FlowDirection::COLUMN()));
        self::assertFalse($microplate->isConsecutive(FlowDirection::ROW()));

        // is not consecutive anymore after adding a gap at E1
        $microplate->addWell(Coordinates::fromString('E1', $coordinateSystem), 'test');
        self::assertFalse($microplate->isConsecutive(FlowDirection::COLUMN()));
    }

    public function testIsConsecutiveForRow(): void
    {
        $coordinateSystem = new CoordinateSystem12x8();
        $microplate = new Microplate($coordinateSystem);

        $data = [
            'A1', 'A2', 'A3',
        ];
        foreach ($data as $wellData) {
            $microplateCoordinates = Coordinates::fromString($wellData, $coordinateSystem);
            $microplate->addWell($microplateCoordinates, 'test');
        }

        self::assertTrue($microplate->isConsecutive(FlowDirection::ROW()));
        self::assertFalse($microplate->isConsecutive(FlowDirection::COLUMN()));

        // is not consecutive anymore after adding a gap at A5
        $microplate->addWell(Coordinates::fromString('A5', $coordinateSystem), 'test');
        self::assertFalse($microplate->isConsecutive(FlowDirection::ROW()));
    }

    public function testIsConsecutiveForEmptyPlate(): void
    {
        $coordinateSystem = new CoordinateSystem12x8();
        $microplate = new Microplate($coordinateSystem);

        self::assertFalse($microplate->isConsecutive(FlowDirection::ROW()));
        self::assertFalse($microplate->isConsecutive(FlowDirection::COLUMN()));
    }

    public function testIsConsecutiveForFullPlate(): void
    {
        $coordinateSystem = new CoordinateSystem12x8();
        $microplate = new Microplate($coordinateSystem);

        foreach ($coordinateSystem->all() as $coordinates) {
            $microplate->addWell($coordinates, 'test');
        }

        self::assertTrue($microplate->isConsecutive(FlowDirection::ROW()));
        self::assertTrue($microplate->isConsecutive(FlowDirection::COLUMN()));
    }
}
