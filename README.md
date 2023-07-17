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

### PHPStan extension

This library provides a PHPStan extension that is either registered through [PHPStan Extension Installer](https://github.com/phpstan/extension-installer)
or registered manually by adding the following to your `phpstan.neon`:

```diff
includes:
+- vendor/mll-lab/php-utils/phpstan-extension.neon
```

## Changelog

See [`CHANGELOG.md`](CHANGELOG.md).

## Contributing

See [`CONTRIBUTING.md`](.github/CONTRIBUTING.md).

## License

This package is licensed using the MIT License.
