<?php declare(strict_types=1);

$includes = [];

if (class_exists(\Spaze\PHPStan\Rules\Disallowed\DisallowedHelper::class)) {
    $includes[] = __DIR__ . '/../rules.neon';
}

// PHP < 8.1: exclude enums, add ignores for older PHPStan versions
if (version_compare(PHP_VERSION, '8.1', '<')) {
    $includes[] = __DIR__ . '/php-below-8.1.neon';
}

return ['includes' => $includes];
