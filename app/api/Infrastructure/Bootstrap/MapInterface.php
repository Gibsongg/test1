<?php
declare(strict_types=1);

namespace Infrastructure\Bootstrap;
use DI\ContainerBuilder;

class MapInterface
{
    public static function bootstrap()
    {
        $container = ContainerBuilder::buildDevContainer();
        $container->set(Domain\Repository\IMemberRepository::class, \DI\create(Infrastructure\Repository\MemberRepository::class));
        $container->set(Domain\Repository\IMemberRepository::class, \DI\create(Infrastructure\Repository\MemberRepository::class));
        return $container;
    }
}