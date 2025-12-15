<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use MLL\Utils\IlluminaSampleSheet\Section;

class SettingsSection implements Section
{
    public function __construct(
        private readonly ?string $adapter = null,
        private readonly ?string $adapterRead2 = null
    ) {}

    public function convertSectionToString(): string
    {
        $settingsLines = ['[Settings]'];

        if ($this->adapter !== null) {
            $settingsLines[] = 'Adapter,' . $this->adapter;
        }

        if ($this->adapterRead2 !== null) {
            $settingsLines[] = 'AdapterRead2,' . $this->adapterRead2;
        }

        return implode("\n", $settingsLines);
    }
}
