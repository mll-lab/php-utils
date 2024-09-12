<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

use MLL\Utils\Microplate\CoordinateSystem96Well;

/**
 * @template TContent
 *
 * @extends BaseRack<TContent>
 */
class MPSample extends BaseRack
{
    public function __construct()
    {
        parent::__construct(new CoordinateSystem96Well());
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
