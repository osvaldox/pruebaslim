<?php

declare(strict_types=1);

namespace App\Service\Producto;

final class Find extends Base
{
    public function getAll(): array
    {
        return $this->productoRepository->getProductos();
    }

    public function getProductosByPage(
        int $page,
        int $perPage,
        ?string $name,
        ?string $description
    ): array {
        if ($page < 1) {
            $page = 1;
        }
        if ($perPage < 1) {
            $perPage = self::DEFAULT_PER_PAGE_PAGINATION;
        }

        return $this->productoRepository->getProductosByPage(
            $page,
            $perPage,
            $name,
            $description
        );
    }

    public function getOne(int $productoId): object
    {
        if (self::isRedisEnabled() === true) {
            $producto = $this->getOneFromCache($productoId);
        } else {
            $producto = $this->getOneFromDb($productoId)->toJson();
        }

        return $producto;
    }
}
