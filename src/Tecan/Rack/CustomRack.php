<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

class CustomRack implements Rack
{
    private string $name;

    private string $type;

    private ?string $barcode;

    public function __construct(string $name, string $type, ?string $barcode = null)
    {
        $this->type = $type;
        $this->name = $name;
        $this->barcode = $barcode;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function id(): ?string
    {
        return $this->barcode;
    }

    public function toString(): string
    {
        return implode(
            ';',
            [
                $this->name(),
                $this->id(),
                $this->type(),
            ]
        );
    }
}
