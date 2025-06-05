<?php declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\AssertCountWithZeroToAssertEmptyRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\SetList;

return RectorConfig::configure()
    ->withSets([
        SetList::CODE_QUALITY,
        SetList::TYPE_DECLARATION,
        SetList::RECTOR_PRESET,
        PHPUnitSetList::PHPUNIT_40,
        PHPUnitSetList::PHPUNIT_50,
        PHPUnitSetList::PHPUNIT_60,
        PHPUnitSetList::PHPUNIT_70,
        PHPUnitSetList::PHPUNIT_80,
        PHPUnitSetList::PHPUNIT_90,
        PHPUnitSetList::PHPUNIT_100,
        PHPUnitSetList::PHPUNIT_110,
        PHPUnitSetList::PHPUNIT_CODE_QUALITY,
    ])
    ->withPhpSets()
    ->withRules([
        Rector\PHPUnit\CodeQuality\Rector\Class_\PreferPHPUnitSelfCallRector::class,
    ])
    ->withSkip([
        Rector\PHPUnit\CodeQuality\Rector\MethodCall\AssertCountWithZeroToAssertEmptyRector::class, // sloppy
        Rector\PHPUnit\CodeQuality\Rector\Class_\PreferPHPUnitThisCallRector::class, // breaks tests
        Rector\CodeQuality\Rector\Concat\JoinStringConcatRector::class => [
            __DIR__ . '/tests/CSVArrayTest.php', // keep `\r\n` for readability
        ],
    ])
    ->withPaths([__DIR__ . '/src', __DIR__ . '/tests'])
    ->withBootstrapFiles([
        // Rector uses PHPStan internally, which in turn requires Larastan to be set up correctly
        __DIR__ . '/vendor/larastan/larastan/bootstrap.php',
    ])
    ->withPHPStanConfigs([
        __DIR__ . '/phpstan.neon',
        __DIR__ . '/vendor/larastan/larastan/extension.neon',
        __DIR__ . '/vendor/spaze/phpstan-disallowed-calls/extension.neon',
    ]);
