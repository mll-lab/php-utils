<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

/**
 * Interface for racks that have been scanned and the barcodes of its tubes are known.
 *
 * For example, @see FluidXRack
 */
interface ScannedRack extends Rack {}
