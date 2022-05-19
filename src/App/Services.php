<?php

declare(strict_types=1);


use App\Service\Producto;
use App\Service\User;
use Psr\Container\ContainerInterface;

$container['find_user_service'] = static fn (ContainerInterface $container): User\Find => new User\Find(
    $container->get('user_repository'),
    $container->get('redis_service')
);

$container['create_user_service'] = static fn (ContainerInterface $container): User\Create => new User\Create(
    $container->get('user_repository'),
    $container->get('redis_service')
);

$container['update_user_service'] = static fn (ContainerInterface $container): User\Update => new User\Update(
    $container->get('user_repository'),
    $container->get('redis_service')
);

$container['delete_user_service'] = static fn (ContainerInterface $container): User\Delete => new User\Delete(
    $container->get('user_repository'),
    $container->get('redis_service')
);

$container['login_user_service'] = static fn (ContainerInterface $container): User\Login => new User\Login(
    $container->get('user_repository'),
    $container->get('redis_service')
);


$container['find_producto_service'] = static fn (ContainerInterface $container): Producto\Find => new Producto\Find(
    $container->get('producto_repository'),
    $container->get('redis_service')
);

$container['create_producto_service'] = static fn (ContainerInterface $container): Producto\Create => new Producto\Create(
    $container->get('producto_repository'),
    $container->get('redis_service')
);

$container['update_producto_service'] = static fn (ContainerInterface $container): Producto\Update => new Producto\Update(
    $container->get('producto_repository'),
    $container->get('redis_service')
);

$container['delete_producto_service'] = static fn (ContainerInterface $container): Producto\Delete => new Producto\Delete(
    $container->get('producto_repository'),
    $container->get('redis_service')
);
