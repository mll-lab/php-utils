<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

use Illuminate\Support\Collection;

abstract class BaseRack implements Rack
{
    public const EMPTY_POSITION = null;

    /** @var Collection<int, mixed> */
    public Collection $positions;

    public function __construct()
    {
        $this->positions = Collection::times($this->positionCount(), fn () => self::EMPTY_POSITION)
            ->mapWithKeys(fn ($content, int $position): array => [$position + 1 => $content]);
    }

    public function id(): ?string
    {
        return null;
    }

    public function toString(): string
    {
        return implode(';', [
            $this->name(),
            $this->id(),
            $this->type(),
        ]);
    }

    public function assignFirstEmptyPosition(string $name): int
    {
        return $this->assignPosition($name, $this->findFirstEmptyPosition());
    }

    public function assignLastEmptyPosition(string $name): int
    {
        return $this->assignPosition($name, $this->findLastEmptyPosition());
    }

    public function findFirstEmptyPosition(): int
    {
        $firstEmpty = $this->positions
            ->filter(fn ($content): bool => $content === self::EMPTY_POSITION)
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
            ->filter(fn ($content): bool => $content === self::EMPTY_POSITION)
            ->keys()
            ->last();

        if ($lastEmpty === null) {
            throw new NoEmptyPositionOnRack();
        }

        return $lastEmpty;
    }

    public function assignPosition(string $name, int $position): int
    {
        if (! $this->positions->has($position)) {
            throw new InvalidPositionOnRack($position, $this);
        }

        $this->positions[$position] = $name;

        return $position;
    }
}
