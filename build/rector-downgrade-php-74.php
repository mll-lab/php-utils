<?php declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\DowngradePhp80\Rector\Class_\DowngradeAttributeToAnnotationRector;
use Rector\DowngradePhp80\ValueObject\DowngradeAttributeToAnnotation;

return RectorConfig::configure()
    ->withDowngradeSets(php74: true)
    ->withConfiguredRule(DowngradeAttributeToAnnotationRector::class, [
        new DowngradeAttributeToAnnotation(
            'PHPUnit\Framework\Attributes\DataProvider',
            'dataProvider'
        ),
    ]);
