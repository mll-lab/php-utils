<?php declare(strict_types=1);

namespace MLL\Utils\QxManager;

use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem12x8;

class FilledWell
{
    private FilledRow $famRow;

    private FilledRow $hexRow;

    public function __construct(FilledRow $famRow, FilledRow $hexRow)
    {
        $this->famRow = $famRow;
        $this->hexRow = $hexRow;
    }

    /** @param Coordinates<CoordinateSystem12x8> $coordinates */
    public function toString(Coordinates $coordinates): string
    {
        return $coordinates->toPaddedString() . QxManagerSampleSheet::DELIMITER . $this->famRow->toString() . QxManagerSampleSheet::EOL
            . $coordinates->toPaddedString() . QxManagerSampleSheet::DELIMITER . $this->hexRow->toString();
    }
}
