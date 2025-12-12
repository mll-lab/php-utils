## v6.0.0

### Changed

- Require PHP ^8.1 for the main package
- Use PHP 8.1 features: `readonly` properties, union type syntax

### Added

- Automatic PHP 7.4 downgraded releases via `.74` tag suffix (e.g., `v6.0.0.74`)
- GitHub Actions workflow for automated downgrade releases

### Migration

Users on PHP 7.4 or 8.0 should use the `.74` tagged releases:
```sh
composer require mll-lab/php-utils:v6.0.0.74
```

# [5.23.0](https://github.com/mll-lab/php-utils/compare/v5.22.0...v5.23.0) (2025-12-08)


### Features

* **phpstan:** add separate ID capitalization rules for variables, parameters, methods, and classes ([#64](https://github.com/mll-lab/php-utils/issues/64)) ([02b2f53](https://github.com/mll-lab/php-utils/commit/02b2f535882b8ccb10503a029487ddb485ae478e))

# [5.22.0](https://github.com/mll-lab/php-utils/compare/v5.21.0...v5.22.0) (2025-12-04)


### Features

* **phpstan:** add 'Idt' to VariableNameIdToIDRule false positives ([99b1d2d](https://github.com/mll-lab/php-utils/commit/99b1d2dd38c543fb61325198a8bfa0ed7b78e5ef))

# [5.21.0](https://github.com/mll-lab/php-utils/compare/v5.20.0...v5.21.0) (2025-12-02)


### Features

* add TryFromNameTrait for enum name lookup ([45e08c3](https://github.com/mll-lab/php-utils/commit/45e08c376e912c3ea64809d918b7e322911d6a5a))

# [5.20.0](https://github.com/mll-lab/php-utils/compare/v5.19.1...v5.20.0) (2025-09-25)


### Features

* QiaxcelImport allows to create an import file for a Qiaxcel device from Qiagen ([433eea3](https://github.com/mll-lab/php-utils/commit/433eea30de399662089681efa7da9a56f51c7f65))

## [5.19.1](https://github.com/mll-lab/php-utils/compare/v5.19.0...v5.19.1) (2025-08-22)

### Bug Fixes

* exclude irrelevant files from composer package ([beb08f3](https://github.com/mll-lab/php-utils/commit/beb08f371142d271536fac834c2c00a337c01cff))

## v5.19.0

### Added

- Add PHPStan-Rule `MLL\Utils\PHPStan\Rules\MissingClosureParameterTypehintRule.php`

## v5.18.0

### Added

- Support parsing Lightcycler Sample Sheets from XML-file https://github.com/mll-lab/php-utils/pull/56

## v5.17.0

### Added

- Support creating Lightcycler Sample Sheets for Absolute Quantification https://github.com/mll-lab/php-utils/pull/55
- Accept `iterable $data` in `CSVArray::toCSV` https://github.com/mll-lab/php-utils/pull/55

## v5.16.0

### Added

- Disallow `Carbon\Carbon::create()` via PHPStan rule

## v5.15.0

### Changed

- Update method signatures to use `CarbonInterface` in `MLL\Utils\BavarianHolidays` for better type flexibility

## v5.14.0

### Added

- Register rules as a PHPStan extension

### Deprecated

- Deprecate `NoAssignmentInIfRule`

## v5.13.0

### Added

- Support `illuminate/support` version 12
- Support `thecodingmachine/safe` version 3
- Add error identifiers to custom PHPStan rules

### Changed

- Refine PHPDoc types

## v5.12.1

### Fixed

- Update type annotations in namespace `MLL\Utils\Tecan` to use `array<int>` over `array<int, int>`

## v5.12.0

### Added

- Default missing columns to empty strings instead of throwing in `CSVArray::toArray`
- Ensure extensibility by using `new static` over `new self` everywhere

## v5.11.0

### Added

- Allow `int` parts in `StringUtil::joinNonEmpty`

## v5.10.0

### Added

- Support creating Lightcycler Sample Sheets for Relative Quantification

## v5.9.0

### Added

- Add class `MLL\Utils\Specification` for logical combinations of predicates

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
