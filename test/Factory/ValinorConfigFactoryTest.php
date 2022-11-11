<?php

declare(strict_types=1);

namespace ShlinkioTest\Shlink\Config\Factory;

use CuyZ\Valinor\Mapper\MappingError;
use Laminas\ServiceManager\ServiceManager;
use PHPUnit\Framework\TestCase;
use Shlinkio\Shlink\Config\Factory\ValinorConfigFactory;
use ShlinkioTest\Shlink\Config\Model\FooModel;

class ValinorConfigFactoryTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideConfigs
     */
    public function mapsObjectAsExpected(array $config, string $configKey, callable $assert): void
    {
        $serviceManager = new ServiceManager(['services' => [
            $configKey => $config,
        ]]);

        $result = ValinorConfigFactory::{$configKey}($serviceManager, FooModel::class);

        self::assertInstanceOf(FooModel::class, $result);
        $assert($result);
    }

    public function provideConfigs(): iterable
    {
        yield 'ignored keys' => [[
            'foo' => 'the_value',
            'this_will_be_ignored' => 'bar',
        ], 'config', function (FooModel $model): void {
            self::assertEquals('the_value', $model->foo);
            self::assertEquals(30, $model->withCamelCase);
            self::assertFalse($model->bar);
            self::assertEmpty($model->listOfStuff);
            self::assertEmpty($model->listOfNumbers);
        }];
        yield 'lists' => [[
            'foo' => 'bar',
            'listOfStuff' => ['foo', 'bar'],
            'listOfNumbers' => [5.5, 8.3],
        ], 'foo', function (FooModel $model): void {
            self::assertEquals('bar', $model->foo);
            self::assertEquals(['foo', 'bar'], $model->listOfStuff);
            self::assertEquals([5.5, 8.3], $model->listOfNumbers);
        }];
        yield 'camelCase mapping' => [[
            'foo' => 'bar',
            'with_camel_case' => 200,
            'list of stuff' => ['foo', 'bar'],
            'list-of-numbers' => [5.5, 8.3],
        ], 'foo', function (FooModel $model): void {
            self::assertEquals('bar', $model->foo);
            self::assertEquals(['foo', 'bar'], $model->listOfStuff);
            self::assertEquals([5.5, 8.3], $model->listOfNumbers);
        }];
    }

    /**
     * @test
     * @dataProvider provideInvalidConfig
     */
    public function throwsExceptionWhenTryingToMapInvalidData(array $config): void
    {
        $serviceManager = new ServiceManager(['services' => [
            'config' => $config,
        ]]);

        $this->expectException(MappingError::class);
        ValinorConfigFactory::config($serviceManager, FooModel::class);
    }

    public function provideInvalidConfig(): iterable
    {
        yield 'missing required prop' => [[]];
        yield 'invalid type' => [['foo' => 'bar', 'withCamelCase' => 'foo']];
        yield 'invalid list type' => [['foo' => 'bar', 'listOfStuff' => 'foo']];
        yield 'invalid list inner type' => [['foo' => 'bar', 'listOfStuff' => [true, false, 1]]];
    }
}
