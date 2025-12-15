<?php declare(strict_types=1);

namespace MLL\Utils\QxManager;

use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem12x8;

class FilledWell
{
    public function __construct(
        private readonly FilledRow $famRow,
        private readonly FilledRow $hexRow
    ) {}

    /** @param Coordinates<CoordinateSystem12x8> $coordinates */
    public function toString(Coordinates $coordinates): string
    {
        return $coordinates->toPaddedString() . QxManagerSampleSheet::DELIMITER . $this->famRow->toString() . QxManagerSampleSheet::NEWLINE
            . $coordinates->toPaddedString() . QxManagerSampleSheet::DELIMITER . $this->hexRow->toString();
    }
}
