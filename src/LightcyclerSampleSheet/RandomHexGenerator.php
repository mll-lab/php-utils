<?php declare(strict_types=1);

namespace MLL\Utils\LightcyclerSampleSheet;

class RandomHexGenerator
{
    public function hex6Digits(): string
    {
        $randomNumber = mt_rand(0, 0xFFFFFF);
        $hexString = dechex($randomNumber);
        $paddedHexString = str_pad($hexString, 6, '0', STR_PAD_LEFT);

        return strtoupper($paddedHexString);
    }
}
