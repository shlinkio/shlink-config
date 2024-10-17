<?php

declare(strict_types=1);

namespace ShlinkioTest\Shlink\Config\Functions;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function Shlinkio\Shlink\Config\formatEnvVarValue;
use function Shlinkio\Shlink\Config\formatEnvVarValueOrNull;

class FormatEnvVarValueTest extends TestCase
{
    #[Test]
    #[TestWith(['foo', 'foo'])]
    #[TestWith([35, '35'])]
    #[TestWith([true, 'true'])]
    #[TestWith([false, 'false'])]
    #[TestWith([['abc', 'def', 'foo'], 'abc,def,foo'])]
    #[TestWith([[5, 7, 55], '5,7,55'])]
    #[TestWith([null, ''])]
    public function valuesAreFormattedAsExpected(string|int|bool|array|null $value, string $expectedResult): void
    {
        self::assertEquals($expectedResult, formatEnvVarValue($value));
        self::assertEquals($value === null ? null : $expectedResult, formatEnvVarValueOrNull($value));
    }
}
