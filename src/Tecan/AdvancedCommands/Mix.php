<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\AdvancedCommands;

use MLL\Utils\Tecan\BasicCommands\Command;
use MLL\Utils\Tecan\TecanException;

class Mix extends Command
{
    private string $liquidClass;

    private Volumes $volumes;

    private int $grid;

    private int $site;

    private int $spacing;

    private string $wellSelection;

    private int $cycles;

    private int $noOfLoopOptions = 0;

    private int $arm;

    public function __construct(
        string $liquidClass,
        Volumes $volumes,
        int $grid,
        int $site,
        int $spacing,
        WellSelection $wellSelection,
        int $cycles,
        int $arm = 0
    ) {
        $this->liquidClass = $liquidClass;
        $this->volumes = $volumes;
        $this->grid = $grid;
        $this->site = $site;
        $this->spacing = $spacing;
        $this->wellSelection = $wellSelection->toString();
        $this->cycles = $cycles;
        $this->arm = $arm;
    }

    public function toString(): string
    {
        if ($this->noOfLoopOptions !== 0) {
            throw new TecanException('Loop options are not yet supported');
        }

        $mixParameters = implode(',', [
            $this->volumes->tipMask(),
            Str::encloseWithDoubleQuotes($this->liquidClass),
            $this->volumes->volumeString(),
            $this->grid,
            $this->site,
            $this->spacing,
            Str::encloseWithDoubleQuotes($this->wellSelection),
            $this->cycles,
            $this->noOfLoopOptions,
            $this->arm,
        ]);

        return "Mix({$mixParameters})";
    }
}
