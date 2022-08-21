<?php

declare(strict_types=1);

namespace Shlinkio\Shlink\Config\Factory;

use function Shlinkio\Shlink\Config\swooleIsInstalled;

class SwooleInstalledFactory
{
    public const SWOOLE_INSTALLED = 'Shlinkio\Shlink\Config\SwooleInstalled';

    public function __invoke(): callable
    {
        return swooleIsInstalled(...);
    }
}
