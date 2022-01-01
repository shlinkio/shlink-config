<?php

declare(strict_types=1);

namespace Shlinkio\Shlink\Config;

use Laminas\Config\Factory;
use Laminas\Stdlib\Glob;

use function getenv;
use function strtolower;
use function trim;

/**
 * Loads configuration files which match provided glob pattern, and returns the merged result as array
 */
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
