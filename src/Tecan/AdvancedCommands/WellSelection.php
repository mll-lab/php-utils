<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\AdvancedCommands;

class WellSelection
{
    public const MAX_ITEMS_PER_SUBARRAY = 7;

    private int $xWells;

    private int $yWells;

    /** @var array<int, array<int, int>> */
    private array $selFlag;

    /** @param array<int> $positions */
    public function __construct(int $xWells, int $yWells, array $positions)
    {
        $this->xWells = $xWells;
        $this->yWells = $yWells;
        $this->selFlag = WellSelection::transformPositionsToSelFlag($positions, $xWells, $yWells);
    }

    public function toString(): string
    {
        if ($this->xWells === 0 || $this->yWells === 0) {
            return '0000';
        }
        $selString = sprintf('%02X%02X', $this->xWells, $this->yWells);

        $bitCounter = 0;
        $bitMask = 0;

        $selFlag = $this->selFlag;

        for ($x = 0; $x < $this->xWells; ++$x) {
            for ($y = 0; $y < $this->yWells; ++$y) {
                if (isset($selFlag[$x][$y]) && ($selFlag[$x][$y] & 1) !== 0) {
                    $bitMask |= (1 << $bitCounter);
                }
                if (++$bitCounter > 6) {
                    $selString .= chr(ord('0') + $bitMask);
                    $bitCounter = 0;
                    $bitMask = 0;
                }
            }
        }

        if ($bitCounter > 0) {
            $selString .= chr(ord('0') + $bitMask);
        }

        return $selString;
    }

    /**
     * @param array<int> $positions
     *
     * @return array<int, array<int, int>>
     */
    public static function transformPositionsToSelFlag(array $positions, int $xWells, int $yWells): array
    {
        // Calculate the total number of wells
        $totalWells = $xWells * $yWells;

        // Calculate the number of sub-arrays needed, each with 7 elements
        $numSubArrays = (int) ceil($totalWells / self::MAX_ITEMS_PER_SUBARRAY);

        // Initialize the selFlag array with zeros
        $selFlag = array_fill(0, $numSubArrays, array_fill(0, self::MAX_ITEMS_PER_SUBARRAY, 0));

        // Iterate over the positions and set the corresponding selFlag positions to 1
        foreach ($positions as $position) {
            $index = $position - 1;
            $subArrayIndex = intdiv($index, self::MAX_ITEMS_PER_SUBARRAY);
            $bitIndex = $index % self::MAX_ITEMS_PER_SUBARRAY;
            if ($subArrayIndex < $numSubArrays) {
                $selFlag[$subArrayIndex][$bitIndex] = 1;
            }
        }

        return $selFlag;
    }
}
