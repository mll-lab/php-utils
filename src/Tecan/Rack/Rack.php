<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

interface Rack
{
    /** Source labware barcode. */
    public function id(): ?string;

    /** User-defined label (name) which is assigned to the source labware. */
    public function name(): string;

    /** Source labware type (configuration name), e.g. “384 Well, landscape”. */
    public function type(): string;

    /** Serializes the rack parameters as part of a pipetting instruction according the gwl file format. */
    public function toString(): string;
}
