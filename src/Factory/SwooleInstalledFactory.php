<?php

declare(strict_types=1);

namespace Shlinkio\Shlink\Config\Factory;

use function Shlinkio\Shlink\Config\openswooleIsInstalled;

/**
 * @deprecated Openswoole support to be removed in Shlink 4.0.0
 */
class SwooleInstalledFactory
{
    public const SWOOLE_INSTALLED = 'Shlinkio\Shlink\Config\SwooleInstalled';

    public function __invoke(): callable
    {
        return openswooleIsInstalled(...);
    }
}
