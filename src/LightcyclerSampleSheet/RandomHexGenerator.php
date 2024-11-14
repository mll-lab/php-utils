<?php declare(strict_types=1);

namespace MLL\Utils\LightcyclerSampleSheet;

class RandomHexGenerator
{
    public function hex6Digits(): string
    {
        return strtoupper(str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT));
    }
}
