<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

use MLL\Utils\Tecan\TecanException;

class InvalidPositionOnRack extends TecanException
{
    public function __construct(int $position, Rack $rack)
    {
        parent::__construct("The position {$position} is invalid on a {$rack->name()} rack.");
    }
}
