<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

class MLLLabWareRack implements Rack
{
    public const A = 'A';
    public const MP_CDNA = 'MPCDNA';
    public const MP_SAMPLE = 'MPSample';
    public const MP_WATER = 'MPWasser';
    public const FLUID_X = 'FluidX';
    public const MM = 'MM';
    public const DEST_LC = 'DestLC';
    public const DEST_PCR = 'DestPCR';
    public const DEST_TAQMAN = 'DestTaqMan';

    public string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function A(): self
    {
        return new self(self::A);
    }

    public static function MP_CDNA(): self
    {
        return new self(self::MP_CDNA);
    }

    public static function MP_SAMPLE(): self
    {
        return new self(self::MP_SAMPLE);
    }

    public static function MP_WATER(): self
    {
        return new self(self::MP_WATER);
    }

    public static function FLUID_X(): self
    {
        return new self(self::FLUID_X);
    }

    public static function MM(): self
    {
        return new self(self::MM);
    }

    public static function DEST_LC(): self
    {
        return new self(self::DEST_LC);
    }

    public static function DEST_PCR(): self
    {
        return new self(self::DEST_PCR);
    }

    public static function DEST_TAQMAN(): self
    {
        return new self(self::DEST_TAQMAN);
    }

    public function id(): ?string
    {
        return null;
    }

    public function name(): string
    {
        return $this->value;
    }

    public function type(): string
    {
        switch ($this->value) {
            case self::A:
                return 'Eppis 24x0.5 ml Cooled';
            case self::MP_CDNA:
                return 'MP cDNA';
            case self::MP_SAMPLE:
                return 'MP Microplate';
            case self::MP_WATER:
                return 'Trough 300ml MCA Portrait';
            case self::FLUID_X:
                return '96FluidX';
            case self::MM:
                return 'Eppis 32x1.5 ml Cooled';
            case self::DEST_LC:
                return '96 Well MP LightCycler480';
            case self::DEST_PCR:
                return '96 Well PCR ABI semi-skirted';
            case self::DEST_TAQMAN:
                return '96 Well PCR TaqMan';
            default:
                throw new \Exception('Type not defined for ' . $this->value);
        }
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
