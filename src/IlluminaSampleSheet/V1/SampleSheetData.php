<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

class SampleSheetData implements DataInterface
{
    /** @var array<string> */
    private array $columns;

    /** @var array<array<string|int>> */
    private array $rows;

    /**
     * @param array<string> $columns
     * @param array<array<string|int>> $rows
     */
    public function __construct(array $columns, array $rows)
    {
        $this->columns = $columns;
        $this->rows = $rows;
    }

    /** {@inheritDoc} */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /** {@inheritDoc} */
    public function getRows(): array
    {
        return $this->rows;
    }
}
