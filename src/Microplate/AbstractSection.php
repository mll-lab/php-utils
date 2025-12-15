<?php declare(strict_types=1);

namespace MLL\Utils\Microplate;

use Illuminate\Support\Collection;

/** @template TSectionWell */
abstract class AbstractSection
{
    /** @var Collection<int, TSectionWell|null> */
    public Collection $sectionItems;

    /** @param SectionedMicroplate<TSectionWell, CoordinateSystem, static> $sectionedMicroplate */
    public function __construct(
        public SectionedMicroplate $sectionedMicroplate
    ) {
        $this->sectionItems = new Collection();
    }

    /** @param TSectionWell $content */
    abstract public function addWell($content): void;
}
