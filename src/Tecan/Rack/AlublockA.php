<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

use MLL\Utils\Microplate\CoordinateSystem6x4;

/**
 * @template TContent
 *
 * @extends BaseRack<TContent>
 */
class AlublockA extends BaseRack
{
    public function __construct()
    {
        parent::__construct(new CoordinateSystem6x4());
    }

    public function type(): string
    {
        return 'Eppis 24x0.5 ml Cooled';
    }

    public function name(): string
    {
        return 'A';
    }
}
