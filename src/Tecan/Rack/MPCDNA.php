<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

use MLL\Utils\Microplate\CoordinateSystem96Well;

/**
 * @template TContent
 *
 * @extends BaseRack<TContent>
 */
class MPCDNA extends BaseRack
{
    public function __construct()
    {
        parent::__construct(new CoordinateSystem96Well());
    }

    public function type(): string
    {
        return 'MP cDNA';
    }

    public function name(): string
    {
        return 'MPCDNA';
    }
}
