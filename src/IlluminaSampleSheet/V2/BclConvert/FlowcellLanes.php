<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\BclConvert;

enum FlowcellLanes: int
{
    case NOVASEQ_X_1_5B = 2;

    /** @return array<int, int> */
    public function all(): array
    {
        return range(1, $this->value);
    }

    /**
     * @param array<int, int> $specificLanes
     *
     * @return array<int, int>
     */
    public function select(array $specificLanes): array
    {
        if (count(array_intersect($specificLanes, $this->all())) !== count($specificLanes)) {
            throw new FlowcellLaneNotExistsException("Der FlowcellTyp: '{$this->name}' besitzt keine Lane: " . implode(', ', array_diff($specificLanes, $this->all())));
        }

        return $specificLanes;
    }
}
