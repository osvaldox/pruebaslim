<?php

declare(strict_types=1);

use App\Repository\UserRepository;
use App\Repository\ProductoRepository;
use Psr\Container\ContainerInterface;

$container['user_repository'] = static fn (ContainerInterface $container): UserRepository => new UserRepository($container->get('db'));

$container['producto_repository'] = static fn (ContainerInterface $container): ProductoRepository => new ProductoRepository($container->get('db'));
