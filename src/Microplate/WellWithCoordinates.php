<?php declare(strict_types=1);

namespace MLL\Utils\Microplate;

/**
 * @template TWell
 * @template TCoordinateSystem of CoordinateSystem
 */
class WellWithCoordinates
{
    /**
     * @param TWell $content
     * @param Coordinates<TCoordinateSystem> $coordinates
     */
    public function __construct(
        public $content,
        public Coordinates $coordinates
    ) {}
}
