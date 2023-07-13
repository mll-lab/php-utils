<?php declare(strict_types=1);

namespace MLL\Utils\QxManager;

class EmptyRow
{
    public function toString(): string
    {
        return implode(QxManagerSampleSheet::DELIMITER, [
            'No',
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
        ]);
    }
}
