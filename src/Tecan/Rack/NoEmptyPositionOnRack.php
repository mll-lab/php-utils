<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

use MLL\Utils\Tecan\TecanException;

class NoEmptyPositionOnRack extends TecanException
{
    public function __construct()
    {
        parent::__construct('There is no empty position on the rack.');
    }
}
