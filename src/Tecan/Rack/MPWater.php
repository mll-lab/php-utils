<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

use MLL\Utils\Microplate\CoordinateSystem1x1;

/**
 * @template TContent
 *
 * @extends BaseRack<TContent>
 */
class MPWater extends BaseRack
{
    public function __construct()
    {
        parent::__construct(new CoordinateSystem1x1());
    }
    public function type(): string
    {
        return 'Trough 300ml MCA Portrait';
    }

    public function name(): string
    {
        return 'MPWasser';
    }
}
