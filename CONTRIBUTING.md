# CONTRIBUTING

We are using [GitHub Actions](https://github.com/features/actions) as a continuous integration system.

For details, see [`workflows`](.github/workflows).

## Code Style

We are using [`friendsofphp/php-cs-fixer`](https://github.com/friendsofphp/php-cs-fixer) to automatically format the code.

Run

```bash
make fix
```

to automatically format the code.

## Static Code Analysis

We are using [`phpstan/phpstan`](https://github.com/phpstan/phpstan) to statically analyze the code.

Run

```bash
make stan
```

to run a static code analysis.

## Tests

We are using [`phpunit/phpunit`](https://github.com/sebastianbergmann/phpunit) to drive the development.

Run

```bash
make test
```

to run all the tests.

## Extra lazy?

Run

```bash
make
```

to enforce coding standards, perform a static code analysis, and run tests!

:bulb: Run

```bash
make help
```

to display a list of available targets with corresponding descriptions.

## Commit Message Convention

This project uses [Conventional Commits](https://conventionalcommits.org) for automated version management and release notes generation.

### Format

```
<type>[optional scope]: <description>

[optional body]

[optional footer(s)]
```

### Types

- **feat**: A new feature (triggers a minor version bump)
- **fix**: A bug fix (triggers a patch version bump)
- **docs**: Documentation only changes
- **style**: Changes that do not affect the meaning of the code (white-space, formatting, missing semi-colons, etc)
- **refactor**: A code change that neither fixes a bug nor adds a feature
- **perf**: A code change that improves performance
- **test**: Adding missing tests or correcting existing tests
- **chore**: Changes to the build process or auxiliary tools and libraries

### Breaking Changes

Add `BREAKING CHANGE:` in the footer or append `!` after the type/scope to indicate breaking changes (triggers a major version bump).

### Examples

```
feat: add support for PHP 8.4
fix: resolve memory leak in CSV parsing
docs: update installation instructions
feat!: drop support for PHP 7.4
feat(csv): add new export format

BREAKING CHANGE: PHP 7.4 is no longer supported
```

### Scopes (optional)

You can use scopes to specify which part of the codebase is affected:
- `csv`: CSV-related functionality
- `holidays`: Holiday calculation features
- `microplate`: Microplate handling
- `phpstan`: PHPStan rules
- `scanner`: Scanner-related features
- `samplesheet`: Sample sheet functionality
