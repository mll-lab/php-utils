<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

class NoEmptyPositionOnRack extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('There is no empty position on the rack.');
    }
}
