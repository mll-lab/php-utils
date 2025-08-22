<?php declare(strict_types=1);

namespace MLL\Utils\FluidXPlate;

use Illuminate\Support\Collection;
use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem12x8;
use MLL\Utils\Microplate\Enums\FlowDirection;
use MLL\Utils\Microplate\Microplate;

class FluidXPlate
{
    public const FLUIDX_BARCODE_REGEX = /* @lang RegExp */ '/' . self::FLUIDX_BARCODE_REGEX_WITHOUT_DELIMITER . '/';
    public const FLUIDX_BARCODE_REGEX_WITHOUT_DELIMITER = '[A-Z]{2}(\d){8}';

    public string $rackID;

    /** @var Microplate<string, CoordinateSystem12x8> */
    private readonly Microplate $microplate;

    public function __construct(string $rackID)
    {
        if (\Safe\preg_match(self::FLUIDX_BARCODE_REGEX, $rackID) === 0) {
            throw new InvalidRackIDException($rackID);
        }
        $this->rackID = $rackID;
        $this->microplate = new Microplate(self::coordinateSystem()); // @phpstan-ignore assign.propertyType (generic not inferred)
    }

    public static function coordinateSystem(): CoordinateSystem12x8
    {
        return new CoordinateSystem12x8();
    }

    /** @param Coordinates<CoordinateSystem12x8> $coordinates */
    public function addWell(Coordinates $coordinates, string $barcode): void
    {
        if (\Safe\preg_match(self::FLUIDX_BARCODE_REGEX, $barcode) === 0) {
            throw new InvalidTubeBarcodeException($barcode);
        }

        $this->microplate->addWell($coordinates, $barcode);
    }

    /** @return Coordinates<CoordinateSystem12x8> */
    public function addToNextFreeWell(string $content, FlowDirection $flowDirection): Coordinates
    {
        return $this->microplate->addToNextFreeWell($content, $flowDirection);
    }

    /** @return Collection<string, string|null> */
    public function wells(): Collection
    {
        return $this->microplate->wells(); // @phpstan-ignore return.type (generic not inferred)
    }

    /** @return Collection<string, null> */
    public function freeWells(): Collection
    {
        return $this->microplate->freeWells();
    }

    /** @return Collection<string, string> */
    public function filledWells(): Collection
    {
        return $this->microplate->filledWells(); // @phpstan-ignore return.type (generic not inferred)
    }
}
