<?php declare(strict_types=1);

use Rector\CodeQuality\Rector\Concat\JoinStringConcatRector;
use Rector\Config\RectorConfig;
use Rector\PHPUnit\Rector\Class_\PreferPHPUnitSelfCallRector;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->sets([
        SetList::PHP_71,
        SetList::PHP_72,
        SetList::PHP_73,
        SetList::PHP_74,
        SetList::CODE_QUALITY,
    ]);
    $rectorConfig->skip([
        JoinStringConcatRector::class => [
            __DIR__ . '/tests/CSVArrayTest.php', // keep `\r\n` for readability
        ],
    ]);

    $rectorConfig->rule(PreferPHPUnitSelfCallRector::class);

    $rectorConfig->paths([__DIR__ . '/src', __DIR__ . '/tests']);
    $rectorConfig->phpstanConfig(__DIR__ . '/phpstan.neon');
};
