<?php declare(strict_types=1);

namespace MLL\Utils\QxManager;

use Mll\Microplate\Coordinates;
use Mll\Microplate\CoordinateSystem96Well;

class FilledWell
{
    private FilledRow $famRow;

    private FilledRow $hexRow;

    public function __construct(FilledRow $famRow, FilledRow $hexRow)
    {
        $this->famRow = $famRow;
        $this->hexRow = $hexRow;
    }

    /** @param Coordinates<CoordinateSystem96Well> $coordinates */
    public function toString(Coordinates $coordinates): string
    {
        return $coordinates->toPaddedString() . QxManagerSampleSheet::DELIMITER . $this->famRow->toString() . QxManagerSampleSheet::EOL
            . $coordinates->toPaddedString() . QxManagerSampleSheet::DELIMITER . $this->hexRow->toString();
    }
}
