<?php declare(strict_types=1);

namespace MLL\Utils\QxManager;

/**
 * @see \MLL\Utils\Tests\QxManager\EmptyRowTest
 */
class EmptyRow
{
    public function toString(): string
    {
        return implode(QxManagerSampleSheet::DELIMITER, [
            'No',
            ...array_fill(0, 16, null),
        ]);
    }
}
