<?php

declare(strict_types=1);

namespace Shlinkio\Shlink\Config\Factory;

use ArrayAccess;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Factory\AbstractFactoryInterface;
use Shlinkio\Shlink\Config\Exception\InvalidArgumentException;

use function array_key_exists;
use function array_shift;
use function explode;
use function is_array;
use function sprintf;
use function str_contains;

class DottedAccessConfigAbstractFactory implements AbstractFactoryInterface
{
    public function canCreate(ContainerInterface $container, $requestedName): bool // phpcs:ignore
    {
        return str_contains($requestedName, '.');
    }

    /**
     * @param string $requestedName
     */
    // phpcs:ignore
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): mixed
    {
        $parts = explode('.', $requestedName);
        $serviceName = array_shift($parts);
        if (! $container->has($serviceName)) {
            throw new ServiceNotCreatedException(sprintf(
                'Defined service "%s" could not be found in container after resolving dotted expression "%s".',
                $serviceName,
                $requestedName,
            ));
        }

        $array = $container->get($serviceName);
        if (! is_array($array) && ! $array instanceof ArrayAccess) {
            throw new ServiceNotCreatedException(sprintf(
                'Defined service "%s" does not return an array or ArrayAccess after resolving dotted expression "%s".',
                $serviceName,
                $requestedName,
            ));
        }

        return $this->readKeysFromArray($parts, $array);
    }

    /**
     * @throws InvalidArgumentException
     */
    private function readKeysFromArray(array $keys, array|ArrayAccess $array): mixed
    {
        $key = array_shift($keys);

        // As soon as one of the provided keys is not found, throw an exception
        if (! $this->keyExists($key, $array)) {
            throw new InvalidArgumentException(sprintf(
                'The key "%s" provided in the dotted notation could not be found in the array service',
                $key,
            ));
        }

        $value = $array[$key];
        if (! empty($keys) && (is_array($value) || $value instanceof ArrayAccess)) {
            $value = $this->readKeysFromArray($keys, $value);
        }

        return $value;
    }

    private function keyExists(string $key, array|ArrayAccess $array): bool
    {
        return is_array($array) ? array_key_exists($key, $array) : $array->offsetExists($key);
    }
}
