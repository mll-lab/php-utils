<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\AdvancedCommands;

class Volumes
{
    /** @var array{
     *     0:float|int,
     *     1:float|int,
     *     2:float|int,
     *     3:float|int,
     *     4:float|int,
     *     5:float|int,
     *     6:float|int,
     *     7:float|int,
     *     8:float|int,
     *     9:float|int,
     *     10:float|int,
     *     11:float|int,
     * } */
    private array $volumes;

    /** @param array{
     *     0:float|int,
     *     1:float|int,
     *     2:float|int,
     *     3:float|int,
     *     4:float|int,
     *     5:float|int,
     *     6:float|int,
     *     7:float|int,
     *     8:float|int,
     *     9:float|int,
     *     10:float|int,
     *     11:float|int,
     * } $volumes
     */
    public function __construct(array $volumes)
    {
        $this->volumes = $volumes;
    }

    public function volumeString(): string
    {
        $volumesArray = array_map(fn ($volume): string => $volume === 0.0 || $volume === 0
            ? (string) $volume
            : Str::encloseWithDoubleQuotes($volume), $this->volumes);

        return implode(',', $volumesArray);
    }

    /**
     * Generate tip bitmask from volumes.
     *
     * @return int Bitmask representing the tip mask
     */
    public function tipMask()
    {
        $bitmask = 0;
        foreach ($this->volumes as $index => $volume) {
            if ($volume > 0) {
                $bitmask |= (1 << $index);
            }
        }

        return $bitmask;
    }
}
