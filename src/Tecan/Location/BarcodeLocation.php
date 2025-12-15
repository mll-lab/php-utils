<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Location;

use MLL\Utils\Tecan\Rack\ScannedRack;

class BarcodeLocation implements Location
{
    public function __construct(
        private readonly string $barcode,
        private readonly ScannedRack $rack
    ) {}

    public function tubeID(): string
    {
        return $this->barcode;
    }

    public function position(): ?string
    {
        return null;
    }

    public function rackName(): ?string
    {
        return null;
    }

    public function rackType(): string
    {
        return $this->rack->type();
    }

    public function rackID(): ?string
    {
        return null;
    }

    public function toString(): string
    {
        return implode(';', [
            $this->rackName(),
            $this->rackID(),
            $this->rackType(),
            $this->position(),
            $this->tubeID(),
        ]);
    }
}
