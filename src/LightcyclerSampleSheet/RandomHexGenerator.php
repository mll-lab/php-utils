<?php declare(strict_types=1);

namespace MLL\Utils\LightcyclerSampleSheet;

class RandomHexGenerator
{
    /** @var list<string> */
    private array $generatedHexCodes = [];

    public function uniqueHex6Digits(): string
    {
        do {
            $randomNumber = mt_rand(0, 0xFFFFFF);
            $hexString = dechex($randomNumber);
            $paddedHexString = str_pad($hexString, 6, '0', STR_PAD_LEFT);
            $uniqueHexCode = strtoupper($paddedHexString);
        } while (in_array($uniqueHexCode, $this->generatedHexCodes, true));

        $this->generatedHexCodes[] = $uniqueHexCode;

        return $uniqueHexCode;
    }
}
