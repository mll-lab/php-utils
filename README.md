# php-utils

[![Continuous Integration](https://github.com/mll-lab/php-utils/workflows/Continuous%20Integration/badge.svg)](https://github.com/mll-lab/php-utils/actions)
[![Code Coverage](https://codecov.io/gh/mll-lab/php-utils/branch/master/graph/badge.svg)](https://codecov.io/gh/mll-lab/php-utils)

[![Latest Stable Version](https://poser.pugx.org/mll-lab/php-utils/v/stable)](https://packagist.org/packages/mll-lab/php-utils)
[![Total Downloads](https://poser.pugx.org/mll-lab/php-utils/downloads)](https://packagist.org/packages/mll-lab/php-utils)

Shared PHP utility functions of MLL

## Installation

Install through composer

```sh
composer require mll-lab/php-utils
```

## Usage

See [tests](tests).

### Holidays

You can add custom holidays by registering a method that returns a map of holidays for a given year.
Set this up in a central place that always runs before your application, e.g. a bootstrap method.

```php
use MLL\Holidays\BavarianHolidays;

BavarianHolidays::$loadUserDefinedHolidays = static function (int $year): array {
    switch ($year) {
        case 2019:
            return ['22.03' => 'Day of the Tentacle'];
        default:
            return [];
    }
};
```

Custom holidays have precedence over the holidays inherent to this library.

### PHPStan extension

This library provides a PHPStan extension that is either registered through [PHPStan Extension Installer](https://github.com/phpstan/extension-installer)
or registered manually by adding the following to your `phpstan.neon`:

```diff
includes:
+- vendor/mll-lab/php-utils/extension.neon
+- vendor/mll-lab/php-utils/rules.neon
```

Requires `spaze/phpstan-disallowed-calls`.

## Changelog

See [`CHANGELOG.md`](CHANGELOG.md).

## Contributing

See [`CONTRIBUTING.md`](.github/CONTRIBUTING.md).

## License

This package is licensed using the MIT License.
