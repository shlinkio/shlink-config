<?php

declare(strict_types=1);

namespace ShlinkioTest\Shlink\Config\Factory;

use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\ServiceManager;
use PHPUnit\Framework\TestCase;
use Shlinkio\Shlink\Config\Exception\InvalidArgumentException;
use Shlinkio\Shlink\Config\Factory\DottedAccessConfigAbstractFactory;

class DottedAccessConfigAbstractFactoryTest extends TestCase
{
    private DottedAccessConfigAbstractFactory $factory;

    public function setUp(): void
    {
        $this->factory = new DottedAccessConfigAbstractFactory();
    }

    /**
     * @test
     * @dataProvider provideDotNames
     */
    public function canCreateOnlyServicesWithDot(string $serviceName, bool $canCreate): void
    {
        self::assertEquals($canCreate, $this->factory->canCreate(new ServiceManager(), $serviceName));
    }

    public function provideDotNames(): iterable
    {
        yield 'with a valid service' => ['foo.bar', true];
        yield 'with another valid service' => ['config.something', true];
        yield 'with an invalid service' => ['config_something', false];
        yield 'with another invalid service' => ['foo', false];
    }

    /** @test */
    public function throwsExceptionWhenFirstPartOfTheServiceIsNotRegistered(): void
    {
        $this->expectException(ServiceNotCreatedException::class);
        $this->expectExceptionMessage(
            'Defined service "foo" could not be found in container after resolving dotted expression "foo.bar"',
        );

        $this->factory->__invoke(new ServiceManager(), 'foo.bar');
    }

    /**
     * @test
     * @dataProvider provideDotValues
     */
    public function dottedNotationIsRecursivelyResolvedUntilLastValueIsFoundAndReturned(
        string $serviceName,
        ?string $expected,
    ): void {
        $result = $this->factory->__invoke(new ServiceManager(['services' => [
            'foo' => [
                'bar' => [
                    'baz' => 'this is the result',
                    'nullable_baz' => null,
                ],
            ],
        ]]), $serviceName);

        self::assertEquals($expected, $result);
    }

    public function provideDotValues(): iterable
    {
        yield 'non-null value' => ['foo.bar.baz', 'this is the result'];
        yield 'null value' => ['foo.bar.nullable_baz', null];
    }

    /** @test */
    public function exceptionIsThrownIfAnyStepCannotBeResolved(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'The key "baz" provided in the dotted notation could not be found in the array service',
        );

        $this->factory->__invoke(new ServiceManager(['services' => [
            'foo' => [
                'bar' => ['something' => 123],
            ],
        ]]), 'foo.bar.baz');
    }
}
