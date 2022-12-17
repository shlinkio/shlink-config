# Shlink config

[![Build Status](https://img.shields.io/github/actions/workflow/status/shlinkio/shlink-config/ci.yml?branch=main&logo=github&style=flat-square)](https://github.com/shlinkio/shlink-config/actions/workflows/ci.yml?query=workflow%3A%22Continuous+integration%22)
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
* `EnvVarLoaderProvider`: A config provider which loads the entries of the loaded config into env vars and always returns empty. Designed to be the first config provider in the pipeline.
* `DottedAccessConfigAbstractFactory`: An abstract factory that lets any config param to be fetched as a service by using the `config.foo.bar` notation.
* `ValinorConfigFactory`: A PSR-11 factory that lets you map arbitrary objects from arrays, using [cuyz/valinior](https://github.com/CuyZ/Valinor).

    In order to use it, you have to register the object to map as a service, and the ValinorConfigFactory with static access using the service that returns the raw array with the data as the static method name:

    ```php
    <?php

    declare(strict_types=1);

    return [
        MyCoolOptions::class => [ValinorConfigFactory::class, 'config.foo.options'],
    ];
    ```

    It is useful to combine this factory with the `DottedAccessConfigAbstractFactory`.

    The mapping will be done with cache if a `Psr\SimpleCache\CacheInterface` service is found.
