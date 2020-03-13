# Shlink config

[![Build Status](https://img.shields.io/travis/shlinkio/shlink-config.svg?style=flat-square)](https://travis-ci.org/shlinkio/shlink-config)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/shlinkio/shlink-config.svg?style=flat-square)](https://scrutinizer-ci.com/g/shlinkio/shlink-config/?branch=master)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/shlinkio/shlink-config.svg?style=flat-square)](https://scrutinizer-ci.com/g/shlinkio/shlink-config/?branch=master)
[![Latest Stable Version](https://img.shields.io/github/release/shlinkio/shlink-config.svg?style=flat-square)](https://packagist.org/packages/shlinkio/shlink-config)
[![License](https://img.shields.io/github/license/shlinkio/shlink-config.svg?style=flat-square)](https://github.com/shlinkio/shlink-config/blob/master/LICENSE)
[![Paypal donate](https://img.shields.io/badge/Donate-paypal-blue.svg?style=flat-square&logo=paypal&colorA=aaaaaa)](https://slnk.to/donate)

Utils to load, parse and work with configuration on Shlink project.

## Installation

Install this tool using [composer](https://getcomposer.org/).

    composer install shlinkio/shlink-config

> This library is also a mezzio module which provides its own `ConfigProvider`. Add it to your configuration to get everything automatically set up.

## Included utils

* `loadConfigFromGlob`: Function which expects a glob pattern and loads and merges all config files that match it.
* `PathCollection`: Wraps a configuration array and lets you manipulate it using config paths. You can check if certain path exists, or get/set the value in certain path.
* `DottedAccessConfigAbstractFactory`: An abstract factory that lets any config param to be fetched as a service by using the `config.foo.bar` notation.
