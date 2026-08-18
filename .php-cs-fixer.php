<?php declare(strict_types=1);

use function MLL\PhpCsFixerConfig\risky;

$finder = PhpCsFixer\Finder::create()
    ->notPath('vendor')
    ->exclude('tests/PHPStan/data') // Fixtures intentionally violate the rules under test
    ->in(__DIR__)
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

$config = risky($finder);
$config->setCacheFile(__DIR__ . '/.build/php-cs-fixer/cache');

return $config;
