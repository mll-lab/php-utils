# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Overview

This is `mll-lab/php-utils`, a PHP library of shared utilities for MLL (Munich Leukemia Laboratory).
It provides domain-specific utilities for laboratory automation equipment, sample sheets, microplates, and general PHP helpers.

Root namespace: `MLL\Utils\` (PSR-4 mapped to `src/`).
Supports PHP 7.4+, so avoid language features requiring PHP 8.1+ (enums, fibers, intersection types, etc.).

## Commands

```bash
make setup     # Install dependencies (runs composer update/validate/normalize)
make it        # Run commonly used targets: fix, stan, test
make fix       # Format code (rector + php-cs-fixer)
make stan      # Static analysis with PHPStan (level max)
make test      # Run PHPUnit tests
make coverage  # Run tests with code coverage
```

Run a single test:
```bash
vendor/bin/phpunit tests/BavarianHolidaysTest.php
vendor/bin/phpunit --filter testNameHoliday
```

## Release Process

This project uses [semantic-release](https://semantic-release.gitbook.io) for automated versioning and releases.
Releases are triggered automatically when commits are pushed to `master`.

### Commit Message Format

Commits must follow [Conventional Commits](https://www.conventionalcommits.org):
- `feat: add new feature` - triggers minor version bump (e.g., 5.23.0 → 5.24.0)
- `fix: correct bug` - triggers patch version bump (e.g., 5.23.0 → 5.23.1)
- `feat!:` or `BREAKING CHANGE:` in footer - triggers major version bump

PR titles are validated against this format by CI.
The CHANGELOG.md is automatically generated from commit messages.

### Scope Examples

Use scope to clarify the area of change:
- `feat(phpstan): add new rule` - PHPStan-related feature
- `fix(microplate): correct coordinate calculation` - Microplate module fix

## Architecture

Each subdirectory under `src/` is a self-contained module for a specific lab instrument or domain concept.
Tests mirror the `src/` structure under `tests/`.

### PHPStan Extension

This library ships custom PHPStan rules (`src/PHPStan/Rules/`) and disallowed call configs (`rules.neon`).
Consumer projects get these automatically via `phpstan/extension-installer`.

The `phpstan.neon` in this repo includes additional rules enabled only for this project itself.

## Conventions

### ID Capitalization

Use "ID" not "Id" in names: `$userID`, `getUserID()`, `SampleID` (not `$userId`, `getUserId()`, `SampleId`).
PHPStan rules enforce this.

### Coordinate System Naming

Name coordinate systems by dimensions: `CoordinateSystem12x8` (12 columns × 8 rows = 96 wells), not by total positions.

### Tests

Use PHPUnit attributes for data providers: `#[DataProvider('dataProviderName')]`.
