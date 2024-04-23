<?php declare(strict_types=1);

namespace MLL\Utils\Microplate;

use Illuminate\Support\Collection;

/**
 * @template TSectionWell
 */
abstract class AbstractSection
{
    /** @var SectionedMicroplate<TSectionWell, CoordinateSystem, static> */
    public SectionedMicroplate $sectionedMicroplate;

    /** @var Collection<int, TSectionWell|null> */
    public Collection $sectionItems;

    /** @param SectionedMicroplate<TSectionWell, CoordinateSystem, static> $sectionedMicroplate */
    public function __construct(SectionedMicroplate $sectionedMicroplate)
    {
        $this->sectionedMicroplate = $sectionedMicroplate;
        $this->sectionItems = new Collection();
    }

    /** @param TSectionWell $content */
    abstract public function addWell($content): void;
}
