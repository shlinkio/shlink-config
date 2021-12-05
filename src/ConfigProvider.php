<?php

declare(strict_types=1);

namespace Shlinkio\Shlink\Config;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [

            'dependencies' => [
                'factories' => [
                    Factory\SwooleInstalledFactory::SWOOLE_INSTALLED => Factory\SwooleInstalledFactory::class,
                ],
                'abstract_factories' => [
                    Factory\DottedAccessConfigAbstractFactory::class,
                ],
            ],

        ];
    }
}
