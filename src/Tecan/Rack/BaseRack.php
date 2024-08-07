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

    /** @param mixed $content Anything goes, null is considered empty */
    public function assignFirstEmptyPosition($content): int
    {
        return $this->assignPosition($content, $this->findFirstEmptyPosition());
    }

    /** @param mixed $content Anything goes, null is considered empty */
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

    /** @param mixed $content Anything goes, null is considered empty */
    public function assignPosition($content, int $position): int
    {
        if (! $this->positions->has($position)) {
            throw new InvalidPositionOnRack($position, $this);
        }

        $this->positions[$position] = $content;

        return $position;
    }
}
