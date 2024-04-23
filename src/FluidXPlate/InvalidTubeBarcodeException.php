<?php declare(strict_types=1);

namespace MLL\Utils\FluidXPlate;

final class InvalidTubeBarcodeException extends FluidXPlateException
{
    public function __construct(string $tubeBarcode)
    {
        parent::__construct("Invalid tube barcode: {$tubeBarcode}");
    }
}
