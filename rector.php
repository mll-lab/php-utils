<?php declare(strict_types=1);

use Rector\CodeQuality\Rector\BooleanNot\SimplifyDeMorganBinaryRector;
use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\CodeQuality\Rector\Concat\JoinStringConcatRector;
use Rector\CodeQuality\Rector\Equal\UseIdenticalOverEqualWithSameTypeRector;
use Rector\CodeQuality\Rector\FuncCall\IntvalToTypeCastRector;
use Rector\CodeQuality\Rector\If_\SimplifyIfReturnBoolRector;
use Rector\CodingStyle\Rector\FuncCall\CountArrayToEmptyArrayComparisonRector;
use Rector\Config\RectorConfig;
use Rector\PHPUnit\Rector\Class_\PreferPHPUnitSelfCallRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\SetList;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictTypedCallRector;

use function MLL\RectorConfig\laravel;

return static function (RectorConfig $rectorConfig): void {
    laravel($rectorConfig);

    $rectorConfig->sets([
        PHPUnitSetList::PHPUNIT_40,
        PHPUnitSetList::PHPUNIT_50,
        PHPUnitSetList::PHPUNIT_60,
        PHPUnitSetList::PHPUNIT_70,
        PHPUnitSetList::PHPUNIT_80,
        PHPUnitSetList::PHPUNIT_90,
        PHPUnitSetList::PHPUNIT_CODE_QUALITY,
        PHPUnitSetList::ANNOTATIONS_TO_ATTRIBUTES,
    ]);

    $rectorConfig->sets([
        SetList::PHP_71,
        SetList::PHP_72,
        SetList::PHP_73,
        SetList::PHP_74,
        SetList::CODE_QUALITY,
    ]);

    $rectorConfig->rule(PreferPHPUnitSelfCallRector::class);

    $rectorConfig->skip([
        JoinStringConcatRector::class => [
            __DIR__ . '/tests/CSVArrayTest.php', // keep `\r\n` for readability
        ],
    ]);
    $rectorConfig->paths([__DIR__ . '/src', __DIR__ . '/tests']);
    $rectorConfig->phpstanConfig(__DIR__ . '/phpstan.neon');
};
