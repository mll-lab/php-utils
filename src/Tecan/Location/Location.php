<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Location;

interface Location
{
    public function tubeId(): ?string;

    public function position(): ?string;

    public function rackName(): ?string;

    public function rackType(): string;

    public function rackId(): ?string;

    /** Serializes the location parameters as part of a pipetting instruction according the gwl file format. */
    public function toString(): string;
}
