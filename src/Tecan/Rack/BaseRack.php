<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

use Illuminate\Support\Collection;
use MLL\Utils\Microplate\CoordinateSystem;

/** @template TContent */
abstract class BaseRack implements Rack
{
    public const EMPTY_POSITION = null;

    /** @var Collection<int, TContent|null> */
    public Collection $positions;

    public CoordinateSystem $coordinateSystem;

    public function __construct(CoordinateSystem $coordinateSystem)
    {
        $this->coordinateSystem = $coordinateSystem;
        /** @phpstan-ignore-next-line types are correct, but phpstan doesn't understand it */
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

    /** @param TContent|null $content Anything goes, null is considered empty */
    public function assignFirstEmptyPosition($content): int
    {
        return $this->assignPosition($content, $this->findFirstEmptyPosition());
    }

    /** @param TContent|null $content Anything goes, null is considered empty */
    public function assignLastEmptyPosition($content): int
    {
        return $this->assignPosition($content, $this->findLastEmptyPosition());
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

    /** @param TContent|null $content Anything goes, null is considered empty */
    public function assignPosition($content, int $position): int
    {
        if (! $this->positions->has($position)) {
            throw new InvalidPositionOnRack($position, $this);
        }

        $this->positions[$position] = $content;

        return $position;
    }

    public function positionCount(): int
    {
        return $this->coordinateSystem->positionsCount();
    }
}
