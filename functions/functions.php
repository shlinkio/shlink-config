<?php

declare(strict_types=1);

namespace Shlinkio\Shlink\Config;

use Laminas\Config\Factory;
use Laminas\Stdlib\Glob;

use function array_combine;
use function array_filter;
use function array_keys;
use function array_map;
use function array_values;
use function extension_loaded;
use function getenv;
use function implode;
use function is_array;
use function is_numeric;
use function is_scalar;
use function putenv;
use function sprintf;
use function str_replace;
use function str_starts_with;
use function strtolower;
use function trim;

use const ARRAY_FILTER_USE_KEY;
use const PHP_SAPI;

const OPENSWOOLE_VERSION_ENV = 'OPENSWOOLE_VERSION';

function loadConfigFromGlob(string $globPattern): array
{
    /** @var array $config */
    $config = Factory::fromFiles(Glob::glob($globPattern, Glob::GLOB_BRACE));
    return $config;
}

function env(string $key, mixed $default = null): mixed
{
    $value = getenv($key);
    return $value === false ? $default : parseEnvVar($value);
}

function parseEnvVar(string $value): string|int|bool|null
{
    $trimmedValue = trim($value);
    return match (strtolower($trimmedValue)) {
        'true', '(true)' => true,
        'false', '(false)' => false,
        'empty', '(empty)' => '',
        'null', '(null)' => null,
        default => is_numeric($trimmedValue) ? (int) $trimmedValue : $trimmedValue,
    };
}

function putNotYetDefinedEnv(string $key, mixed $value): void
{
    $isArray = is_array($value);
    if (!($isArray || is_scalar($value)) || env($key) !== null) {
        return;
    }

    $normalizedValue = $isArray ? implode(',', $value) : match ($value) {
        true => 'true',
        false => 'false',
        default => (string) $value,
    };
    putenv(sprintf('%s=%s', $key, $normalizedValue));
}

function getOpenswooleConfigFromEnv(): array
{
    $swoolePrefix = 'OPENSWOOLE_';
    $env = getenv();
    $env = array_filter(
        $env,
        static fn (string $key) => str_starts_with($key, $swoolePrefix) && $key !== OPENSWOOLE_VERSION_ENV,
        ARRAY_FILTER_USE_KEY,
    );
    $keys = array_map(static fn (string $key) => strtolower(str_replace($swoolePrefix, '', $key)), array_keys($env));
    $values = array_map(parseEnvVar(...), array_values($env));

    return array_combine($keys, $values);
}

function openswooleIsInstalled(): bool
{
    // TODO regular swoole support is deprecated. Stop checking for it once Shlink v4.0.0 is released
    return extension_loaded('openswoole') || extension_loaded('swoole');
}

function runningInOpenswoole(): bool
{
    return PHP_SAPI === 'cli' && env(OPENSWOOLE_VERSION_ENV) !== null && openswooleIsInstalled();
}

function runningInRoadRunner(): bool
{
    return PHP_SAPI === 'cli' && env('RR_MODE') !== null;
}
