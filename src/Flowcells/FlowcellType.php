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
        if (count(array_intersect($specificLanes, range(1, $this->totalLaneCount()))) !== count($specificLanes)) {
            throw new FlowcellLaneNotExistsException("Der FlowcellTyp: '{$this->name()}' besitzt keine Lane: " . implode(', ', array_diff($specificLanes, range(1, $this->totalLaneCount()))));
        }
    }
}
