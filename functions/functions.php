<?php

declare(strict_types=1);

namespace Shlinkio\Shlink\Config;

use Laminas\Config\Factory;
use Laminas\Stdlib\Glob;

/**
 * Loads configuration files which match provided glob pattern, and returns the merged result as array
 */
function loadConfigFromGlob(string $globPattern): array
{
    /** @var array $config */
    $config = Factory::fromFiles(Glob::glob($globPattern, Glob::GLOB_BRACE));
    return $config;
}
