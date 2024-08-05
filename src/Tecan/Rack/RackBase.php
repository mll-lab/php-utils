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
    $firstEmptyPosition = $this->positions->search(self::EMPTY_POSITION);
    if ($firstEmptyPosition === false) {
        throw new NoEmptyPositionOnRack();
    }

    $this->positions[$firstEmptyPosition] = $name;

    return $firstEmptyPosition;
}

public function assignLastEmptyPosition(string $name): int
{
    $lastEmptyPosition = $this->positions->reverse()->search(self::EMPTY_POSITION);
    if ($lastEmptyPosition === false) {
        throw new NoEmptyPositionOnRack();
    }

    $this->positions[$lastEmptyPosition] = $name;

    return $lastEmptyPosition;
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
