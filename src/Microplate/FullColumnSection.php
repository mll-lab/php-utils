<?php declare(strict_types=1);

namespace MLL\Utils\Microplate;

use MLL\Utils\Microplate\Exceptions\MicroplateIsFullException;
use MLL\Utils\Microplate\Exceptions\SectionIsFullException;

/**
 * A Section that occupies all wells of a column if one sample exists in this column. Samples of other sections are
 * not allowed in this occupied wells. Occupied wells can still be filled with samples of the same type.
 *
 * @template TSectionWell
 *
 * @extends AbstractSection<TSectionWell>
 */
final class FullColumnSection extends AbstractSection
{
    public function __construct(SectionedMicroplate $sectionedMicroplate)
    {
        parent::__construct($sectionedMicroplate);
        $this->growSection();
    }

    /**
     * @param TSectionWell $content
     *
     * @throws MicroplateIsFullException
     * @throws SectionIsFullException
     */
    public function addWell($content): void
    {
        if ($this->sectionedMicroplate->freeWells()->isEmpty()) {
            throw new MicroplateIsFullException();
        }

        $nextReservedWell = $this->nextReservedWell();
        if ($nextReservedWell !== false) {
            $this->sectionItems[$nextReservedWell] = $content;

            return;
        }

        $this->growSection();

        $nextReservedWell = $this->nextReservedWell();
        assert(is_int($nextReservedWell), 'Guaranteed to be found after we grew the section');

        $this->sectionItems[$nextReservedWell] = $content;
    }

    /**
     * Grows the section by initializing a new column with empty wells.
     *
     * @throws SectionIsFullException
     */
    private function growSection(): void
    {
        if (! $this->sectionCanGrow()) {
            throw new SectionIsFullException();
        }

        foreach ($this->sectionedMicroplate->coordinateSystem->rows() as $row) {
            $this->sectionItems->push(AbstractMicroplate::EMPTY_WELL);
        }
    }

    /** @return false|int */
    private function nextReservedWell()
    {
        $search = $this->sectionItems->search(AbstractMicroplate::EMPTY_WELL);
        assert($search === false || is_int($search));

        return $search;
    }

    private function sectionCanGrow(): bool
    {
        $totalReservedColumns = $this->sectionedMicroplate
            ->sections
            ->sum(static fn (self $section): int => $section->reservedColumns());

        $availableColumns = $this->sectionedMicroplate
            ->coordinateSystem
            ->columnsCount();

        return $totalReservedColumns < $availableColumns;
    }

    private function reservedColumns(): int
    {
        return (int) ceil($this->sectionItems->count() / $this->sectionedMicroplate->coordinateSystem->rowsCount());
    }
}
