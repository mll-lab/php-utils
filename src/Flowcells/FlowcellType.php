<?php declare(strict_types=1);

namespace MLL\Utils\Flowcells;

abstract class FlowcellType
{
    abstract public function name(): string;

    abstract public function totalLaneCount(): int;

    /** @var array<int, int> */
    public array $lanes;

    /** @param array<int, int>|null $lanes */
    public function __construct(?array $lanes)
    {
        if ($lanes === null) {
            $lanes = range(1, $this->totalLaneCount());
        }
        $this->validate($lanes);
        $this->lanes = $lanes;
    }

    /** @param array<int, int> $specificLanes */
    public function validate(array $specificLanes): void
    {
        $validLanes = range(1, $this->totalLaneCount());
        $invalidLanes = array_diff($specificLanes, $validLanes);

        if (count($invalidLanes) > 0) {
            $invalidLanesAsString = count($invalidLanes) > 1 ? 'Lanes: ' : 'Lane: ' . implode(', ', $invalidLanes);
            throw new FlowcellLaneNotExistsException("Der Flowcell-Typ: '{$this->name()}' besitzt keine {$invalidLanesAsString}");
        }
    }
}
