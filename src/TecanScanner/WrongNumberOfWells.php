<?php declare(strict_types=1);

namespace MLL\Utils\TecanScanner;

class WrongNumberOfWells extends TecanScanException
{
    public function __construct(int $expectedCount, int $actualCount)
    {
        parent::__construct("Scan content should contain {$expectedCount} barcode lines, but has {$actualCount} barcode lines");
    }
}
