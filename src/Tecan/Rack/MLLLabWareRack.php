<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

class MLLLabWareRack
{
    public static function A(): Rack
    {
        return new A();
    }

    public static function MP_CDNA(): Rack
    {
        return new MPCDNA();
    }

    public static function MP_SAMPLE(): Rack
    {
        return new MPSample();
    }

    public static function MP_WATER(): Rack
    {
        return new MPWater();
    }

    public static function FLUID_X(): Rack
    {
        return new FluidX();
    }

    public static function MM(): Rack
    {
        return new MM();
    }

    public static function DEST_LC(): Rack
    {
        return new DestLC();
    }

    public static function DEST_PCR(): Rack
    {
        return new DestPCR();
    }

    public static function DEST_TAQMAN(): Rack
    {
        return new DestTaqMan();
    }
}
