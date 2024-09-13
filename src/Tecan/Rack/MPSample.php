<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

use MLL\Utils\Microplate\CoordinateSystem12x8;

/**
 * @template TContent
 *
 * @extends BaseRack<TContent>
 */
class MPSample extends BaseRack
{
    public function __construct()
    {
        parent::__construct(new CoordinateSystem12x8());
    }

    public function type(): string
    {
        return 'MP Microplate';
    }

    public function name(): string
    {
        return 'MPSample';
    }
}
