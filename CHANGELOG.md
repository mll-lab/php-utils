# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

See [GitHub releases](https://github.com/mll-lab/php-utils/releases).

## Unreleased

## v6.0.0

### Changed

- Breaking Change: Renamed class `MLL\Utils\PHPStan\Rules\VariableNameIdToIDRule` to `MLL\Utils\PHPStan\Rules\NameIdToIDRule`
- Refactored `MLL\Utils\PHPStan\Rules\NameIdToIDRule` to handle variable names, parameter names, method names and class names for incorrect capitalization of "Id"
- Add 'Idt' to the list of incorrect capitalizations for "Id" of `MLL\Utils\PHPStan\Rules\NameIdToIDRule`
- Add RuleIdentifier 'mllLabRules.nameIdToID' to `MLL\Utils\PHPStan\Rules\NameIdToIDRule`

## v5.8.0

### Added

- Add PHPStan-Rule `MLL\Utils\PHPStan\Rules\ThrowableClassNameRule`

## v5.7.0

### Added

- Add PHPStan-Rule `MLL\Utils\PHPStan\Rules\VariableNameIdToIDRule`

## v5.6.0

### Added

- Improve code quality with automatic type declarations via Rector
- Improve code quality with automatic rector rules for PHPUnit

## v5.5.2

### Fixed

- Changed coordinate system for  `MLL\Utils\Tecan\Rack\MasterMixRack`

## v5.5.1

### Fixed

- Fix generic inference for `MLL\Utils\Microplate\Coordinates::fromPosition()`

## v5.5.0

### Added

- Add scalar `Column6`

## v5.4.0

### Added

- Add command `SetDiTiType` to tecan worklist

## v5.3.0

### Added

- Add methods `CoordinateSystem::equals()` and `Coordinates::equals()`
- Add coordinate system `CoordinateSystem6x8`
- Add method `CoordinateSystem::fromArray()`

## v5.2.0

### Added

- Add coordinate systems `CoordinateSystem4x3`, `CoordinateSystem8x6` and `CoordinateSystem12x8`

### Changed

- Deprecate coordinate systems `CoordinateSystem12Well`, `CoordinateSytem48Well` and `CoordinateSystem96Well`

## v5.1.0

### Added

- Racks are connected to a `CoordinateSystem`

## v5.0.0

### Added

- Add coordinate system `CoordinateSystem2x16`

### Changed

- Breaking Change: Renamed class `Column96Well` to `Column12`
- Breaking Change: Renamed class `Row96Well` to `Row8`

## v4.1.0

### Added

- Add generics to `BaseRack` and its children

## v4.0.0

### Added

- Add specific class for each `MLLLabWareRack`-type that includes a `positions`-Collection

### Changed

- Breaking Change: Delete class `MLLLabWareRack`
- Breaking Change: Delete class `CustomRack`
- Breaking Change: Add method `positionCount` to interface `Rack`
- Breaking Change: Limit the usage of `BarcodeLocation` to objects implementing `ScannedRack`

## v3.2.0

### Added

- Support `nesbot/carbon` 3

## v3.1.0

### Changed

- Add optional column `Project` to Illumina Sample Sheets (V2) for NovaSeq

## v3.0.0

### Changed

- All `OverrideCycle` total counts on `DataSection` must grow to the `ReadsSection` maximum value by adding the N-tag
- Throw when trying to use an empty `DataSection`
- Breaking Change: class `OverrideCycles` requires class `DataSection` to calculate the max cycles

### Fixed

- Use method `maxRead2Cycles` for calculating `$fillUpToMax` for `read2`, not `maxRead1Cycles`

## v2.2.0

### Added

- Add class `DnaSequence`

## v2.1.0

### Added

- Support creating Illumina Sample Sheets (V1) for NovaSeq

## v2.0.0

### Changed

- Generate the Reads-Sections dynamically from the OverrideCycles-part of the Samples-Section for Illumina NovaSeq Sample Sheets (V2)
- OverrideCycles on BclSample not nullable

## v1.14.0

### Added

- Support creating Illumina NovaSeq Sample Sheets (V2) for NovaSeqX

## v1.13.0

### Added

- Integrate `mll-lab/microplate` and `mll-lab/liquid-handling-robotics`
- Support Laravel 11

## v1.12.0

### Added

- Add `StringUtil::toUTF8()`

## v1.11.0

### Added

- Integrate `mll-lab/holidays`

## v1.10.0

### Added

- Allow custom line separator in `CSVArray::toCSV()`

## v1.9.0

### Added

- Add `StringUtil::joinNonEmpty()`

## v1.8.1

### Changed

- Exclude `NoAssignmentInIfRule` by default

## v1.8.0

### Added

- Add PHPStan extension with `NoAssignmentInIfRule`

## v1.7.0

### Added

- Add `QxManagerSampleSheet::toCsvString(...)`

## v1.6.1

### Fixed

- `CSVArray::toArray()` returns `array<int, array<string, string>>`

## v1.6.0

### Added

- Support `illuminate/support:^10`

## v1.5.0

### Added

- Support `thecodingmachine/safe:^2`

## v1.4.0

### Added

- Add `Number::clamp()`

## v1.3.0

### Added

- Add parameters `$enclosure` and `$escape` to `CSVArray::toArray`

## v1.2.0

### Added

- Support `illuminate/support` version 9

## v1.1.1

### Fixed

- Fix errors in `composer.lock`

## v1.1.0

### Added

- Add `CSVArray`

## v1.0.0

### Added

- Add `StringUtil`
