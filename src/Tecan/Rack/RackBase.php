<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

use Illuminate\Support\Collection;

abstract class RackBase implements Rack
{
    /** @var Collection<int, mixed|null> */
    public Collection $positions;
    public const EMPTY_POSITION = null;

    public function __construct()
    {
        $this->positions = (new Collection(range(1, $this->positionCount())))
            ->mapWithKeys(fn (int $item) => [$item => self::EMPTY_POSITION]);
    }

    public function assignFirstEmptyPosition(string $name): int
    {
        $positionOfWildTypeMixStock = $this->positions->filter(fn ($position) => $position === null)->keys()->first();
        if ($positionOfWildTypeMixStock === null) {
            throw new NoEmptyPositionOnRack();
        }

        $this->positions[$positionOfWildTypeMixStock] = $name;

        return $positionOfWildTypeMixStock;
    }

    public function assignLastEmptyPosition(string $name): int
    {
        $positionOfWildTypeMixStock = $this->positions->filter(fn ($position) => $position === null)->keys()->last();
        if ($positionOfWildTypeMixStock === null) {
            throw new NoEmptyPositionOnRack();
        }

        $this->positions[$positionOfWildTypeMixStock] = $name;

        return $positionOfWildTypeMixStock;
    }

    public function id(): ?string
    {
        return null;
    }

    abstract public function positionCount(): int;

    public function toString(): string
    {
        return implode(
            ';',
            [
                $this->name(),
                $this->id(),
                $this->type(),
            ]
        );
    }
}
