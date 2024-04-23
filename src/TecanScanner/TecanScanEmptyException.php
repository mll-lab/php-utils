<?php declare(strict_types=1);

namespace MLL\Utils\TecanScanner;

final class TecanScanEmptyException extends TecanScanException
{
    public function __construct()
    {
        parent::__construct('Empty scan content');
    }
}
