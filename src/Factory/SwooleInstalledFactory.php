<?php

declare(strict_types=1);

namespace Shlinkio\Shlink\Config\Factory;

use function extension_loaded;

class SwooleInstalledFactory
{
    public const SWOOLE_INSTALLED = 'Shlinkio\Shlink\Config\SwooleInstalled';

    public function __invoke(): callable
    {
        // TODO regular swoole support is deprecated. Stop checking for it once Shlink v4.0.0 is released
        return static fn (): bool => extension_loaded('openswoole') || extension_loaded('swoole');
    }
}
