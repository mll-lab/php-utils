<?php declare(strict_types=1);

namespace MLL\Utils\FluidXPlate;

final class InvalidRackIDException extends FluidXPlateException
{
    public function __construct(string $rackID)
    {
        parent::__construct("Invalid rack ID: {$rackID}");
    }
}
