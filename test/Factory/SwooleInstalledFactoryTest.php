<?php

declare(strict_types=1);

namespace ShlinkioTest\Shlink\Config\Factory;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Shlinkio\Shlink\Config\Factory\SwooleInstalledFactory;

class SwooleInstalledFactoryTest extends TestCase
{
    private SwooleInstalledFactory $factory;

    public function setUp(): void
    {
        $this->factory = new SwooleInstalledFactory();
    }

    #[Test]
    public function properlyCreatesHelperFunction(): void
    {
        $func = ($this->factory)();

        self::assertFalse($func());
    }
}
