<?php declare(strict_types=1);

namespace MLL\Utils\Microplate;

use MLL\Utils\Microplate\Exceptions\MicroplateIsFullException;

/**
 * @template TSectionWell
 *
 * @extends AbstractSection<TSectionWell>
 */
class Section extends AbstractSection
{
    /**
     * @param TSectionWell $content
     *
     * @throws MicroplateIsFullException
     */
    public function addWell($content): void
    {
        // @phpstan-ignore-next-line Only recognized to be correct with larastan
        if ($this->sectionedMicroplate->freeWells()->isEmpty()) {
            throw new MicroplateIsFullException();
        }

        $this->sectionItems->push($content);
    }
}
