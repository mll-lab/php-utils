<?php
use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\DowngradeLevelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->sets([
        DowngradeLevelSetList::DOWN_TO_PHP_74,
    ]);
};
