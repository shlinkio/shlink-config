<?php

declare(strict_types=1);

namespace ShlinkioTest\Shlink\Config\ConfigAggregator;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Shlinkio\Shlink\Config\ConfigAggregator\EnvVarLoaderProvider;

use function getenv;
use function putenv;
use function Shlinkio\Shlink\Config\env;

class EnvVarLoaderProviderTest extends TestCase
{
    private const VALID_ENV_VARS = [
        'BAR',
        'BAZ',
        'NUMBER',
        'OVERWRITTEN_ENV',
        'ENV_ARRAY',
    ];

    protected function setUp(): void
    {
        putenv('OVERWRITTEN_ENV=already_exists');
    }

    protected function tearDown(): void
    {
        foreach (self::VALID_ENV_VARS as $envVar) {
            putenv($envVar . '=');
        }
    }

    #[Test]
    public function putsExpectedEnvVars(): void
    {
        $provider = new EnvVarLoaderProvider(
            __DIR__ . '/../../test-resources/generated_config.php',
            self::VALID_ENV_VARS,
        );

        $result = $provider();

        self::assertEquals([], $result);
        self::assertEquals('true', getenv('BAR'));
        self::assertTrue(env('BAR'));
        self::assertEquals('false', getenv('BAZ'));
        self::assertFalse(env('BAZ'));
        self::assertEquals('already_exists', getenv('OVERWRITTEN_ENV'));
        self::assertEquals('foo,bar,baz', getenv('ENV_ARRAY'));
        self::assertFalse(getenv('foo'));
        self::assertFalse(getenv('foo2'));
        self::assertEquals('3', getenv('NUMBER'));
        self::assertEquals(3, env('NUMBER'));
    }
}
