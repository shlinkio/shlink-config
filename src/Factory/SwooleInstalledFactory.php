<?php

declare(strict_types=1);

namespace Shlinkio\Shlink\Config\Factory;

use function extension_loaded;

class SwooleInstalledFactory
{
    public const SWOOLE_INSTALLED = 'Shlinkio\Shlink\Config\SwooleInstalled';

    public function __invoke(): callable
    {
        return static fn (): bool => extension_loaded('openswoole') || extension_loaded('swoole');
    }
}
