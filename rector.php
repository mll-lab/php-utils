<?php declare(strict_types=1);

use Rector\CodeQuality\Rector\Concat\JoinStringConcatRector;
use Rector\Config\RectorConfig;
use Rector\PHPUnit\CodeQuality\Rector\Class_\PreferPHPUnitSelfCallRector;
use Rector\Set\ValueObject\SetList;

return RectorConfig::configure()
    ->withSets([
        SetList::CODE_QUALITY,
        SetList::TYPE_DECLARATION,
        SetList::RECTOR_PRESET,
    ])
    ->withPhpSets()
    ->withRules([PreferPHPUnitSelfCallRector::class])
    ->withSkip([
        JoinStringConcatRector::class => [
            __DIR__ . '/tests/CSVArrayTest.php', // keep `\r\n` for readability
        ],
    ])
    ->withPaths([__DIR__ . '/src', __DIR__ . '/tests'])
    ->withBootstrapFiles([
        // Rector uses PHPStan internally, which in turn requires Larastan to be set up correctly
        __DIR__ . '/vendor/larastan/larastan/bootstrap.php',
    ])
    ->withPHPStanConfigs([__DIR__ . '/phpstan.neon']);
