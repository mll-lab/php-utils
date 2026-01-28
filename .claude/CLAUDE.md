# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Overview

This is `mll-lab/php-utils`, a PHP library of shared utilities for MLL (Munich Leukemia Laboratory).
It provides domain-specific utilities for laboratory automation equipment, sample sheets, microplates, and general PHP helpers.

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

### Domain Modules

- **Microplate** (`src/Microplate`) - Generic coordinate system for laboratory microplates (96-well, 48-well, etc.)
  - `CoordinateSystem` - Abstract base defining rows/columns (e.g., `CoordinateSystem12x8` for 96-well plates)
  - `Coordinates` - Represents a position like "A1" with row/column
  - `Microplate` - Generic container mapping coordinates to well contents
  - `Section` / `SectionedMicroplate` - Subdivide plates into logical regions
  - `MicroplateSet` - Work with multiple plates as a unit (AB, ABCD, ABCDE variants)

- **Tecan** (`src/Tecan`) - Generate pipetting instructions for Tecan liquid handling robots (GWL format)
  - `BasicCommands` - Low-level commands: Aspirate, Dispense, Wash, etc.
  - `CustomCommands` - Higher-level compound operations
  - `Rack` - Predefined rack types (FluidXRack, DestPCR, etc.)
  - `TecanProtocol` - Builds complete protocol files

- **IlluminaSampleSheet** (`src/IlluminaSampleSheet`) - Generate sample sheets for Illumina sequencers
  - `V1` - Classic format (MiSeq, NextSeq, etc.)
  - `V2` - NovaSeq X format with BCL Convert sections

- **LightcyclerSampleSheet** (`src/LightcyclerSampleSheet`) - Sample sheets for Roche LightCycler qPCR

- **FluidXPlate** (`src/FluidXPlate`) - FluidX tube rack scanning and barcode validation

- **TecanScanner** (`src/TecanScanner`) - Parse Tecan scanner output files

- **Qiaxcel** (`src/Qiaxcel`) - Import Qiagen Qiaxcel capillary electrophoresis data

### General Utilities

- `BavarianHolidays` - Bavarian holiday calendar with business day calculations
- `StringUtil`, `Number`, `CSVArray` - Common helpers
- `Specification` - Specification pattern implementation

### PHPStan Extension

Custom PHPStan rules in `src/PHPStan/Rules`:
- `IdToIDRule` and variants - Enforce "ID" capitalization (not "Id") in variable names, method names, class names, property names
- `MissingClosureParameterTypehintRule` - Require closure parameter type hints
- `ThrowableClassNameRule` - Naming conventions for exception classes

Rules are configured in `rules.neon` and `extension.neon`.

## Conventions

### ID Capitalization

Use "ID" not "Id" in names: `$userID`, `getUserID()`, `SampleID` (not `$userId`, `getUserId()`, `SampleId`).
PHPStan rules enforce this.

### Coordinate System Naming

Name coordinate systems by dimensions: `CoordinateSystem12x8` (12 columns × 8 rows = 96 wells), not by total positions.

### Tests

Tests mirror the `src` structure under `tests`.
Use PHPUnit attributes for data providers: `#[DataProvider('dataProviderName')]`.
