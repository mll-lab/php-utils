<?php declare(strict_types=1);

namespace MLL\Utils\FluidXPlate\Scalars;

use MLL\GraphQLScalars\Regex;
use MLL\Utils\FluidXPlate\FluidXPlate;

class FluidXBarcode extends Regex
{
    public ?string $description = 'A valid barcode for FluidX-Tubes or FluidX-Plates represented as a string, e.g. `XR12345678`.';

    public static function regex(): string
    {
        return FluidXPlate::FLUIDX_BARCODE_REGEX;
    }
}
