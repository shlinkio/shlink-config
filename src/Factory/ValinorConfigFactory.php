<?php

declare(strict_types=1);

namespace Shlinkio\Shlink\Config\Factory;

use CuyZ\Valinor\Mapper\Source\Source;
use CuyZ\Valinor\Mapper\TreeMapper;
use CuyZ\Valinor\MapperBuilder;
use Psr\Container\ContainerInterface;
use Psr\SimpleCache\CacheInterface;

/** @deprecated */
class ValinorConfigFactory
{
    public static function __callStatic(string $name, array $arguments): mixed
    {
        /** @var ContainerInterface $container */
        /** @var string $serviceName */
        [$container, $serviceName] = $arguments;
        $mapper = self::getMapper($container);
        $options = $container->get($name);

        // @phpstan-ignore argument.type
        return $mapper->map($serviceName, Source::array($options)->camelCaseKeys());
    }

    private static function getMapper(ContainerInterface $container): TreeMapper
    {
        static $mapper;
        if ($mapper !== null) {
            return $mapper;
        }

        $mapper = (new MapperBuilder())->allowSuperfluousKeys();
        if ($container->has(CacheInterface::class)) {
            // @phpstan-ignore argument.type
            return $mapper = $mapper->withCache($container->get(CacheInterface::class))->mapper();
        }

        return $mapper = $mapper->mapper();
    }
}
