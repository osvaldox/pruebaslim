<?php

declare(strict_types=1);

namespace App\Service\Producto;

final class Delete extends Base
{
    public function delete(int $productoId): void
    {
        $this->getOneFromDb($productoId);
        $this->productoRepository->deleteProducto($productoId);
        if (self::isRedisEnabled() === true) {
            $this->deleteFromCache($productoId);
        }
    }
}
