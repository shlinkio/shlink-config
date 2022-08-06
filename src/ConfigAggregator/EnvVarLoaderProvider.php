<?php

declare(strict_types=1);

namespace Shlinkio\Shlink\Config\ConfigAggregator;

use function in_array;
use function Shlinkio\Shlink\Config\loadConfigFromGlob;
use function Shlinkio\Shlink\Config\putNotYetDefinedEnv;

class EnvVarLoaderProvider
{
    public function __construct(private readonly string $configPath, private readonly ?array $allowedEnvVars = null)
    {
    }

    public function __invoke(): array
    {
        $config = loadConfigFromGlob($this->configPath);
        foreach ($config as $envVar => $value) {
            if ($this->allowedEnvVars !== null && ! in_array($envVar, $this->allowedEnvVars, true)) {
                continue;
            }

            putNotYetDefinedEnv($envVar, $value);
        }

        return [];
    }
}
