<?php

declare(strict_types=1);

namespace ShlinkioTest\Shlink\Config\Functions;

use PHPUnit\Framework\TestCase;

use function putenv;
use function Shlinkio\Shlink\Config\getOpenswooleConfigFromEnv;

class GetOpenswooleConfigFromEnvTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        putenv('FOO_ENV=foo');
        putenv('BAR_ENV=bar');
        putenv('OPENSWOOLE_PACKAGE_MAX_LENGTH=1000000');
        putenv('OPENSWOOLE_MAX_CONN=8888');
        putenv('OPENSWOOLE_TASK_ENABLE_COROUTINE=true');
        putenv('OPENSWOOLE_VERSION=22.0.0');
    }

    public static function tearDownAfterClass(): void
    {
        putenv('FOO_ENV');
        putenv('BAR_ENV');
        putenv('OPENSWOOLE_PACKAGE_MAX_LENGTH');
        putenv('OPENSWOOLE_MAX_CONN');
        putenv('OPENSWOOLE_TASK_ENABLE_COROUTINE');
        putenv('OPENSWOOLE_VERSION');
    }

    /** @test */
    public function properEnvVarsAreReadAndParsed(): void
    {
        self::assertEquals([
            'package_max_length' => 1000000,
            'max_conn' => 8888,
            'task_enable_coroutine' => true,
        ], getOpenswooleConfigFromEnv());
    }
}
