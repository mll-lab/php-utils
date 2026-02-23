<?php declare(strict_types=1);

$includes = [];

// PHP 8.0+ can use rules.neon (requires spaze/phpstan-disallowed-calls)
// PHP 7.4 has this package removed via composer, so skip rules.neon
if (version_compare(PHP_VERSION, '8.0', '>=')) {
    $includes[] = __DIR__ . '/../rules.neon';
}

// PHP < 8.1: exclude enums, add ignores for older PHPStan versions
if (version_compare(PHP_VERSION, '8.1', '<')) {
    $includes[] = __DIR__ . '/php-below-8.1.neon';
}

return ['includes' => $includes];
