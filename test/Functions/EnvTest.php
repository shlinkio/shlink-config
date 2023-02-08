<?php

declare(strict_types=1);

namespace ShlinkioTest\Shlink\Config\Functions;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

use function putenv;
use function Shlinkio\Shlink\Config\env;

class EnvTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        putenv('TRUE_VALUE=true');
        putenv('TRUE_VALUE_PARENTHESES=(true)');
        putenv('FALSE_VALUE=false');
        putenv('FALSE_VALUE_PARENTHESES=(false)');
        putenv('EMPTY_VALUE=empty');
        putenv('EMPTY_VALUE_PARENTHESES=(empty)');
        putenv('NULL_VALUE=null');
        putenv('NULL_VALUE_PARENTHESES=(null)');
        putenv('REGULAR_VALUE=   foo  ');
        putenv('INT_VALUE=100');
        putenv('NUMERIC_VALUE_VALUE=58.68');
    }

    public static function tearDownAfterClass(): void
    {
        putenv('TRUE_VALUE');
        putenv('TRUE_VALUE_PARENTHESES');
        putenv('FALSE_VALUE');
        putenv('FALSE_VALUE_PARENTHESES');
        putenv('EMPTY_VALUE');
        putenv('EMPTY_VALUE_PARENTHESES');
        putenv('NULL_VALUE');
        putenv('NULL_VALUE_PARENTHESES');
        putenv('REGULAR_VALUE');
        putenv('INT_VALUE');
        putenv('NUMERIC_VALUE_VALUE');
    }

    #[Test]
    public function envReturnsDefaultValueForUndefinedEnvVars(): void
    {
        self::assertEquals(null, env('THIS_DOES_NOT_EXIST'));
        self::assertEquals('default', env('THIS_DOES_NOT_EXIST', 'default'));
    }

    #[Test]
    public function specificValueKeywordsAreParsed(): void
    {
        self::assertTrue(env('TRUE_VALUE'));
        self::assertTrue(env('TRUE_VALUE_PARENTHESES'));
        self::assertFalse(env('FALSE_VALUE'));
        self::assertFalse(env('FALSE_VALUE_PARENTHESES'));
        self::assertEmpty(env('EMPTY_VALUE'));
        self::assertEmpty(env('EMPTY_VALUE_PARENTHESES'));
        self::assertNull(env('NULL_VALUE'));
        self::assertNull(env('NULL_VALUE_PARENTHESES'));
    }

    #[Test]
    public function numbersAreParsed(): void
    {
        self::assertSame(100, env('INT_VALUE'));
        self::assertSame(58, env('NUMERIC_VALUE_VALUE'));
    }

    #[Test]
    public function regularValuesAreTrimmed(): void
    {
        self::assertEquals('foo', env('REGULAR_VALUE'));
    }
}
