<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

use MLL\Utils\Microplate\CoordinateSystem12x8;

/**
 * @template TContent
 *
 * @extends BaseRack<TContent>
 */
class DestPCR extends BaseRack
{
    public function __construct()
    {
        parent::__construct(new CoordinateSystem12x8());
    }

    public function type(): string
    {
        return '96 Well PCR ABI semi-skirted';
    }

    public function name(): string
    {
        return 'DestPCR';
    }
}
