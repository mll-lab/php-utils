<?php declare(strict_types=1);

namespace MLL\Utils\Microplate;

use Illuminate\Support\Collection;
use MLL\Utils\Microplate\Enums\FlowDirection;
use MLL\Utils\Microplate\Exceptions\UnexpectedFlowDirection;

/**
 * @template TWell
 * @template TCoordinateSystem of CoordinateSystem
 *
 * @phpstan-type WellsCollection Collection<string, TWell|null>
 */
abstract class AbstractMicroplate
{
    public const EMPTY_WELL = null;

    /** @var TCoordinateSystem */
    public CoordinateSystem $coordinateSystem;

    /** @param TCoordinateSystem $coordinateSystem */
    public function __construct(CoordinateSystem $coordinateSystem)
    {
        $this->coordinateSystem = $coordinateSystem;
    }

    /** @return WellsCollection */
    abstract public function wells(): Collection;

    /**
     * @param Coordinates<TCoordinateSystem> $coordinate
     *
     * @return TWell|null
     */
    public function well(Coordinates $coordinate)
    {
        return $this->wells()[$coordinate->toString()];
    }

    /** @param Coordinates<TCoordinateSystem> $coordinate */
    public function isWellEmpty(Coordinates $coordinate): bool
    {
        return $this->well($coordinate) === self::EMPTY_WELL;
    }

    /** @return WellsCollection */
    public function sortedWells(FlowDirection $flowDirection): Collection
    {
        return $this->wells()->sortBy(
            /** @param TWell $content */
            function ($content, string $key) use ($flowDirection): string {
                switch ($flowDirection->value) {
                    case FlowDirection::ROW:
                        return $key;
                    case FlowDirection::COLUMN:
                        $coordinates = Coordinates::fromString($key, $this->coordinateSystem);

                        return $coordinates->column . $coordinates->row;
                        // @codeCoverageIgnoreStart all Enums are listed and this should never happen
                    default:
                        throw new UnexpectedFlowDirection($flowDirection);
                        // @codeCoverageIgnoreEnd
                }
            },
            SORT_NATURAL
        );
    }

    /** @return Collection<string, null> */
    public function freeWells(): Collection
    {
        return $this->wells()->filter(
            /** @param TWell $content */
            static fn ($content): bool => $content === self::EMPTY_WELL
        );
    }

    /** @return Collection<string, TWell> */
    public function filledWells(): Collection
    {
        return $this->wells()->filter(
            /** @param TWell $content */
            static fn ($content): bool => $content !== self::EMPTY_WELL
        );
    }

    /** @return callable(TWell|null $content, string $coordinatesString): bool */
    public function matchRow(string $row): callable
    {
        return function ($content, string $coordinatesString) use ($row): bool {
            $coordinates = Coordinates::fromString($coordinatesString, $this->coordinateSystem);

            return $coordinates->row === $row;
        };
    }

    /** @return callable(TWell|null $content, string $coordinatesString): bool */
    public function matchColumn(int $column): callable
    {
        return function ($content, string $coordinatesString) use ($column): bool {
            $coordinates = Coordinates::fromString($coordinatesString, $this->coordinateSystem);

            return $coordinates->column === $column;
        };
    }

    /**
     * @deprecated use toWellWithCoordinatesMapper
     *
     * @return callable(TWell $content, string $coordinatesString): WellWithCoordinates<TWell, TCoordinateSystem>
     */
    public function toWellWithCoordinateMapper(): callable
    {
        return $this->toWellWithCoordinatesMapper();
    }

    /** @return callable(TWell $content, string $coordinatesString): WellWithCoordinates<TWell, TCoordinateSystem> */
    public function toWellWithCoordinatesMapper(): callable
    {
        return fn ($content, string $coordinatesString): WellWithCoordinates => new WellWithCoordinates(
            $content,
            Coordinates::fromString($coordinatesString, $this->coordinateSystem)
        );
    }

    /**
     * Are all filled wells placed in a single connected block without gaps between them?
     *
     * Returns `false` if all wells are empty.
     */
    public function isConsecutive(FlowDirection $flowDirection): bool
    {
        $positions = $this->filledWells()
            ->map(
                /** @param TWell $content */
                fn ($content, string $coordinatesString): int => Coordinates::fromString($coordinatesString, $this->coordinateSystem)->position($flowDirection)
            );

        return ($positions->max() - $positions->min() + 1) === $positions->count();
    }
}
