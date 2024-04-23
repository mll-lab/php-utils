<?php declare(strict_types=1);

namespace MLL\Utils\Microplate;

use Illuminate\Support\Arr;
use MLL\Utils\Microplate\Enums\FlowDirection;
use MLL\Utils\Microplate\Exceptions\UnexpectedFlowDirection;

use function Safe\preg_match;

/** @template TCoordinateSystem of CoordinateSystem */
final class Coordinates
{
    public const MIN_POSITION = 1;

    public string $row;

    public int $column;

    /** @var TCoordinateSystem */
    public CoordinateSystem $coordinateSystem;

    /** @param TCoordinateSystem $coordinateSystem */
    public function __construct(string $row, int $column, CoordinateSystem $coordinateSystem)
    {
        $rows = $coordinateSystem->rows();
        if (! in_array($row, $rows, true)) {
            $rowList = \implode(',', $rows);
            throw new \InvalidArgumentException("Expected a row with value of {$rowList}, got {$row}.");
        }
        $this->row = $row;

        $columns = $coordinateSystem->columns();
        if (! in_array($column, $columns, true)) {
            $columnsList = \implode(',', $columns);
            throw new \InvalidArgumentException("Expected a column with value of {$columnsList}, got {$column}.");
        }
        $this->column = $column;

        $this->coordinateSystem = $coordinateSystem;
    }

    /**
     * @template TCoord of CoordinateSystem
     *
     * @param TCoord $coordinateSystem
     *
     * @return static<TCoord>
     */
    public static function fromString(string $coordinatesString, CoordinateSystem $coordinateSystem): self
    {
        $rows = $coordinateSystem->rows();
        $rowsOptions = \implode('|', $rows);

        $columns = [
            ...$coordinateSystem->columns(),
            ...$coordinateSystem->paddedColumns(),
        ];
        $columnsOptions = \implode('|', $columns);

        $valid = preg_match(
            "/^({$rowsOptions})({$columnsOptions})\$/",
            $coordinatesString,
            $matches
        );

        if ($valid === 0) {
            $firstValidExample = Arr::first($rows) . Arr::first($columns);
            $lastValidExample = Arr::last($rows) . Arr::last($columns);
            $coordinateSystemClass = \get_class($coordinateSystem);
            throw new \InvalidArgumentException("Expected coordinates between {$firstValidExample} and {$lastValidExample} for {$coordinateSystemClass}, got: {$coordinatesString}.");
        }

        return new self($matches[1], (int) $matches[2], $coordinateSystem);
    }

    public function toString(): string
    {
        return $this->row . $this->column;
    }

    /** Format the coordinates with the column 0-padded so all are the same length. */
    public function toPaddedString(): string
    {
        return $this->row . $this->coordinateSystem->padColumn($this->column);
    }

    /**
     * @param TCoordinateSystem $coordinateSystem
     *
     * @return static<TCoordinateSystem>
     */
    public static function fromPosition(int $position, FlowDirection $direction, CoordinateSystem $coordinateSystem): self
    {
        self::assertPositionInRange($coordinateSystem, $position);

        switch ($direction->value) {
            case FlowDirection::COLUMN:
                return new self(
                    $coordinateSystem->rowForColumnFlowPosition($position),
                    $coordinateSystem->columnForColumnFlowPosition($position),
                    $coordinateSystem
                );

            case FlowDirection::ROW:
                return new self(
                    $coordinateSystem->rowForRowFlowPosition($position),
                    $coordinateSystem->columnForRowFlowPosition($position),
                    $coordinateSystem
                );
                // @codeCoverageIgnoreStart all Enums are listed and this should never happen
            default:
                throw new UnexpectedFlowDirection($direction);
                // @codeCoverageIgnoreEnd
        }
    }

    public function position(FlowDirection $direction): int
    {
        /** @var int $rowIndex Must be found, since __construct enforces $this->row is valid */
        $rowIndex = array_search($this->row, $this->coordinateSystem->rows(), true);

        /** @var int $columnIndex Must be found, since __construct enforces $this->column is valid */
        $columnIndex = array_search($this->column, $this->coordinateSystem->columns(), true);

        switch ($direction->value) {
            case FlowDirection::ROW:
                return $rowIndex * \count($this->coordinateSystem->columns()) + $columnIndex + 1;
            case FlowDirection::COLUMN:
                return $columnIndex * \count($this->coordinateSystem->rows()) + $rowIndex + 1;
                // @codeCoverageIgnoreStart all Enums are listed and this should never happen
            default:
                throw new UnexpectedFlowDirection($direction);
                // @codeCoverageIgnoreEnd
        }
    }

    private static function assertPositionInRange(CoordinateSystem $coordinateSystem, int $position): void
    {
        if (! in_array($position, range(self::MIN_POSITION, $coordinateSystem->positionsCount()), true)) {
            throw new \InvalidArgumentException("Expected a position between 1-{$coordinateSystem->positionsCount()}, got: {$position}.");
        }
    }
}
