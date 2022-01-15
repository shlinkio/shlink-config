<?php

declare(strict_types=1);

namespace Shlinkio\Shlink\Config;

use Laminas\Config\Factory;
use Laminas\Stdlib\Glob;

use function getenv;
use function implode;
use function is_array;
use function is_scalar;
use function putenv;
use function sprintf;
use function strtolower;
use function trim;

function loadConfigFromGlob(string $globPattern): array
{
    /** @var array $config */
    $config = Factory::fromFiles(Glob::glob($globPattern, Glob::GLOB_BRACE));
    return $config;
}

function env(string $key, mixed $default = null): mixed
{
    $value = getenv($key);
    if ($value === false) {
        return $default;
    }

    return match (strtolower($value)) {
        'true', '(true)' => true,
        'false', '(false)' => false,
        'empty', '(empty)' => '',
        'null', '(null)' => null,
        default => trim($value),
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
