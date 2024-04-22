<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet;

class SettingsSection implements SectionInterface
{
    private ?string $adapter;

    private ?string $adapterRead2;

    public function __construct(?string $adapter = null, ?string $adapterRead2 = null)
    {
        $this->adapter = $adapter;
        $this->adapterRead2 = $adapterRead2;
    }

    public function toString(): string
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
