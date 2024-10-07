<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

use MLL\Utils\Microplate\CoordinateSystem2x16NoJ;

/**
 * @template TContent
 *
 * @extends BaseRack<TContent>
 */
class MasterMixRack extends BaseRack
{
    public function __construct()
    {
        parent::__construct(new CoordinateSystem2x16NoJ());
    }

    public function type(): string
    {
        return 'Eppis 32x1.5 ml Cooled';
    }

    public function name(): string
    {
        return 'MM';
    }
}
