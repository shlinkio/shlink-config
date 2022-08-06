# Shlink config

[![Build Status](https://img.shields.io/github/workflow/status/shlinkio/shlink-config/Continuous%20integration/main?logo=github&style=flat-square)](https://github.com/shlinkio/shlink-config/actions?query=workflow%3A%22Continuous+integration%22)
[![Code Coverage](https://img.shields.io/codecov/c/gh/shlinkio/shlink-config/main?style=flat-square)](https://app.codecov.io/gh/shlinkio/shlink-config)
[![Infection MSI](https://img.shields.io/endpoint?style=flat-square&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fshlinkio%2Fshlink-config%2Fmain)](https://dashboard.stryker-mutator.io/reports/github.com/shlinkio/shlink-config/main)
[![Latest Stable Version](https://img.shields.io/github/release/shlinkio/shlink-config.svg?style=flat-square)](https://packagist.org/packages/shlinkio/shlink-config)
[![License](https://img.shields.io/github/license/shlinkio/shlink-config.svg?style=flat-square)](https://github.com/shlinkio/shlink-config/blob/main/LICENSE)
[![Paypal donate](https://img.shields.io/badge/Donate-paypal-blue.svg?style=flat-square&logo=paypal&colorA=aaaaaa)](https://slnk.to/donate)

Utils to load, parse and work with configuration on Shlink project.

## Installation

Install this tool using [composer](https://getcomposer.org/).

    composer install shlinkio/shlink-config

> This library is also a mezzio module which provides its own `ConfigProvider`. Add it to your configuration to get everything automatically set up.

## Included utils

* `loadConfigFromGlob`: Function which expects a glob pattern and loads and merges all config files that match it.
* `DottedAccessConfigAbstractFactory`: An abstract factory that lets any config param to be fetched as a service by using the `config.foo.bar` notation.
* `EnvVarLoaderProvider`: A config provider which loads the entries of the loaded config into env vars and always returns empty. Designed to be the first config provider in the pipeline.
