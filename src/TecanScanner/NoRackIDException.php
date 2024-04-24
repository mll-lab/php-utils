<?php declare(strict_types=1);

namespace MLL\Utils\TecanScanner;

class NoRackIDException extends TecanScanException
{
    public function __construct()
    {
        parent::__construct('No valid rack ID scanned');
    }
}
