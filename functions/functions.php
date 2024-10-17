<?php

declare(strict_types=1);

namespace Shlinkio\Shlink\Config;

use Laminas\Config\Factory;
use Laminas\Stdlib\Glob;

use function getenv;
use function implode;
use function in_array;
use function is_array;
use function is_numeric;
use function is_scalar;
use function putenv;
use function sprintf;
use function strtolower;
use function trim;

use const PHP_SAPI;

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

/**
 * @param string|string[]|int|int[]|bool|null $value
 */
function formatEnvVarValueOrNull(string|int|bool|array|null $value): string|null
{
    $isArray = is_array($value);
    if (! $isArray && ! is_scalar($value)) {
        return null;
    }

    return $isArray ? implode(',', $value) : match ($value) {
        true => 'true',
        false => 'false',
        default => (string) $value,
    };
}

/**
 * @param string|string[]|int|int[]|bool|null $value
 */
function formatEnvVarValue(string|int|bool|array|null $value): string
{
    return formatEnvVarValueOrNull($value) ?? '';
}

/**
 * Loads config from $configPath, then puts all its values as env vars if they are not yet defined
 */
function loadEnvVarsFromConfig(string $configPath, ?array $allowedEnvVars = null): void
{
    $config = loadConfigFromGlob($configPath);
    foreach ($config as $envVar => $value) {
        if ($allowedEnvVars !== null && ! in_array($envVar, $allowedEnvVars, true)) {
            continue;
        }

        putNotYetDefinedEnv($envVar, $value);
    }
}

function putNotYetDefinedEnv(string $key, mixed $value): void
{
    if (env($key) !== null) {
        return;
    }

    $formattedValue = formatEnvVarValueOrNull($value);
    if ($formattedValue === null) {
        return;
    }

    putenv(sprintf('%s=%s', $key, $formattedValue));
}

function runningInRoadRunner(): bool
{
    return PHP_SAPI === 'cli' && env('RR_MODE') !== null;
}
