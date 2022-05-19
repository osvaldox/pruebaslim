<?php

declare(strict_types=1);

namespace App\Service\Producto;

use App\Entity\Producto;
use App\Repository\ProductoRepository;
use App\Service\BaseService;
use App\Service\RedisService;
use Respect\Validation\Validator as v;

abstract class Base extends BaseService
{
    private const REDIS_KEY = 'producto:%s';

    protected ProductoRepository $productoRepository;

    protected RedisService $redisService;

    public function __construct(
        ProductoRepository $productoRepository,
        RedisService $redisService
    ) {
        $this->productoRepository = $productoRepository;
        $this->redisService = $redisService;
    }

    protected static function validateProductoName(string $name): string
    {
        if (! v::length(1, 50)->validate($name)) {
            throw new \App\Exception\Producto('The name of the product is invalid.', 400);
        }

        return $name;
    }

    protected function getOneFromCache(int $productoId): object
    {
        $redisKey = sprintf(self::REDIS_KEY, $productoId);
        $key = $this->redisService->generateKey($redisKey);
        if ($this->redisService->exists($key)) {
            $producto = $this->redisService->get($key);
        } else {
            $producto = $this->getOneFromDb($productoId)->toJson();
            $this->redisService->setex($key, $producto);
        }

        return $producto;
    }

    protected function getOneFromDb(int $productoId): Producto
    {
        return $this->productoRepository->checkAndGetProducto($productoId);
    }

    protected function saveInCache(int $id, object $producto): void
    {
        $redisKey = sprintf(self::REDIS_KEY, $id);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->setex($key, $producto);
    }

    protected function deleteFromCache(int $productoId): void
    {
        $redisKey = sprintf(self::REDIS_KEY, $productoId);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->del([$key]);
    }
}
