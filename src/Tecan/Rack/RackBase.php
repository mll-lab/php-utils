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
        $firstEmpty = $this->positions
            ->filter(fn ($position) => $position === self::EMPTY_POSITION)
            ->keys()
            ->first();

        return $this->assignPosition($firstEmpty, $name);
    }

    public function assignLastEmptyPosition(string $name): int
    {
        $lastEmpty = $this->positions
            ->filter(fn ($position) => $position === self::EMPTY_POSITION)
            ->keys()
            ->last();

        return $this->assignPosition($lastEmpty, $name);
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

    private function assignPosition(?int $position, string $name): int
    {
        if ($position === null) {
            throw new NoEmptyPositionOnRack();
        }

        $this->positions[$position] = $name;

        return $position;
    }
}
