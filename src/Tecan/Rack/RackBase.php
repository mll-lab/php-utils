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
        return $this->assignPosition($name, $this->findFirstEmptyPosition());
    }

    public function assignLastEmptyPosition(string $name): int
    {
        return $this->assignPosition($name, $this->findLastEmptyPosition());
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

    public function findFirstEmptyPosition(): int
    {
        $firstEmpty = $this->positions
            ->filter(fn ($position) => $position === self::EMPTY_POSITION)
            ->keys()
            ->first();

        if ($firstEmpty === null) {
            throw new NoEmptyPositionOnRack();
        }

        return $firstEmpty;
    }

    public function findLastEmptyPosition(): int
    {
        $lastEmpty = $this->positions
            ->filter(fn ($position) => $position === self::EMPTY_POSITION)
            ->keys()
            ->last();

        if ($lastEmpty === null) {
            throw new NoEmptyPositionOnRack();
        }

        return $lastEmpty;
    }

    public function assignPosition(string $name, int $position): int
    {
        if (! isset($this->positions[$position])) {
            throw new InvalidPositionOnRack($position, $this);
        }

        $this->positions[$position] = $name;

        return $position;
    }
}
