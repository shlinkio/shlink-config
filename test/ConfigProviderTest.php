<?php

declare(strict_types=1);

namespace ShlinkioTest\Shlink\Config;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Shlinkio\Shlink\Config\ConfigProvider;
use Shlinkio\Shlink\Config\Factory\DottedAccessConfigAbstractFactory;

class ConfigProviderTest extends TestCase
{
    private ConfigProvider $configProvider;

    public function setUp(): void
    {
        $this->configProvider = new ConfigProvider();
    }

    #[Test]
    public function configIsReturned(): void
    {
        $config = ($this->configProvider)();
        self::assertArrayHasKey('dependencies', $config);
        self::assertEquals([
            'abstract_factories' => [
                DottedAccessConfigAbstractFactory::class,
            ],
        ], $config['dependencies']);
    }
}
