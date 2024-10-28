<?php

declare(strict_types=1);

namespace Shlinkio\Shlink\Config\ConfigAggregator;

use function Shlinkio\Shlink\Config\loadEnvVarsFromConfig;

/** @deprecated Use loadEnvVarsFromConfig instead */
class EnvVarLoaderProvider
{
    public function __construct(private readonly string $configPath, private readonly array|null $allowedEnvVars = null)
    {
    }

    public function __invoke(): array
    {
        loadEnvVarsFromConfig($this->configPath, $this->allowedEnvVars);
        return [];
    }
}
