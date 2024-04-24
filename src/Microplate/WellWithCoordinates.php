<?php declare(strict_types=1);

namespace MLL\Utils\Microplate;

/**
 * @template TWell
 * @template TCoordinateSystem of CoordinateSystem
 */
class WellWithCoordinates
{
    /** @var TWell */
    public $content;

    /** @var Coordinates<TCoordinateSystem> */
    public Coordinates $coordinates;

    /**
     * @param TWell $content
     * @param Coordinates<TCoordinateSystem> $coordinates
     */
    public function __construct($content, Coordinates $coordinates)
    {
        $this->content = $content;
        $this->coordinates = $coordinates;
    }
}
