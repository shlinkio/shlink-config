<?php

declare(strict_types=1);

namespace ShlinkioTest\Shlink\Config\Factory;

use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\ServiceManager;
use PHPUnit\Framework\TestCase;
use Shlinkio\Shlink\Config\Exception\InvalidArgumentException;
use Shlinkio\Shlink\Config\Factory\DottedAccessConfigAbstractFactory;
use stdClass;

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

    public static function provideDotNames(): iterable
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
     * @dataProvider provideNonArrayValues
     */
    public function throwsExceptionWhenFirstPartOfTheServiceDoesNotResultInAnArray(mixed $value): void
    {
        $this->expectException(ServiceNotCreatedException::class);
        $this->expectExceptionMessage(
            'Defined service "a" does not return an array or ArrayAccess after resolving dotted expression "a.bar".',
        );

        $this->factory->__invoke(new ServiceManager(['services' => [
            'a' => $value,
        ]]), 'a.bar');
    }

    public static function provideNonArrayValues(): iterable
    {
        yield 'string' => ['string'];
        yield 'object' => [new stdClass()];
        yield 'true' => [true];
        yield 'false' => [false];
        yield 'number' => [100];
    }

    /** @test */
    public function dottedNotationIsRecursivelyResolvedUntilLastValueIsFoundAndReturned(): void
    {
        $a = new stdClass();
        $b = new stdClass();
        $sm = new ServiceManager(['services' => [
            'foo' => [
                'bar' => [
                    'baz' => $a,
                    'biz' => $b,
                ],
            ],
        ]]);

        self::assertSame($a, $this->factory->__invoke($sm, 'foo.bar.baz'));
        self::assertSame($b, $this->factory->__invoke($sm, 'foo.bar.biz'));
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
