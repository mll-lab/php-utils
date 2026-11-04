<?php declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;

$config = RectorConfig::configure()
    ->withSets([
        SetList::CODE_QUALITY,
        SetList::TYPE_DECLARATION,
        SetList::RECTOR_PRESET,
    ])
    ->withPreparedSets(phpunitCodeQuality: true)
    ->withPhpSets()
    ->withRules([
        Rector\PHPUnit\CodeQuality\Rector\Class_\PreferPHPUnitSelfCallRector::class,
    ])
    ->withSkip([
        __DIR__ . '/tests/PHPStan/data', // fixtures intentionally violate the rules under test
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

// TODO remove after the rector/rector constraint drops ^1
if (method_exists($config, 'withComposerBased')) {
    $config = $config->withComposerBased(phpunit: true);
} else {
    $config = $config->withSets(array_map(
        'constant',
        array_map(fn (int $version): string => 'Rector\PHPUnit\Set\PHPUnitSetList::PHPUNIT_' . $version, [40, 50, 60, 70, 80, 90, 100, 110]),
    ));
}

return $config;
