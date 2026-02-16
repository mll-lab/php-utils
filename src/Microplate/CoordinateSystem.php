<?php declare(strict_types=1);

namespace MLL\Utils\Microplate;

use Illuminate\Support\Arr;
use MLL\Utils\Microplate\Enums\FlowDirection;
use MLL\Utils\Microplate\Exceptions\UnexpectedFlowDirection;

/**
 * Children should be called `CoordinateSystemXxY`, where X is the number of columns and Y is the number of rows.
 * Naming them by the number of positions is insufficient, e.g. it does not allow distinguishing between 3x4 and 4x3.
 */
abstract class CoordinateSystem
{
    /** @return list<string> */
    abstract public function rows(): array;

    /** @return list<int> */
    abstract public function columns(): array;

    /**
     * List of columns, 0-padded to all have the same length.
     *
     * @return list<string>
     */
    public function paddedColumns(): array
    {
        $paddedColumns = [];
        foreach ($this->columns() as $column) {
            $paddedColumns[] = $this->padColumn($column);
        }

        return $paddedColumns;
    }

    /** 0-pad column to be as long as the longest column in the coordinate system. */
    public function padColumn(int $column): string
    {
        $maxColumnLength = strlen((string) $this->columnsCount());

        return str_pad((string) $column, $maxColumnLength, '0', STR_PAD_LEFT);
    }

    public function rowForRowFlowPosition(int $position): string
    {
        $index = (int) floor(($position - 1) / $this->columnsCount());

        return $this->rows()[$index];
    }

    public function rowForColumnFlowPosition(int $position): string
    {
        return $this->rows()[($position - 1) % $this->rowsCount()];
    }

    public function columnForRowFlowPosition(int $position): int
    {
        return $this->columns()[($position - 1) % $this->columnsCount()];
    }

    public function columnForColumnFlowPosition(int $position): int
    {
        $index = (int) floor(($position - 1) / $this->rowsCount());

        return $this->columns()[$index];
    }

    public function positionsCount(): int
    {
        return $this->columnsCount() * $this->rowsCount();
    }

    /**
     * Returns all possible coordinates of the system, ordered by column then row.
     *
     * e.g. A1, A2, B1, B2
     *
     * @return iterable<int, Coordinates<$this>>
     */
    public function all(): iterable
    {
        foreach ($this->columns() as $column) {
            foreach ($this->rows() as $row) {
                yield new Coordinates($row, $column, $this);
            }
        }
    }

    /**
     * Coordinates where no two positions share an edge to e.g. reduce contamination risk between two wells.
     *
     * @return list<Coordinates<$this>>
     */
    public function nonAdjacentPositions(FlowDirection $flowDirection): array
    {
        $rows = $this->rows();
        $columns = $this->columns();
        $positions = [];

        switch ($flowDirection->value) {
            case FlowDirection::COLUMN:
                foreach ($columns as $columnIndex => $column) {
                    foreach ($rows as $rowIndex => $row) {
                        if (($columnIndex + $rowIndex) % 2 === 0) {
                            $positions[] = new Coordinates($row, $column, $this);
                        }
                    }
                }
                break;
            case FlowDirection::ROW:
                foreach ($rows as $rowIndex => $row) {
                    foreach ($columns as $columnIndex => $column) {
                        if (($columnIndex + $rowIndex) % 2 === 0) {
                            $positions[] = new Coordinates($row, $column, $this);
                        }
                    }
                }
                break;
                // @codeCoverageIgnoreStart all FlowDirection values are listed and this should never happen
            default:
                throw new UnexpectedFlowDirection($flowDirection);
                // @codeCoverageIgnoreEnd
        }

        return $positions;
    }

    /**
     * Returns the coordinates of the first row and first column.
     *
     * @return Coordinates<$this>
     */
    public function first(): Coordinates
    {
        $firstRow = Arr::first($this->rows());
        if (! is_string($firstRow)) {
            throw new \Exception('First row must be string.');
        }

        $firstColumn = Arr::first($this->columns());
        if (! is_int($firstColumn)) {
            throw new \Exception('First column must be string.');
        }

        return new Coordinates($firstRow, $firstColumn, $this);
    }

    /**
     * Returns the coordinates of the last row and last column.
     *
     * @return Coordinates<$this>
     */
    public function last(): Coordinates
    {
        $lastRow = Arr::last($this->rows());
        if (! is_string($lastRow)) {
            throw new \Exception('Last row must be string.');
        }

        $lastColumn = Arr::last($this->columns());
        if (! is_int($lastColumn)) {
            throw new \Exception('Last column must be string.');
        }

        return new Coordinates($lastRow, $lastColumn, $this);
    }

    public function rowsCount(): int
    {
        return count($this->rows());
    }

    public function columnsCount(): int
    {
        return count($this->columns());
    }

    /** Determines if the given coordinate system has the same rows and columns. */
    public function equals(self $coordinateSystem): bool
    {
        return $coordinateSystem->rows() === $this->rows()
            && $coordinateSystem->columns() === $this->columns();
    }
}
