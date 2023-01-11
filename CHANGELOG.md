# CHANGELOG

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com), and this project adheres to [Semantic Versioning](https://semver.org).

## [Unreleased]
### Added
* Added function to resolve openswoole config from env vars.

### Changed
* *Nothing*

### Deprecated
* *Nothing*

### Removed
* *Nothing*

### Fixed
* *Nothing*


## [2.3.0] - 2022-12-16
### Added
* *Nothing*

### Changed
* [#22](https://github.com/shlinkio/shlink-config/issues/22) Updated to valinor 1.0.0 and changed ValinorConfigFactory to only allow superfuous keys.

### Deprecated
* *Nothing*

### Removed
* *Nothing*

### Fixed
* *Nothing*


## [2.2.0] - 2022-10-29
### Added
* *Nothing*

### Changed
* Migrated infection config to json5
* Used native valinor logic to convert keys to camelCase before mapping.
* Updated to valinor 0.16.

### Deprecated
* *Nothing*

### Removed
* *Nothing*

### Fixed
* *Nothing*


## [2.1.0] - 2022-09-18
### Added
* Created global function to check if swoole is installed
* Created new `ValinorConfigFactory` to map arrays into immutable objects with implicit validation

### Changed
* *Nothing*

### Deprecated
* *Nothing*

### Removed
* *Nothing*

### Fixed
* *Nothing*


## [2.0.0] - 2022-08-06
### Added
* *Nothing*

### Changed
* *Nothing*

### Deprecated
* *Nothing*

### Removed
* Dropped support for PHP 8.0
* Removed `PathCollection` class. It is no longer used anywhere in Shlink projects.

### Fixed
* *Nothing*


## [1.6.0] - 2022-01-27
### Added
* Added `EnvVarLoaderProvider` that loads generated config as env vars.

### Changed
* Updated to infection 0.26, enabling HTML reports.
* Added explicitly enabled composer plugins to composer.json.

### Deprecated
* Deprecated check for regular swoole extension.

### Removed
* *Nothing*

### Fixed
* *Nothing*


## [1.5.0] - 2022-01-01
### Added
* Added `env` function from `shlinkio/shlink-common` package.

### Changed
* *Nothing*

### Deprecated
* *Nothing*

### Removed
* *Nothing*

### Fixed
* *Nothing*


## [1.4.0] - 2021-12-05
### Added
* Created new factory to tell if either swoole or openswoole are enabled

### Changed
* *Nothing*

### Deprecated
* *Nothing*

### Removed
* *Nothing*

### Fixed
* *Nothing*


## [1.3.1] - 2021-11-01
### Added
* *Nothing*

### Changed
* *Nothing*

### Deprecated
* *Nothing*

### Removed
* *Nothing*

### Fixed
* Fixed regression introduced on return types of `DottedAccessConfigAbstractFactory`.


## [1.3.0] - 2021-11-01
### Added
* *Nothing*

### Changed
* Increased required phpstan level to 9
* Added experimental builds under PHP 8.1
* Moved ci workflow to external repo and reused
* Updated to phpstan 1.0

### Deprecated
* *Nothing*

### Removed
* Dropped support for PHP 7.4

### Fixed
* *Nothing*


## [1.2.0] - 2021-05-16
### Added
* Added new `PathCollection::unsetPath` method to recursively unset a specific path.

### Changed
* Migrated build to Github Actions

### Deprecated
* *Nothing*

### Removed
* *Nothing*

### Fixed
* *Nothing*


## [1.1.1] - 2020-11-10
### Added
* *Nothing*

### Changed
* *Nothing*

### Deprecated
* *Nothing*

### Removed
* *Nothing*

### Fixed
* Fixed `DottedAccessConfigAbstractFactory` not resolving null values that are explicitly defined.


## [1.1.0] - 2020-11-01
### Added
* *Nothing*

### Changed
* [#1](https://github.com/shlinkio/shlink-config/issues/1) Updated `infection` to v0.19.
* Added PHP 8 to the build matrix, allowing failures on it.

### Deprecated
* *Nothing*

### Removed
* *Nothing*

### Fixed
* *Nothing*


## [1.0.0] - 2020-03-13
### Added
* First stable release

### Changed
* *Nothing*

### Deprecated
* *Nothing*

### Removed
* *Nothing*

### Fixed
* *Nothing*
