<?php

declare(strict_types=1);

namespace ShlinkioTest\Shlink\Config\Functions;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

use function Shlinkio\Shlink\Config\loadConfigFromGlob;

class LoadConfigFromGlobTest extends TestCase
{
    #[Test]
    public function expectedConfigIsProduced(): void
    {
        $result = loadConfigFromGlob(__DIR__ . '/../../test-resources/configs/*.{global,local}.php');
        self::assertEquals([
            'foo' => [
                'something' => false,
                'else' => 'bar',
            ],
            'bar' => [
                'number' => 123,
                'array' => [1, 2, 3]
            ],
        ], $result);
    }
}
