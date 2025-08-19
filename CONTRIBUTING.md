# Commit Message Convention

This project uses [Conventional Commits](https://conventionalcommits.org/) for automated version management and release notes generation.

## Format

```
<type>[optional scope]: <description>

[optional body]

[optional footer(s)]
```

## Types

- **feat**: A new feature (triggers a minor version bump)
- **fix**: A bug fix (triggers a patch version bump)
- **docs**: Documentation only changes
- **style**: Changes that do not affect the meaning of the code (white-space, formatting, missing semi-colons, etc)
- **refactor**: A code change that neither fixes a bug nor adds a feature
- **perf**: A code change that improves performance
- **test**: Adding missing tests or correcting existing tests
- **chore**: Changes to the build process or auxiliary tools and libraries

## Breaking Changes

Add `BREAKING CHANGE:` in the footer or append `!` after the type/scope to indicate breaking changes (triggers a major version bump).

## Examples

```
feat: add support for PHP 8.4
fix: resolve memory leak in CSV parsing
docs: update installation instructions
feat!: drop support for PHP 7.4
feat(csv): add new export format

BREAKING CHANGE: PHP 7.4 is no longer supported
```

## Scopes (optional)

You can use scopes to specify which part of the codebase is affected:
- `csv`: CSV-related functionality
- `holidays`: Holiday calculation features
- `microplate`: Microplate handling
- `phpstan`: PHPStan rules
- `scanner`: Scanner-related features
- `samplesheet`: Sample sheet functionality
