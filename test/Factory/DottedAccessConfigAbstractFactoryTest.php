<?php

declare(strict_types=1);

namespace ShlinkioTest\Shlink\Config\Factory;

use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\ServiceManager;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;
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

    #[Test]
    #[TestWith(['foo.bar', true], 'valid service')]
    #[TestWith(['config.something', true], 'another valid service')]
    #[TestWith(['config_something', false], 'invalid service')]
    #[TestWith(['foo', false], 'another invalid service')]
    public function canCreateOnlyServicesWithDot(string $serviceName, bool $canCreate): void
    {
        self::assertEquals($canCreate, $this->factory->canCreate(new ServiceManager(), $serviceName));
    }

    #[Test]
    public function throwsExceptionWhenFirstPartOfTheServiceIsNotRegistered(): void
    {
        $this->expectException(ServiceNotCreatedException::class);
        $this->expectExceptionMessage(
            'Defined service "foo" could not be found in container after resolving dotted expression "foo.bar"',
        );

        $this->factory->__invoke(new ServiceManager(), 'foo.bar');
    }

    #[Test]
    #[TestWith(['string'], 'string')]
    #[TestWith([new stdClass()], 'object')]
    #[TestWith([true], 'true')]
    #[TestWith([false], 'false')]
    #[TestWith([100], 'number')]
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

    #[Test]
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

    #[Test]
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
