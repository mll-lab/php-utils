<?php declare(strict_types=1);

namespace MLL\Utils\FluidXPlate;

use Illuminate\Support\Collection;
use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem96Well;
use MLL\Utils\Microplate\Enums\FlowDirection;
use MLL\Utils\Microplate\Microplate;

final class FluidXPlate
{
    public const FLUIDX_BARCODE_REGEX = /* @lang RegExp */ '/' . self::FLUIDX_BARCODE_REGEX_WITHOUT_DELIMITER . '/';
    public const FLUIDX_BARCODE_REGEX_WITHOUT_DELIMITER = '[A-Z]{2}(\d){8}';

    public string $rackId;

    /** @var Microplate<string, CoordinateSystem96Well> */
    private Microplate $microplate;

    public function __construct(string $rackId)
    {
        if (\Safe\preg_match(self::FLUIDX_BARCODE_REGEX, $rackId) === 0) {
            throw new InvalidRackIdException($rackId);
        }
        $this->rackId = $rackId;
        $this->microplate = new Microplate(self::coordinateSystem());
    }

    public static function coordinateSystem(): CoordinateSystem96Well
    {
        return new CoordinateSystem96Well();
    }

    /** @param Coordinates<CoordinateSystem96Well> $coordinates */
    public function addWell(Coordinates $coordinates, string $barcode): void
    {
        if (\Safe\preg_match(self::FLUIDX_BARCODE_REGEX, $barcode) === 0) {
            throw new InvalidTubeBarcodeException($barcode);
        }

        $this->microplate->addWell($coordinates, $barcode);
    }

    /** @return Coordinates<CoordinateSystem96Well> */
    public function addToNextFreeWell(string $content, FlowDirection $flowDirection): Coordinates
    {
        return $this->microplate->addToNextFreeWell($content, $flowDirection);
    }

    /** @return Collection<string, string|null> */
    public function wells(): Collection
    {
        return $this->microplate->wells();
    }

    /** @return Collection<string, null> */
    public function freeWells(): Collection
    {
        return $this->microplate->freeWells();
    }

    /** @return Collection<string, string> */
    public function filledWells(): Collection
    {
        return $this->microplate->filledWells();
    }
}
